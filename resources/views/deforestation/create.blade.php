<!-- resources/views/deforestation/create.blade.php -->
 
<x-app-layout>
    
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Análisis de Deforestación</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna del Mapa -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div id="map" style="height: 500px; border: 1px solid #e5e7eb; border-radius: 0.5rem;"></div>
                    <!-- BOTONES DE CONTROL AÑADIDOS AQUÍ -->
                    <div class="mt-4 flex space-x-2">
                        <button id="draw-polygon" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Dibujar Polígono
                        </button>
                        <button id="clear-map" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Limpiar Mapa
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Columna del Formulario -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">Configuración del Análisis</h2>
                
                <form id="analysis-form" action="{{ route('deforestation.analyze') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Área:</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               id="name" name="name" required placeholder="Ej: Reserva Natural XYZ">
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción:</label>
                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                  id="description" name="description" rows="3" placeholder="Descripción del área de estudio..."></textarea>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="start_year" class="block text-sm font-medium text-gray-700 mb-1">Año Inicio:</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                    id="start_year" name="start_year" required>
                                @for($i = 2018; $i <= 2023; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div>
                            <label for="end_year" class="block text-sm font-medium text-gray-700 mb-1">Año Fin:</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                    id="end_year" name="end_year" required>
                                @for($i = 2018; $i <= 2023; $i++)
                                    <option value="{{ $i }}" {{ $i == 2023 ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="import-area" class="block text-sm font-medium text-gray-700 mb-1">Importar área (GeoJSON, KML, SHP):</label>
                        <input type="file" id="import-area" accept=".geojson,.json,.kml,.shp,.zip,application/geo+json,application/vnd.google-earth.kml+xml,application/zip" class="block w-full text-sm text-gray-500" />
                    </div>
                    
                    <input type="hidden" name="geometry" id="geometry">
                    
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md flex items-center justify-center">
                        <span id="loading-spinner" class="d-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </span>
                        Analizar Deforestación
                    </button>
                </form>
                <!-- create.blade.php - Añadir después del formulario -->
                <div id="producers-info" class="mt-6 bg-gray-50 dark:bg-gray-800 p-4 rounded-lg hidden">
                    <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Información de Productores Importados</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Productor</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Localidad</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Área (Ha)</th>
                                </tr>
                            </thead>
                            <tbody id="producers-list" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <!-- Los datos se llenarán con JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div id="results" class="mt-4"></div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Incluir OpenLayers -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/css/ol.css">
<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/build/ol.js"></script>

<!-- Incluir nuestro JavaScript -->
<script src="{{ asset('js/deforestation/map.js') }}"></script>
<script>
document.getElementById('import-area').addEventListener('change', async function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const ext = file.name.split('.').pop().toLowerCase();

    // GeoJSON
    if (ext === 'geojson' || ext === 'json') {
        const reader = new FileReader();
        reader.onload = function(event) {
            try {
                const geojson = JSON.parse(event.target.result);
                window.deforestationMapInstance.importGeoJSON(geojson);
            } catch (err) {
                window.deforestationMapInstance.showAlert('Archivo GeoJSON inválido.', 'error');
            }
        };
        reader.readAsText(file);
    }
    // KML
    else if (ext === 'kml') {
        const reader = new FileReader();
        reader.onload = function(event) {
            try {
                const kmlText = event.target.result;
                window.deforestationMapInstance.importKML(kmlText);
            } catch (err) {
                window.deforestationMapInstance.showAlert('Archivo KML inválido.', 'error');
            }
        };
        reader.readAsText(file);
    }
    // SHP o ZIP (shapefile)
    else if (ext === 'shp' || ext === 'zip') {
        try {
            // shpjs espera un ArrayBuffer
            const arrayBuffer = await file.arrayBuffer();
            shp(arrayBuffer).then(function(geojson) {
                window.deforestationMapInstance.importGeoJSON(geojson);
            }).catch(function() {
                window.deforestationMapInstance.showAlert('Archivo SHP/ZIP inválido.', 'error');
            });
        } catch (err) {
            window.deforestationMapInstance.showAlert('Error al leer el archivo SHP/ZIP.', 'error');
        }
    }
    else {
        window.deforestationMapInstance.showAlert('Formato no soportado.', 'error');
    }
});
</script>