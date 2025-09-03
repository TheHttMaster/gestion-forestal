<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto">
            <div class="bg-stone-100/90 dark:bg-custom-gray overflow-hidden shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-8 ">
                <div class="text-gray-900 dark:text-gray-100 ">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="text-2xl font-bold"><i class="fas fa-map-marker-alt mr-2"></i>{{ isset($area) ? 'Editar' : 'Crear' }} Área Geográfica</h2>           
                    </div>
                    
                    <form method="POST" action="{{ isset($area) ? route('areas.update', $area->id) : route('areas.store') }}">
                        @csrf
                        @if(isset($area))
                            @method('PUT')
                        @endif

                        <div class="relative rounded-lg overflow-hidden mb-6 border border-gray-200" style="height: 500px;">
                            <div id="map" class="h-full w-full"></div>
                            <div class="coordinates-display" id="coordinates-display">
                                Lat: 0.000000 | Lng: 0.000000
                            </div>
                            <div class="map-overlay">
                                <button type="button" id="locate-me" class="bg-white text-gray-700 px-3 py-2 rounded-lg shadow-md hover:bg-gray-50 flex items-center">
                                    <i class="fas fa-location-arrow mr-2"></i> Mi ubicación
                                </button>
                            </div>
                        </div>

                        <input type="hidden" id="latitud" name="latitud" value="{{ old('latitud', $area->latitud ?? '') }}">
                        <input type="hidden" id="longitud" name="longitud" value="{{ old('longitud', $area->longitud ?? '') }}">
                        
                        <div class="flex items-center justify-end mt-4 space-x-4">
                            <x-go-back-button />
                            <x-primary-button type="submit" class="ms-4">
                                {{ __('Guardar Área') }}
                            </x-primary-button>
                        </div>
                    </form>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    /* Estilos del visor de coordenadas */
    .coordinates-display {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        background: rgba(255, 255, 255, 0.8);
        padding: 5px 10px;
        border-radius: 5px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        color: #333;
        white-space: nowrap;
    }
