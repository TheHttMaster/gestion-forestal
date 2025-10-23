<!-- resources/views/deforestation/create.blade.php -->

<x-app-layout>
    <div class=" mx-auto ">
        <div class="bg-stone-100/90 dark:bg-custom-gray  shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-6 mb-6">
            <div class="text-gray-900 dark:text-gray-100 ">
                <h3 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-gray-200 mb-2 md:mb-2">
                    {{('Análisis de Deforestación') }}
                </h2>
   
                    <!-- CARGA DEL MAPA AQUÍ -->
                    <div id="map" style="height: 80vh; border: 1px solid #dededeff; border-radius: 0.5rem; position: relative;">
                        <!-- Controles del mapa -->
                        <div id="map-controls">
                            <!-- Contenedor para los botones superiores (Cambiar Mapa y Pantalla Completa) -->
                            <div class="flex flex-col items-end space-y-2">
                                <!-- Fila superior: Cambiar Mapa y Pantalla Completa -->
                                <div class="flex space-x-2">

                                    {{-- boton para mostrar u ocultar areas en deforestacion --}}

                                    <div class="relative">
                                        <button id="visibility-toggle-button" class="bg-gray-600 hover:bg-gray-700 text-white px-2 py-1 rounded-lg flex items-center shadow-lg">
                                            <span id="icon-eye-open">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye w-6 h-6">
                                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                                    <circle cx="12" cy="12" r="3"/>
                                                </svg>
                                            </span>
                                            
                                            <span id="icon-eye-closed" class="hidden">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off w-6h-6">
                                                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                                    <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                                                    <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                                                    <line x1="2" x2="22" y1="2" y2="22"/>
                                                </svg>
                                            </span>
                                        </button>
                                    </div>

                                    {{-- ///////////////////////////////////////////////////// --}}

                                    <!-- Contenedor para Cambiar Mapa con menú -->
                                    <div class="relative">
                                        
                                        <!-- Botón de cambio de mapa -->
                                        <button id="base-map-toggle" title="Cambiar mapa" class="bg-gray-600 hover:bg-gray-700 text-white px-2 py-1 rounded-lg flex items-center shadow-lg">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                            </svg>
                                            Cambiar Mapa
                                        </button>
                                        
                                        <!-- Menú de cambio de mapa - POSICIONADO RELATIVO AL BOTÓN -->
                                        <div id="base-map-menu"
                                             class="absolute mt-4 w-40 rounded-xl shadow-lg bg-white dark:bg-custom-gray ring-1 ring-black ring-opacity-5 z-1 right-0
                                                    transition-all duration-400 ease-out scale-95 opacity-0 pointer-events-none">
                                            <!-- Flechita -->
                                            <div class="absolute -top-2 right-6 w-4 h-2 z-100 pointer-events-none">
                                                <svg viewBox="0 0 16 8" class="w-4 h-2 text-white dark:text-custom-gray">
                                                    <polygon points="8,0 16,8 0,8" fill="currentColor"/>
                                                </svg>
                                            </div>
                                            <!-- Menú -->
                                             <div class="py-2 z-100" role="menu" aria-orientation="vertical">
                                                <button data-layer="osm" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700" role="menuitem">OpenStreetMap</button>
                                                <button data-layer="satellite" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700" role="menuitem">Satélite Esri</button>
                                                <button data-layer="maptiler_satellite" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700" role="menuitem">MapTiler Satélite</button>
                                                <button data-layer="terrain" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700" role="menuitem">Relieve</button>
                                                <button data-layer="dark" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700" role="menuitem">Oscuro</button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ///////////////////////////////////////////////////// --}}
                                    
                                    <!-- Botón de pantalla completa -->

                                    <button id="fullscreen-toggle" title="Pantalla Completa"class="bg-gray-600 hover:bg-gray-700 text-white px-2 py-1 rounded-lg flex items-center shadow-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"></path>
                                        </svg>
                                    </button>

                                    {{-- ///////////////////////////////////////////////////// --}}
                                </div>
                                
                                <!-- Fila inferior: Solo el botón de coordenadas manuales -->

        
                            
                                   <!-- Botón para formulario manual -->
                                </div>
                                <!-- BOTONES DE CONTROL AÑADIDOS -->
                                <div class=" flex space-x-2"> 
                                 
                                 <button id="manual-polygon-toggle" title="Escribir Cordenadas" class="bg-gray-600 hover:bg-gray-700 text-white px-2 py-1 rounded-lg flex items-center shadow-lg">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line-icon w-6 h-6 lucide-pencil-line">
                                         <path d="M13 21h8"/><path d="m15 5 4 4"/><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                                     </svg>
                                    
                                 </button>
                             </div>
                                <div class=" flex space-x-2">
                                    <button id="draw-polygon" title="Dibujar Cordenadas" class="bg-gray-600 hover:bg-gray-700 text-white px-2 py-1 rounded-lg flex items-center shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line-icon w-6 h-6 lucide-plus">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        
                                    </button>
                                </div>
                                <div class="flex space-x-2">
                                    <button id="clear-map" title="Limpiar Mapa" class="bg-gray-600 hover:bg-gray-700 text-white px-2 py-1 rounded-lg flex items-center shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line-icon w-6 h-6 lucide-clear">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        
                                    </button>

                                    
                                    
                                

                                {{-- ///////////////////////////////////////////////////// --}}
                                
                            </div>
                        </div>
                    </div>

                <!-- Modal moderno para coordenadas -->
                    <div id="manual-polygon-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-custom-gray rounded-xl shadow-2xl w-full max-w-md mx-4">
                            <!-- Header -->
                            <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ingresar Coordenadas</h3>
                                <button id="close-modal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Formulario -->
                            <form id="manual-polygon-form" class="p-6 space-y-4">
                                <!-- Método de entrada -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Método de entrada:</label>
                                    <div class="flex space-x-2">
                                        <button type="button" id="method-single" class="flex-1 py-2 px-3 bg-blue-600 text-white rounded-lg text-sm font-medium">Una por una</button>
                                        <button type="button" id="method-bulk" class="flex-1 py-2 px-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium">Lote</button>
                                    </div>
                                </div>

                                <!-- Entrada individual (por defecto) -->
                                <div id="single-input" class="space-y-3">
                                    <div class="flex space-x-2">
                                        <div class="flex-1">
                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Latitud</label>
                                            <input type="text" id="single-lat" class="w-full rounded-md border-gray-300 dark:border-gray-500 dark:bg-gray-800/80 dark:text-gray-100 text-sm p-2" placeholder="Ej: 8.123">
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Longitud</label>
                                            <input type="text" id="single-lon" class="w-full rounded-md border-gray-300 dark:border-gray-500 dark:bg-gray-800/80  dark:text-gray-100 text-sm p-2" placeholder="Ej: -66.123">
                                        </div>
                                    </div>
                                    <button type="button" id="add-coord" class="w-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 py-2 rounded-lg text-sm">
                                        + Agregar coordenada
                                    </button>
                                </div>

                                <!-- Entrada por lote (oculta inicialmente) -->
                                <div id="bulk-input" class="hidden">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Coordenadas (lat,lon por línea):</label>
                                    <!-- En el modal de coordenadas (alrededor de línea 150) -->
                                    <textarea id="bulk-coords" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-500 dark:bg-gray-800/80 dark:text-gray-100 text-sm p-2" placeholder="Ejemplo:&#10;&#9;Latitud,Longitud&#10;&#9;8.123, -66.123&#10;&#9;8.124, -66.124&#10;&#9;8.125, -66.125"></textarea>
                                </div>

                                <!-- Lista de coordenadas agregadas -->
                                <div id="coords-list" class="hidden">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Coordenadas agregadas:</label>
                                    <div class="max-h-32 overflow-y-auto border border-gray-200 dark:border-gray-500 rounded-md p-2 bg-gray-50 dark:bg-gray-800/80">
                                        <div id="coords-container" class="space-y-1"></div>
                                    </div>
                                    <button type="button" id="clear-list" class="text-red-600 hover:text-red-700 text-xs mt-1">Limpiar lista</button>
                                </div>

                                <!-- Botones -->
                                <div class="flex space-x-3 pt-2">
                                    <button type="button" id="cancel-modal" class="flex-1 py-2 px-4 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium">
                                        Cancelar
                                    </button>
                                    <button type="submit" class="flex-1 py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                                        Dibujar
                                    </button>
                                </div>
                            </form>
                        </div>
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
// Variables globales para el modal de coordenadas
let coordinatesList = [];

// Mostrar/ocultar menú de cambio de mapa - CORREGIDO
document.getElementById('base-map-toggle').addEventListener('click', function(e) {
    e.stopPropagation();
    const menu = document.getElementById('base-map-menu');
    const isShowing = menu.classList.contains('show');
    
    // Solo alternar el menú actual, no intentar cerrar menús que no existen
    toggleMenu('base-map-menu', !isShowing);
});

// Abrir modal de coordenadas - CORREGIDO
document.getElementById('manual-polygon-toggle').addEventListener('click', function(e) {
    e.stopPropagation();
    // Cerrar el menú de mapas si está abierto
    closeMenu('base-map-menu');
    document.getElementById('manual-polygon-modal').classList.remove('hidden');
});

// Cerrar modal de coordenadas
document.getElementById('close-modal').addEventListener('click', closeCoordinateModal);
document.getElementById('cancel-modal').addEventListener('click', closeCoordinateModal);

// Cambiar método de entrada en el modal
document.getElementById('method-single').addEventListener('click', function() {
    setInputMethod('single');
});

document.getElementById('method-bulk').addEventListener('click', function() {
    setInputMethod('bulk');
});

// Agregar coordenada individual
document.getElementById('add-coord').addEventListener('click', function() {
    const lat = document.getElementById('single-lat').value.trim();
    const lon = document.getElementById('single-lon').value.trim();
    
    if (!lat || !lon) {
        showAlert('Debe ingresar latitud y longitud', 'warning');
        return;
    }
    
    if (isNaN(lat) || isNaN(lon)) {
        showAlert('Las coordenadas deben ser números válidos', 'warning');
        return;
    }
    
    coordinatesList.push({ lat: parseFloat(lat), lon: parseFloat(lon) });
    updateCoordinatesList();
    
    // Limpiar inputs
    document.getElementById('single-lat').value = '';
    document.getElementById('single-lon').value = '';
    
    showAlert('Coordenada agregada', 'success');
});

// Limpiar lista de coordenadas
document.getElementById('clear-list').addEventListener('click', function() {
    coordinatesList = [];
    updateCoordinatesList();
});

// Enviar formulario del modal
document.getElementById('manual-polygon-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let coords = [];
    
    // Determinar de dónde obtener las coordenadas
    if (document.getElementById('method-single').classList.contains('bg-blue-600')) {
        // Método individual
        if (coordinatesList.length < 3) {
            showAlert('Se necesitan al menos 3 coordenadas', 'warning');
            return;
        }
        coords = coordinatesList.map(coord => [coord.lon, coord.lat]);
    } else {
        // Método por lote
        const coordsText = document.getElementById('bulk-coords').value.trim();
        if (!coordsText) {
            showAlert('Debe ingresar coordenadas', 'warning');
            return;
        }
        
        coordsText.split('\n').forEach(line => {
            const parts = line.split(',').map(s => s.trim());
            if (parts.length === 2 && !isNaN(parts[0]) && !isNaN(parts[1])) {
                coords.push([parseFloat(parts[1]), parseFloat(parts[0])]);
            }
        });
        
        if (coords.length < 3) {
            showAlert('Se necesitan al menos 3 coordenadas válidas', 'warning');
            return;
        }
    }
    
    // Cerrar polígono si no está cerrado
    if (coords.length > 0 && (coords[0][0] !== coords[coords.length-1][0] || coords[0][1] !== coords[coords.length-1][1])) {
        coords.push(coords[0]);
    }
    
    // Dibujar en el mapa
    drawPolygonOnMap(coords);
    closeCoordinateModal();
});

// Funciones para el modal de coordenadas
function setInputMethod(method) {
    const singleBtn = document.getElementById('method-single');
    const bulkBtn = document.getElementById('method-bulk');
    const singleInput = document.getElementById('single-input');
    const bulkInput = document.getElementById('bulk-input');
    const coordsList = document.getElementById('coords-list');
    
    if (method === 'single') {
        singleBtn.classList.add('bg-blue-600', 'text-white');
        singleBtn.classList.remove('bg-gray-200', 'text-gray-700', 'dark:bg-gray-700', 'dark:text-gray-300');
        bulkBtn.classList.remove('bg-blue-600', 'text-white');
        bulkBtn.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
        singleInput.classList.remove('hidden');
        bulkInput.classList.add('hidden');
        coordsList.classList.remove('hidden');
    } else {
        bulkBtn.classList.add('bg-blue-600', 'text-white');
        bulkBtn.classList.remove('bg-gray-200', 'text-gray-700', 'dark:bg-gray-700', 'dark:text-gray-300');
        singleBtn.classList.remove('bg-blue-600', 'text-white');
        singleBtn.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
        bulkInput.classList.remove('hidden');
        singleInput.classList.add('hidden');
        coordsList.classList.add('hidden');
    }
}

function updateCoordinatesList() {
    const container = document.getElementById('coords-container');
    const listSection = document.getElementById('coords-list');
    
    container.innerHTML = '';
    
    if (coordinatesList.length === 0) {
        listSection.classList.add('hidden');
        return;
    }
    
    listSection.classList.remove('hidden');
    
    coordinatesList.forEach((coord, index) => {
        const coordElement = document.createElement('div');
        coordElement.className = 'flex justify-between items-center text-xs';
        coordElement.innerHTML = `
            <span>${index + 1}. ${coord.lat}, ${coord.lon}</span>
            <button type="button" onclick="removeCoordinate(${index})" class="text-red-500 hover:text-red-700">X</button>
        `;
        container.appendChild(coordElement);
    });
}

function removeCoordinate(index) {
    coordinatesList.splice(index, 1);
    updateCoordinatesList();
}

function drawPolygonOnMap(coords) {
    const feature = new ol.Feature({
        geometry: new ol.geom.Polygon([coords]).transform('EPSG:4326', 'EPSG:3857')
    });
    
    window.deforestationMapInstance.clearMap();
    window.deforestationMapInstance.source.addFeature(feature);
    
    window.deforestationMapInstance.map.getView().fit(
        feature.getGeometry().getExtent(),
        { padding: [50, 50, 50, 50], duration: 1000 }
    );
    
    window.deforestationMapInstance.convertToGeoJSON(feature);
    window.deforestationMapInstance.showAlert('Polígono dibujado exitosamente', 'success');
}

function closeCoordinateModal() {
    document.getElementById('manual-polygon-modal').classList.add('hidden');
    coordinatesList = [];
    updateCoordinatesList();
    document.getElementById('bulk-coords').value = '';
    document.getElementById('single-lat').value = '';
    document.getElementById('single-lon').value = '';
}

// Funciones para los menús desplegables - CORREGIDAS
function toggleMenu(menuId, show) {
    const menu = document.getElementById(menuId);
    if (show) {
        menu.classList.remove('scale-95', 'opacity-0', 'pointer-events-none');
        menu.classList.add('scale-100', 'opacity-100', 'pointer-events-auto', 'show');
    } else {
        menu.classList.remove('scale-100', 'opacity-100', 'pointer-events-auto', 'show');
        menu.classList.add('scale-95', 'opacity-0', 'pointer-events-none');
    }
}

function closeMenu(menuId) {
    toggleMenu(menuId, false);
}

// Cerrar menús al hacer clic fuera - VERSIÓN SIMPLIFICADA Y CORREGIDA
document.addEventListener('click', function(e) {
    const baseMapToggle = document.getElementById('base-map-toggle');
    const baseMapMenu = document.getElementById('base-map-menu');
    const modal = document.getElementById('manual-polygon-modal');
    
    // Solo manejar menús si el modal está cerrado
    if (modal.classList.contains('hidden')) {
        // Si se hace clic fuera del menú de mapas, cerrarlo
        if (!baseMapToggle.contains(e.target) && !baseMapMenu.contains(e.target)) {
            closeMenu('base-map-menu');
        }
    }
    
    // Cerrar modal si se hace clic fuera de él
    if (!modal.classList.contains('hidden') && e.target === modal) {
        closeCoordinateModal();
    }
});

// Cambiar capa base - LLAMA A LA FUNCIÓN DEL map.js
document.querySelectorAll('#base-map-menu button').forEach(button => {
    button.addEventListener('click', function(e) {
        e.stopPropagation(); // Prevenir que el clic se propague
        const layerKey = this.getAttribute('data-layer');
        // Usar la función del map.js
        if (window.deforestationMapInstance && window.deforestationMapInstance.changeBaseLayer) {
            window.deforestationMapInstance.changeBaseLayer(layerKey);
        }
        closeMenu('base-map-menu');
        
        // Actualizar texto del botón
        // Actualiza el objeto layerNames:
const layerNames = {
    'osm': 'OpenStreetMap',
    'satellite': 'Satélite Esri', 
    'maptiler_satellite': 'MapTiler Satélite',
    'terrain': 'Relieve',
    'dark': 'Oscuro'
};
        
        const button = document.getElementById('base-map-toggle');
        const svg = button.querySelector('svg').cloneNode(true);
        button.innerHTML = '';
        button.appendChild(svg);
        button.appendChild(document.createTextNode(' ' + layerNames[layerKey]));
    });
});

// Función para pantalla completa
document.getElementById('fullscreen-toggle').addEventListener('click', function() {
    const mapElement = document.getElementById('map');
    if (!document.fullscreenElement) {
        if (mapElement.requestFullscreen) {
            mapElement.requestFullscreen();
        } else if (mapElement.webkitRequestFullscreen) {
            mapElement.webkitRequestFullscreen();
        } else if (mapElement.msRequestFullscreen) {
            mapElement.msRequestFullscreen();
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
});

// Función de alerta auxiliar
function showAlert(message, type) {
    if (window.deforestationMapInstance && window.deforestationMapInstance.showAlert) {
        window.deforestationMapInstance.showAlert(message, type);
    } else {
        alert(message);
    }
}

// Inicializar el modal con método individual por defecto
setInputMethod('single');

// Manejo de importación de archivos
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

// Cerrar modal con tecla Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCoordinateModal();
    }
});
</script>