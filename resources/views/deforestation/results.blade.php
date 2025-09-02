<!-- resources/views/deforestation/results.blade.php -->
<x-app-layout>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Resultados del Análisis: {{ $polygon->name }}</h1>
    
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="w-full lg:w-8/12">
            <!-- Gráfico de evolución -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Evolución de la Cobertura Forestal ({{ $analyses->first()->year }} - {{ $analyses->last()->year }})</h5>
                </div>
                <div class="p-6">
                    <canvas id="deforestation-chart" height="160"></canvas>
                </div>
            </div>
            
            <!-- Mapa del área analizada -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Área de Estudio</h5>
                </div>
                <div class="p-6">
                    <div class="card-body">
                        <div id="result-map" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            <!-- Mapa del área analizada -->
             <div class="card mt-3">
                <div class="card-header">
                    <h5>Área de Estudio</h5>
                </div>
               
            </div> 
        
        </div>
        
        <div class="w-full lg:w-12/8">
            <!-- Resumen estadístico -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Resumen del Análisis</h5>
                </div>
                <div class="p-6">
                     
                    <div class="space-y-3 mb-4">
                        <p class="text-gray-700 dark:text-gray-300"><strong class="text-gray-900 dark:text-white">Área total:</strong> {{ number_format($polygon->area_ha, 2) }} ha</p>
                        <p class="text-gray-700 dark:text-gray-300"><strong class="text-gray-900 dark:text-white">Período analizado:</strong> {{ $analyses->first()->year }} - {{ $analyses->last()->year }}</p>
                        <p class="text-gray-700 dark:text-gray-300"><strong class="text-gray-900 dark:text-white">Pérdida total:</strong> <span class="text-red-600 font-medium">{{ number_format($analyses->last()->deforested_area_ha, 2) }} ha</span></p>
                    </div>
                    
                    <hr class="my-4 border-gray-200 dark:border-gray-700">
                    
                    <h6 class="font-medium text-gray-900 dark:text-white mb-3">Detalle por Año:</h6>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Año</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bosque (ha)</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pérdida (ha)</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">% Pérdida</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($analyses as $analysis)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $analysis->year }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ number_format($analysis->forest_area_ha, 2) }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-red-600">{{ number_format($analysis->deforested_area_ha, 2) }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-red-600">{{ number_format($analysis->percentage_loss, 2) }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Botones de exportación -->
                    <div class="grid grid-cols-1 gap-3 mt-6">
                        <a href="{{ route('deforestation.export', $polygon->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-blue-500 rounded-md shadow-sm text-sm font-medium text-blue-600 dark:text-blue-400 bg-white dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-download mr-2"></i>
                            Exportar a GeoJSON
                        </a>
                        <a href="{{ route('deforestation.report', $polygon->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-green-500 rounded-md shadow-sm text-sm font-medium text-green-600 dark:text-green-400 bg-white dark:bg-gray-800 hover:bg-green-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            <i class="fas fa-file-pdf mr-2"></i>
                            Generar Reporte PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
<!-- Incluir Chart.js para gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Incluir OpenLayers para el mapa de resultados -->
<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/build/ol.js"></script>

<script>
// Datos para el gráfico
const analysisData = @json($analyses->values());
const polygonGeojson = @json($polygon->geojson);

// Configurar gráfico
const ctx = document.getElementById('deforestation-chart').getContext('2d');
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
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Evolución de la Cobertura Forestal'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + context.parsed.y.toFixed(2) + ' ha';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Hectáreas'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Años'
                }
            }
        }
    }
});

// Mapa de resultados
function initResultMap() {
    const map = new ol.Map({
        target: 'result-map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([-74.0, 4.6]), // Centrar en Colombia
            zoom: 6
        })
    });
    
    // Añadir el polígono al mapa
    const format = new ol.format.GeoJSON();
    const features = format.readFeatures(polygonGeojson, {
        featureProjection: 'EPSG:3857'
    });
    
    const vectorLayer = new ol.layer.Vector({
        source: new ol.source.Vector({
            features: features
        }),
        style: new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'blue',
                width: 3
            }),
            fill: new ol.style.Fill({
                color: 'rgba(0, 0, 255, 0.1)'
            })
        })
    });
    
    map.addLayer(vectorLayer);
    
    // Ajustar zoom al polígono
    map.getView().fit(vectorLayer.getSource().getExtent(), {
        padding: [50, 50, 50, 50],
        duration: 1000
    });
}

// Inicializar mapa cuando el documento esté listo
if (document.getElementById('result-map')) {
    initResultMap();
}
</script>
