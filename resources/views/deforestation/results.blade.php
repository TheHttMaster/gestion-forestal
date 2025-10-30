<x-app-layout>
    <div class="mx-auto ">
        <div class="bg-stone-100/90 dark:bg-custom-gray overflow-hidden shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-8 ">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">¡Éxito!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class=" overflow-hidden ">
                <h2 class="font-semibold text-3xl text-gray-900 dark:text-gray-100 leading-tight mb-6">
                    Resultados del Análisis de Deforestación
                </h2>

                <!-- Información del Área de Estudio -->
                <div class="mb-8 p-4 bg-blue-50 dark:bg-gray-600/10 rounded-lg">
                    <h3 class="font-semibold text-xl text-blue-800 dark:text-blue-200 mb-2">
                        {{ $dataToPass['polygon_name'] }}
                    </h3>
                    @if($dataToPass['description'])
                        <p class="text-blue-700 dark:text-blue-300">{{ $dataToPass['description'] }}</p>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-blue-100 dark:bg-blue-900/40 p-4 rounded-lg shadow-md border-l-4 border-blue-500">
                        <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Año de Análisis</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                            {{ $dataToPass['analysis_year'] }}
                        </p>
                    </div>

                    <div class="bg-green-100 dark:bg-green-900/50 p-4 rounded-lg shadow-md border-l-4 border-green-500">
                        <p class="text-sm font-medium text-green-600 dark:text-green-400">Área Total del Polígono</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                            {{ number_format($dataToPass['polygon_area_ha'], 2, ',', '.') }} ha
                        </p>
                    </div>

                    <div class="bg-red-100 dark:bg-red-900/60 p-4 rounded-lg shadow-md border-l-4 border-red-500">
                        <p class="text-sm font-medium text-red-600 dark:text-red-400">Área Deforestada</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                            {{ number_format($dataToPass['area__ha'], 6, ',', '.') }} ha
                        </p>
                    </div>

                    <div class="bg-yellow-100 dark:bg-yellow-800/60 p-4 rounded-lg shadow-md border-l-4 border-yellow-500">
                        <p class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Porcentaje Deforestado</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                            @php
                                $percentage = $dataToPass['polygon_area_ha'] > 0 
                                    ? ($dataToPass['area__ha'] / $dataToPass['polygon_area_ha']) * 100 
                                    : 0;
                            @endphp
                            {{ number_format($percentage, 2, ',', '.') }}%
                        </p>
                    </div>
                </div>

                <!-- Resumen Estadístico -->
                <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 dark:bg-gray-800/40 p-4 rounded-lg">
                        <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-3">Resumen del Área</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-300">Área total analizada:</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ number_format($dataToPass['polygon_area_ha'], 2, ',', '.') }} ha</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-300">Pérdida de cobertura:</span>
                                <span class="font-medium text-red-600 dark:text-red-400">{{ number_format($dataToPass['area__ha'], 6, ',', '.') }} ha</span>
                            </div>
                            <div class="flex justify-between border-t pt-2">
                                <span class="text-gray-600 dark:text-gray-300">Área conservada:</span>
                                @php
                                    $conservedArea = $dataToPass['polygon_area_ha'] - $dataToPass['area__ha'];
                                @endphp
                                <span class="font-medium text-green-600 dark:text-green-400">{{ number_format($conservedArea, 6, ',', '.') }} ha</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800/40 p-4 rounded-lg">
                        <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-3">Estado del Servicio</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-300">Estado:</span>
                                <span class="font-medium @if($dataToPass['status'] === 'success') text-green-600 @else text-red-600 @endif">
                                    {{ $dataToPass['status'] }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-300">Tipo de geometría:</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $dataToPass['type'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="font-semibold text-xl text-gray-900 dark:text-gray-100">
                                Área de Interés
                            </h3>
                            <!-- Controles del mapa -->
                            <div class="flex space-x-2">
                                <!-- Botón para mostrar/ocultar capa de deforestación -->
                                <button id="toggle-gfw-layer" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-lg flex items-center shadow-lg" title="Ocultar Deforestación">
                                    <span id="gfw-eye-open">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </span>
                                    <span id="gfw-eye-closed" class="hidden">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                                            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                                            <line x1="2" x2="22" y1="2" y2="22"/>
                                        </svg>
                                    </span>
                                </button>

                                <!-- Control de opacidad -->
                                <div class="relative">
                                    <button id="result-opacity-control" title="Ajustar Opacidad" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-lg flex items-center shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"/>
                                            <path d="m22 17.46-8.58-3.91a2 2 0 0 0-1.66 0L3 17.46"/>
                                            <path d="m22 12.46-8.58-3.91a2 2 0 0 0-1.66 0L3 12.46"/>
                                        </svg>
                                    </button>
                                    
                                    <!-- Panel de control de opacidad -->
                                    <div id="result-opacity-panel" 
                                        class="absolute mt-2 w-48 rounded-xl shadow-lg bg-gray-50 dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-10 right-0
                                                transition-all duration-400 ease-out scale-95 opacity-0 pointer-events-none">
                                        <div class="absolute -top-2 right-6 w-4 h-2 z-100 pointer-events-none">
                                            <svg viewBox="0 0 16 8" class="w-4 h-2 text-white dark:text-gray-800">
                                                <polygon points="8,0 16,8 0,8" fill="currentColor"/>
                                            </svg>
                                        </div>
                                        
                                        <!-- Contenido del panel -->
                                        <div class="p-4 z-100">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Opacidad GFW</span>
                                                <span id="result-opacity-value" class="text-xs font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">75%</span>
                                            </div>
                                            
                                            <!-- Slider de opacidad -->
                                            <input type="range" 
                                                id="result-opacity-slider" 
                                                min="0" 
                                                max="100" 
                                                value="75"
                                                class="w-full h-2 bg-gray-200 dark:bg-gray-600 rounded-lg appearance-none cursor-pointer slider-thumb">
                                            
                                            <!-- Botones predefinidos -->
                                            <div class="flex space-x-2 mt-3">
                                                <button type="button" data-opacity="25" class="flex-1 py-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded text-xs">
                                                    25%
                                                </button>
                                                <button type="button" data-opacity="50" class="flex-1 py-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded text-xs">
                                                    50%
                                                </button>
                                                <button type="button" data-opacity="75" class="flex-1 py-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded text-xs">
                                                    75%
                                                </button>
                                                <button type="button" data-opacity="100" class="flex-1 py-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded text-xs">
                                                    100%
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="result-map" style="height: 400px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); position: relative;">
                        </div>
                    </div>

                    <div>
                        <h3 class="font-semibold text-xl text-gray-900 dark:text-gray-100 mb-3">
                            Distribución del Área
                        </h3>
                        <div class="bg-gray-100 dark:bg-gray-800/40 p-4 rounded-lg shadow-inner">
                            <canvas id="area-distribution-chart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Datos Técnicos -->
                <div class="mt-8">
                    <h3 class="font-semibold text-xl text-gray-900 dark:text-gray-100 mb-3">
                        Datos Técnicos del Análisis
                    </h3>
                    <div class="bg-gray-100 dark:bg-gray-800/40 p-4 rounded-lg shadow-inner">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-2">Información del Polígono</h4>
                                <pre class="whitespace-pre-wrap font-mono text-xs text-gray-600 dark:text-gray-400">
    Nombre: {{ $dataToPass['polygon_name'] }}
    Área total: {{ number_format($dataToPass['polygon_area_ha'], 2, ',', '.') }} ha
    Tipo: {{ $dataToPass['type'] }}
    Vértices: {{ count($dataToPass['geometry']) }}
                                </pre>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-2">Resultados GFW</h4>
                                <pre class="whitespace-pre-wrap font-mono text-xs text-gray-600 dark:text-gray-400">
    Año análisis: {{ $dataToPass['analysis_year'] }}
    Área deforestada: {{ number_format($dataToPass['area__ha'], 6, ',', '.') }} ha
    Estado: {{ $dataToPass['status'] }}
    Porcentaje: {{ number_format($percentage, 2, ',', '.') }}%
                                </pre>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('deforestation.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white  bg-blue-600 dark:bg-blue-800 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        Iniciar un Nuevo Análisis
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/build/ol.js"></script>

<script>
// Datos para el gráfico de distribución
const polygonArea = @json($dataToPass['polygon_area_ha']);
const deforestedArea = @json($dataToPass['area__ha']);
const conservedArea = polygonArea - deforestedArea;

// Gráfico de distribución del área
const ctx = document.getElementById('area-distribution-chart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Área Conservada', 'Área Deforestada'],
        datasets: [{
            data: [conservedArea, deforestedArea],
            backgroundColor: [
                'rgba(75, 192, 192, 0.8)',
                'rgba(255, 99, 132, 0.8)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const value = context.parsed;
                        const percentage = ((value / polygonArea) * 100).toFixed(2);
                        return `${context.label}: ${value.toFixed(2)} ha (${percentage}%)`;
                    }
                }
            }
        }
    }
});

