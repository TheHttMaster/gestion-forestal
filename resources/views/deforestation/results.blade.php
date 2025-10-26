<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">¡Éxito!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="font-semibold text-3xl text-gray-900 dark:text-gray-100 leading-tight mb-6">
                Resultados del Análisis de Deforestación
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg shadow-md border-l-4 border-blue-500">
                    <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Año de Análisis</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                        {{ $dataToPass['analysis_year'] }}
                    </p>
                </div>

                <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg shadow-md border-l-4 border-green-500">
                    <p class="text-sm font-medium text-green-600 dark:text-green-400">Área Deforestada</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                        {{ number_format($dataToPass['area__ha'], 6, ',', '.') }} ha
                    </p>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg shadow-md border-l-4 border-yellow-500">
                    <p class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Estado del Servicio GFW</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                        {{ $dataToPass['status'] }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <h3 class="font-semibold text-xl text-gray-900 dark:text-gray-100 mb-3">
                        Área de Interés
                    </h3>
                    <div id="result-map" style="height: 400px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        </div>
                </div>

                <div>
                    <h3 class="font-semibold text-xl text-gray-900 dark:text-gray-100 mb-3">
                        📊 Evolución de la Deforestación
                    </h3>
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-inner">
                        <canvas id="deforestation-chart"></canvas>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="font-semibold text-xl text-gray-900 dark:text-gray-100 mb-3">
                    🔍 Datos Crudos del Servicio
                </h3>
                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-inner">
                    <pre class="whitespace-pre-wrap font-mono text-sm text-gray-800 dark:text-gray-200">
                        {{-- Muestra todo el array stats (y otros datos si lo deseas) --}}
                        {!! $dataToPass['original_geojson'] !!}
                    </pre>
                </div>
            </div>

            <div class="mt-8 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('deforestation.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    &larr; Iniciar un Nuevo Análisis
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/build/ol.js"></script>

<script>
// =======================================================
// 🚨 Nota: Las variables del controlador original ($analyses y $polygon)
// no están disponibles. Usaremos $dataToPass['analysis_stats'] y la geometría
// que el controlador ha incluido en el array $dataToPass.
// =======================================================

// 1. Datos del Controlador (Usando $dataToPass)
const analysisData = @json($dataToPass['analysis_stats']['data'] ?? []); // Asumimos que las estadísticas están en 'data'
const polygonGeojson = @json($dataToPass['original_geojson'] ?? '{}'); // Usamos la cadena GeoJSON original

// 2. Preparación para el Gráfico
// Asumimos que analysisData tiene objetos con 'year', 'forest_area_ha', y 'deforested_area_ha'
const ctx = document.getElementById('deforestation-chart').getContext('2d');
if (analysisData.length > 0) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: analysisData.map(item => item.year),
            datasets: [{
                label: 'Área Boscosa (ha)',
                data: analysisData.map(item => item.forest_area_ha),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1,
                fill: true
            }, {
                label: 'Área Deforestada (ha)',
                data: analysisData.map(item => item.deforested_area_ha),
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.1,
                fill: true
            }]
        },
        // ... (resto de opciones de Chart.js)
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: 'Evolución de la Cobertura Forestal' },
                tooltip: { callbacks: { label: (context) => context.dataset.label + ': ' + context.parsed.y.toFixed(2) + ' ha' } }
            },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'Hectáreas' } },
                x: { title: { display: true, text: 'Años' } }
            }
        }
    });
} else {
    // Mostrar un mensaje si no hay datos para el gráfico
    ctx.canvas.parentNode.innerHTML = '<p class="text-center text-red-500">No hay datos de deforestación disponibles para mostrar el gráfico.</p>';
}


// 3. Mapa de resultados (OpenLayers)
function initResultMap() {
    const map = new ol.Map({
        target: 'result-map',
        layers: [
            new ol.layer.Tile({ source: new ol.source.OSM() })
        ],

        // MODIFICACIÓN CLAVE: Eliminar todos los controles predeterminados
        controls: ol.control.defaults({
            zoom: false,
            rotate: false,
            attribution: false
        }),

        view: new ol.View({
            center: ol.proj.fromLonLat([-63.176998053868616, 10.56217792404226]), // Centro inicial de ejemplo
            zoom: 6
        })
    });
    
    // Añadir el polígono al mapa
    const format = new ol.format.GeoJSON();
    
   // 🚩 Iniciaremos con la configuración estándar: Lon/Lat (EPSG:4326) -> EPSG:3857
    let features = format.readFeatures(polygonGeojson, {
        dataProjection: 'EPSG:4326', 
        featureProjection: 'EPSG:3857'
    });
    
    // =======================================================
    // 🧪 PASO 1: Depuración de la conversión
    // =======================================================
    if (features.length === 0) {
        console.error("OpenLayers no pudo leer las features con la configuración estándar.");
        
        // 🧪 PASO 2: Intentar invertir la proyección de datos a 'datos planos' 
        //           (a veces necesario si el GeoJSON no sigue estrictamente el estándar)
        features = format.readFeatures(polygonGeojson, {
            dataProjection: 'EPSG:3857', // FINGIMOS que los datos ya están en la proyección del mapa
            featureProjection: 'EPSG:3857'
        });

        if (features.length === 0) {
            console.error("Fallo al leer la geometría GeoJSON. La cadena de entrada podría ser inválida.");
        }
    }
    
    // 🧪 PASO 3: Imprimir el resultado de la conversión
    console.log("GeoJSON de entrada:", polygonGeojson);
    console.log("Características generadas (features):", features);
    
    if (features.length > 0) {
        const vectorLayer = new ol.layer.Vector({
            source: new ol.source.Vector({ features: features }),
            style: new ol.style.Style({
                stroke: new ol.style.Stroke({ color: 'blue', width: 3 }),
                fill: new ol.style.Fill({ color: 'rgba(0, 0, 255, 0.1)' })
            })
        });
        
        map.addLayer(vectorLayer);
        
        // Ajustar zoom al polígono (solo si hay features)
        map.getView().fit(vectorLayer.getSource().getExtent(), {
            padding: [50, 50, 50, 50],
            duration: 1000
        });
    }
}

// Inicializar mapa cuando el documento esté listo
if (document.getElementById('result-map')) {
    initResultMap();
}
</script>