</style>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // ==========================================================
    // SECCIÓN 1: INICIALIZACIÓN Y CONFIGURACIÓN DEL MAPA
    // ==========================================================
    
    // Inicializa el mapa de Leaflet y lo centra en las coordenadas por defecto.
    const map = L.map('map').setView([10.672222222222, -63.240277777778], 10);

    // Agrega la capa de OpenStreetMap al mapa para que sea visible.
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Crea un marcador que se puede arrastrar en el centro del mapa.
    let marker = L.marker(map.getCenter(), { draggable: true }).addTo(map);

    // Vincula un 'popup' al marcador para mostrar un mensaje al usuario.
    marker.bindPopup("<b>Ubicación seleccionada</b><br>Arrastra para ajustar").openPopup();

    // Obtiene el elemento HTML donde se mostrarán las coordenadas en tiempo real.
    const coordinatesDisplay = document.getElementById('coordinates-display');

    // ==========================================================
    // SECCIÓN 2: LÓGICA DE EVENTOS Y ACTUALIZACIONES EN TIEMPO REAL
    // ==========================================================

    /**
     * @function updateCoordinatesDisplay
     * @description Actualiza el texto del visor de coordenadas.
     * @param {Object} latlng - Objeto de coordenadas (lat, lng).
     */
    function updateCoordinatesDisplay(latlng) {
        if (coordinatesDisplay) {
            coordinatesDisplay.textContent = `Lat: ${latlng.lat.toFixed(6)} | Lng: ${latlng.lng.toFixed(6)}`;
        }
    }

    // Escucha el movimiento del cursor sobre el mapa para actualizar las coordenadas.
    map.on('mousemove', function(e) {
        updateCoordinatesDisplay(e.latlng);
    });

    // Actualiza los campos de latitud y longitud cuando se arrastra y suelta el marcador.
    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        document.getElementById('latitud').value = position.lat.toFixed(6);
        document.getElementById('longitud').value = position.lng.toFixed(6);
        marker.setPopupContent(`<b>Ubicación seleccionada</b><br>Lat: ${position.lat.toFixed(6)}<br>Lng: ${position.lng.toFixed(6)}`).openPopup();
    });

    // Mueve el marcador y actualiza los campos cuando el usuario hace clic en el mapa.
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('latitud').value = e.latlng.lat.toFixed(6);
        document.getElementById('longitud').value = e.latlng.lng.toFixed(6);
        marker.setPopupContent(`<b>Ubicación seleccionada</b><br>Lat: ${e.latlng.lat.toFixed(6)}<br>Lng: ${e.latlng.lng.toFixed(6)}`).openPopup();
    });

    // Maneja el clic en el botón 'Mi ubicación' para usar la geolocalización del navegador.
    document.getElementById('locate-me').addEventListener('click', function() {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                document.getElementById('latitud').value = lat.toFixed(6);
                document.getElementById('longitud').value = lng.toFixed(6);
                const newLatLng = L.latLng(lat, lng);
                marker.setLatLng(newLatLng);
                map.setView(newLatLng, 15);
                marker.setPopupContent(`<b>Tu ubicación actual</b><br>Lat: ${lat.toFixed(6)}<br>Lng: ${lng.toFixed(6)}`).openPopup();
            }, function(error) {
                alert("No se pudo obtener la ubicación: " + error.message);
            });
        } else {
            alert("La geolocalización no es compatible con este navegador.");
        }
    });

    // ==========================================================
    // SECCIÓN 3: SINCRONIZACIÓN DE CAMPOS Y VALORES INICIALES
    // ==========================================================
    
    /**
     * @function updateMarkerFromInputs
     * @description Mueve el marcador en el mapa basándose en los valores de los campos del formulario.
     */
    function updateMarkerFromInputs() {
        const lat = parseFloat(document.getElementById('latitud').value);
        const lng = parseFloat(document.getElementById('longitud').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            const newLatLng = L.latLng(lat, lng);
            marker.setLatLng(newLatLng);
            map.panTo(newLatLng);
            marker.setPopupContent(`<b>Ubicación seleccionada</b><br>Lat: ${lat.toFixed(6)}<br>Lng: ${lng.toFixed(6)}`).openPopup();
        }
    }

    // Escucha cambios en los campos de latitud y longitud para sincronizarlos con el mapa.
    document.getElementById('latitud').addEventListener('change', updateMarkerFromInputs);
    document.getElementById('longitud').addEventListener('change', updateMarkerFromInputs);
    
    // Inicializa el mapa con las coordenadas existentes del formulario, si las hay.
    const initialLat = parseFloat("{{ old('latitud', $area->latitud ?? '0') }}");
    const initialLng = parseFloat("{{ old('longitud', $area->longitud ?? '0') }}");
    if (initialLat !== 0 && initialLng !== 0) {
        const initialLatLng = L.latLng(initialLat, initialLng);
        marker.setLatLng(initialLatLng);
        map.setView(initialLatLng, 13);
        marker.setPopupContent(`<b>Ubicación actual</b><br>Lat: ${initialLat.toFixed(6)}<br>Lng: ${initialLng.toFixed(6)}`).openPopup();
        updateCoordinatesDisplay(initialLatLng);
    } else {
        // Si no hay coordenadas previas, actualiza el visor con las coordenadas por defecto.
        updateCoordinatesDisplay(map.getCenter());
    }

    // ==========================================================
    // SECCIÓN 4: LÓGICA DE ÁREAS PADRE (SIMULACIÓN AJAX)
    // ==========================================================
    
    // Carga las opciones del menú de área padre basándose en el tipo de área seleccionada.
    document.getElementById('tipo').addEventListener('change', function() {
        const tipo = this.value;
        const areaPadreSelect = document.getElementById('area_padre_id');
        while (areaPadreSelect.options.length > 1) {
            areaPadreSelect.remove(1);
        }
        if (tipo) {
            const opciones = {
                'pais': [],
                'estado': [{id: 1, nombre: 'Colombia', tipo: 'pais'}],
                'ciudad': [{id: 2, nombre: 'Cundinamarca', tipo: 'estado'}],
                'municipio': [{id: 3, nombre: 'Bogotá', tipo: 'ciudad'}],
                'zona': [{id: 4, nombre: 'Engativá', tipo: 'municipio'}],
                'barrio': [{id: 5, nombre: 'Álamos', tipo: 'zona'}]
            };
            if (opciones[tipo]) {
                opciones[tipo].forEach(area => {
                    const option = document.createElement('option');
                    option.value = area.id;
                    option.textContent = `${area.nombre} (${area.tipo})`;
                    areaPadreSelect.appendChild(option);
                });
            }
        }
    });
    
    // Dispara el evento de cambio para inicializar el selector si ya hay un tipo seleccionado.
    if (document.getElementById('tipo') && document.getElementById('tipo').value) {
        document.getElementById('tipo').dispatchEvent(new Event('change'));
    }
    
    // Establece el valor del área padre si existe en la base de datos.
    const areaPadreId = "{{ old('area_padre_id', $area->area_padre_id ?? '') }}";
    if (areaPadreId) {
        setTimeout(() => {
            const areaPadreSelect = document.getElementById('area_padre_id');
            if (areaPadreSelect) {
                areaPadreSelect.value = areaPadreId;
            }
        }, 500);
    }
</script>