// Mapa de resultados (OpenLayers)
let resultMap = null;
let gfwLossLayer = null;

function initResultMap() {
    const polygonGeojson = @json($dataToPass['original_geojson'] ?? '{}');
    
    resultMap = new ol.Map({
        target: 'result-map',
        layers: [
            new ol.layer.Tile({ 
                source: new ol.source.OSM() 
            })
        ],
        controls: ol.control.defaults({
            zoom: false,
            rotate: false,
            attribution: false
        }),
        view: new ol.View({
            center: ol.proj.fromLonLat([-63.176998053868616, 10.56217792404226]),
            zoom: 6
        })
    });
    
    // Añadir el polígono al mapa
    const format = new ol.format.GeoJSON();
    
    let features = format.readFeatures(polygonGeojson, {
        dataProjection: 'EPSG:4326', 
        featureProjection: 'EPSG:3857'
    });
    
    if (features.length === 0) {
        features = format.readFeatures(polygonGeojson, {
            dataProjection: 'EPSG:3857',
            featureProjection: 'EPSG:3857'
        });
    }
    
    if (features.length > 0) {
        const vectorLayer = new ol.layer.Vector({
            source: new ol.source.Vector({ features: features }),
            style: new ol.style.Style({
                stroke: new ol.style.Stroke({ 
                    color: 'rgba(59, 130, 246, 0.8)', 
                    width: 3 
                }),
                fill: new ol.style.Fill({ 
                    color: 'rgba(59, 130, 246, 0.2)' 
                })
            })
        });
        
        resultMap.addLayer(vectorLayer);
        
        // Ajustar zoom al polígono
        resultMap.getView().fit(vectorLayer.getSource().getExtent(), {
            padding: [50, 50, 50, 50],
            duration: 1000
        });
    }

    // Añadir capa GFW (INICIALMENTE VISIBLE)
    const GFW_LOSS_URL = 'https://tiles.globalforestwatch.org/umd_tree_cover_loss/latest/dynamic/{z}/{x}/{y}.png';
    
    gfwLossLayer = new ol.layer.Tile({
        source: new ol.source.XYZ({
            url: GFW_LOSS_URL,
            attributions: 'Hansen/UMD/Google/USGS/NASA | GFW',
        }),
        opacity: 0.75,
        visible: true // Visible por defecto
    });
    
    resultMap.addLayer(gfwLossLayer);
}

