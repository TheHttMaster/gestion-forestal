<!-- resources/views/deforestation/create.blade.php -->
 
<x-app-layout>
    <div class="max-w-7xl mx-auto ">
        <div class="bg-stone-100/90 dark:bg-custom-gray  shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-8 mb-6">
            <div class="text-gray-900 dark:text-gray-100 ">
                <h2 class="font-semibold text-xl leading-tight ">
                    {{('Análisis de Deforestación') }}
                </h2>
   
                    <!-- CARGA DEL MAPA AQUÍ -->
                    <div id="map" style="height: 500px; border: 1px solid #dededeff; border-radius: 0.5rem; position: relative;">
                        <!-- Botón y menú de cambio de mapa, posicionado sobre el mapa -->
                        <div id="map-controls">
                            <!-- Botón de cambio de mapa -->
                            <button id="base-map-toggle" class="bg-gray-600 hover:bg-gray-700 text-white px-2 py-1 rounded-lg flex items-center shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                                Cambiar Mapa
                            </button>
                            <!-- Menú de cambio de mapa -->
                            <div id="base-map-menu"
                                 class="absolute mt-3 w-44 rounded-xl shadow-lg bg-white dark:bg-custom-gray ring-1 ring-black ring-opacity-5 z-10000 right-0
                                        transition-all duration-400 ease-out scale-95 opacity-0 pointer-events-none">
                                <!-- Flechita -->
                                <div class="absolute -top-2 right-6 w-4 h-2 z-100000 pointer-events-none">
                                    <svg viewBox="0 0 16 8" class="w-4 h-2 text-white dark:text-custom-gray">
                                        <polygon points="8,0 16,8 0,8" fill="currentColor"/>
                                    </svg>
                                </div>
                                <!-- Menú -->
                                <div class="py-2 z-10000" role="menu" aria-orientation="vertical">
                                    <button data-layer="osm" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-200" role="menuitem">OpenStreetMap</button>
                                    <button data-layer="satellite" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-200" role="menuitem">Satélite</button>
                                    <button data-layer="terrain" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-200" role="menuitem">Relieve</button>
                                    <button data-layer="dark" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-200" role="menuitem">Oscuro</button>
                                </div>
                            </div>

                            <!-- Botón para formulario manual -->
                            <button id="manual-polygon-toggle" class="bg-gray-600 hover:bg-gray-700 text-white px-2 py-1 rounded-lg flex items-center shadow-lg ml-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Polígono Manual
                            </button>
                            <!-- Menú/formulario desplegable para polígono manual -->
                            <div id="manual-polygon-menu"
                                 class="absolute mt-3 w-80 rounded-xl shadow-lg bg-white dark:bg-custom-gray ring-1 ring-black ring-opacity-5 z-10000 right-0
                                        transition-all duration-400 ease-out scale-95 opacity-0 pointer-events-none">
                                <!-- Flechita -->
                                <div class="absolute -top-2 right-6 w-4 h-2 z-100000 pointer-events-none">
                                    <svg viewBox="0 0 16 8" class="w-4 h-2 text-white dark:text-custom-gray">
                                        <polygon points="8,0 16,8 0,8" fill="currentColor"/>
                                    </svg>
                                </div>
                                <!-- Formulario manual -->
                                <form id="manual-polygon-form" class="p-4 space-y-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Coordenadas (lat,lon por línea):</label>
                                    <textarea id="manual-coords" rows="4" class="block w-full rounded-md border-gray-300 dark:bg-custom-gray dark:text-gray-100 text-xs" placeholder="Ejemplo:
                                        8.123,-66.123
                                        8.124,-66.124
                                        8.125,-66.125
                                        8.123,-66.123">
                                    </textarea>
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                                        Dibujar Polígono
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- BOTONES DE CONTROL AÑADIDOS -->
                    <div class="mt-4 flex space-x-2">
                        <button id="draw-polygon" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Dibujar Polígono
                        </button>
                        <button id="clear-map" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Limpiar Mapa
                        </button>
                       
                        
                    </div>
                </div>
            </div>
            
            <!-- Columna del Formulario -->
            <div class="bg-stone-100/90 dark:bg-custom-gray overflow-hidden shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-8 ">
                <div class="text-gray-900 dark:text-gray-100 ">
                    <h2 class="text-lg font-semibold mb-4">Configuración del Análisis</h2>
                    
                    <form id="analysis-form" action="{{ route('deforestation.analyze') }}" method="POST">
                        @csrf
                        
                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Nombre del Área:')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autocomplete="name" placeholder="Ej: Reserva Natural XYZ" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Descripción:')" />
                            <textarea id="description" name="description" rows="2" class="block mt-1 w-full rounded-md border-gray-300 dark:bg-custom-gray dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 @error('address') border-red-500 @enderror" placeholder="Descripción del área de estudio..."></textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="start_year" class="block text-sm font-medium text-gray-700 mb-1">Año Inicio:</label>
                                <select class="block w-full bg-gray-200 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                        id="start_year" name="start_year" required>
                                    @for($i = 2018; $i <= 2023; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            
                            <div>
                                <label for="end_year" class="block text-sm font-medium text-gray-700 mb-1">Año Fin:</label>
                                <select class="block w-full bg-gray-200 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
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
<script>
// Mostrar menú
document.getElementById('base-map-toggle').addEventListener('click', function() {
    const menu = document.getElementById('base-map-menu');
    menu.classList.toggle('show');
    if (menu.classList.contains('show')) {
        menu.classList.remove('scale-95', 'opacity-0', 'pointer-events-none');
        menu.classList.add('scale-100', 'opacity-100', 'pointer-events-auto');
    } else {
        menu.classList.remove('scale-100', 'opacity-100', 'pointer-events-auto');
        menu.classList.add('scale-95', 'opacity-0', 'pointer-events-none');
    }
});

// Cerrar menú al hacer clic fuera
document.addEventListener('click', function(e) {
    const toggle = document.getElementById('base-map-toggle');
    const menu = document.getElementById('base-map-menu');
    if (!toggle.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove('show', 'scale-100', 'opacity-100', 'pointer-events-auto');
        menu.classList.add('scale-95', 'opacity-0', 'pointer-events-none');
    }
});

// Cambiar capa base
document.querySelectorAll('#base-map-menu button').forEach(button => {
    button.addEventListener('click', function() {
        const layerKey = this.getAttribute('data-layer');
        window.deforestationMapInstance.changeBaseLayer(layerKey);
        document.getElementById('base-map-menu').classList.remove('show');
    });
});
</script>
<script>
// Mostrar/ocultar formulario manual
document.getElementById('manual-polygon-toggle').addEventListener('click', function(e) {
    e.stopPropagation();
    const menu = document.getElementById('manual-polygon-menu');
    menu.classList.toggle('show');
    if (menu.classList.contains('show')) {
        menu.classList.remove('scale-95', 'opacity-0', 'pointer-events-none');
        menu.classList.add('scale-100', 'opacity-100', 'pointer-events-auto');
    } else {
        menu.classList.remove('scale-100', 'opacity-100', 'pointer-events-auto');
        menu.classList.add('scale-95', 'opacity-0', 'pointer-events-none');
    }
});

// Cerrar menú manual al hacer clic fuera
document.addEventListener('click', function(e) {
    const toggle = document.getElementById('manual-polygon-toggle');
    const menu = document.getElementById('manual-polygon-menu');
    if (!toggle.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove('show', 'scale-100', 'opacity-100', 'pointer-events-auto');
        menu.classList.add('scale-95', 'opacity-0', 'pointer-events-none');
    }
});

// Dibujar polígono manual
document.getElementById('manual-polygon-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const coordsText = document.getElementById('manual-coords').value.trim();
    if (!coordsText) {
        window.deforestationMapInstance.showAlert('Debes ingresar al menos 3 coordenadas.', 'warning');
        return;
    }
    // Procesar coordenadas
    const coords = [];
    coordsText.split('\n').forEach(line => {
        const parts = line.split(',').map(s => s.trim());
        if (parts.length === 2 && !isNaN(Number(parts[0])) && !isNaN(Number(parts[1]))) {
            // El usuario ingresa lat,lon pero OpenLayers espera lon,lat
            coords.push([Number(parts[1]), Number(parts[0])]);
        }
    });
    if (coords.length < 3) {
        window.deforestationMapInstance.showAlert('Debes ingresar al menos 3 coordenadas válidas.', 'warning');
        return;
    }
    // Cerrar el polígono si no está cerrado
    if (coords[0][0] !== coords[coords.length-1][0] || coords[0][1] !== coords[coords.length-1][1]) {
        coords.push(coords[0]);
    }
    // Crear el polígono y agregarlo al mapa
    const feature = new ol.Feature({
        geometry: new ol.geom.Polygon([coords]).transform('EPSG:4326', 'EPSG:3857')
    });
    window.deforestationMapInstance.clearMap();
    window.deforestationMapInstance.source.addFeature(feature);
    // Centrar el mapa en el polígono
    window.deforestationMapInstance.map.getView().fit(
        feature.getGeometry().getExtent(),
        { padding: [50, 50, 50, 50], duration: 1000 }
    );
    window.deforestationMapInstance.convertToGeoJSON(feature);
    window.deforestationMapInstance.showAlert('Polígono dibujado manualmente.', 'success');
    // Cierra el menú
    const menu = document.getElementById('manual-polygon-menu');
    menu.classList.remove('show', 'scale-100', 'opacity-100', 'pointer-events-auto');
    menu.classList.add('scale-95', 'opacity-0', 'pointer-events-none');
});
</script>