// Funciones para controles del mapa
function toggleOpacityPanel(show) {
    const panel = document.getElementById('result-opacity-panel');
    
    if (show) {
        panel.classList.remove('scale-95', 'opacity-0', 'pointer-events-none');
        panel.classList.add('scale-100', 'opacity-100', 'pointer-events-auto', 'show');
    } else {
        panel.classList.remove('scale-100', 'opacity-100', 'pointer-events-auto', 'show');
        panel.classList.add('scale-95', 'opacity-0', 'pointer-events-none');
    }
}

function updateOpacity(value) {
    const opacity = value / 100;
    
    if (gfwLossLayer) {
        gfwLossLayer.setOpacity(opacity);
    }
    
    // Actualizar la interfaz
    document.getElementById('result-opacity-value').textContent = `${value}%`;
    document.getElementById('result-opacity-slider').value = value;
    
    // Actualizar botones predefinidos
    document.querySelectorAll('#result-opacity-panel [data-opacity]').forEach(btn => {
        const btnOpacity = parseInt(btn.getAttribute('data-opacity'));
        if (btnOpacity === value) {
            btn.classList.add('bg-blue-600', 'text-white');
            btn.classList.remove('bg-gray-200', 'text-gray-700', 'dark:bg-gray-700', 'dark:text-gray-300');
        } else {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
        }
    });
    
    // Actualizar el track del slider visualmente
    const slider = document.getElementById('result-opacity-slider');
    const progress = (value / slider.max) * 100;
    slider.style.background = `linear-gradient(to right, #4f46e5 ${progress}%, #e5e7eb ${progress}%)`;
}

// Event listeners para controles del mapa
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar mapa
    if (document.getElementById('result-map')) {
        initResultMap();
    }

    // Toggle capa GFW
    document.getElementById('toggle-gfw-layer').addEventListener('click', function() {
        if (gfwLossLayer) {
            const isVisible = !gfwLossLayer.getVisible();
            gfwLossLayer.setVisible(isVisible);
            
            // Alternar iconos y título
            const iconOpen = document.getElementById('gfw-eye-open');
            const iconClosed = document.getElementById('gfw-eye-closed');
            
            if (isVisible) {
                iconOpen.classList.remove('hidden');
                iconClosed.classList.add('hidden');
                this.setAttribute('title', 'Ocultar Deforestación');
            } else {
                iconOpen.classList.add('hidden');
                iconClosed.classList.remove('hidden');
                this.setAttribute('title', 'Mostrar Deforestación');
            }
        }
    });

    // Control de opacidad
    document.getElementById('result-opacity-control').addEventListener('click', function(e) {
        e.stopPropagation();
        const panel = document.getElementById('result-opacity-panel');
        const isShowing = panel.classList.contains('show');
        toggleOpacityPanel(!isShowing);
    });

    // Slider de opacidad
    document.getElementById('result-opacity-slider').addEventListener('input', function(e) {
        updateOpacity(parseInt(e.target.value));
    });

    // Botones predefinidos de opacidad
    document.querySelectorAll('#result-opacity-panel [data-opacity]').forEach(button => {
        button.addEventListener('click', function() {
            const opacityValue = parseInt(this.getAttribute('data-opacity'));
            updateOpacity(opacityValue);
        });
    });

    // Cerrar panel de opacidad al hacer clic fuera
    document.addEventListener('click', function(e) {
        const opacityButton = document.getElementById('result-opacity-control');
        const opacityPanel = document.getElementById('result-opacity-panel');
        
        if (!opacityButton.contains(e.target) && !opacityPanel.contains(e.target)) {
            toggleOpacityPanel(false);
        }
    });

    // Inicializar opacidad
    setTimeout(() => {
        if (gfwLossLayer) {
            const currentOpacity = gfwLossLayer.getOpacity() * 100;
            updateOpacity(currentOpacity || 75);
        }
    }, 500);
});
</script>

<style>
/* Estilos para el slider de opacidad */
.slider-thumb::-webkit-slider-thumb {
    appearance: none;
    height: 16px;
    width: 16px;
    border-radius: 50%;
    background: #4f46e5;
    cursor: pointer;
    border: 2px solid #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.3);
}

.slider-thumb::-moz-range-thumb {
    height: 16px;
    width: 16px;
    border-radius: 50%;
    background: #4f46e5;
    cursor: pointer;
    border: 2px solid #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.3);
}
</style>