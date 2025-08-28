<x-app-layout>

<div class="">
    <div class="max-w-7xl mx-auto ">
        <div class="bg-stone-100/90 dark:bg-custom-gray overflow-hidden shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-8 ">
            <div class="text-gray-900 dark:text-gray-100 ">
                
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-2xl font-bold"><i class="fas fa-map-marker-alt mr-2"></i>{{ isset($area) ? 'Editar' : 'Crear' }} Área Geográfica</h2>           
            </div>

            
                <div class="relative rounded-lg overflow-hidden mb-6 border border-gray-200">
                    <div id="map"></div>
                    <div class="map-overlay">
                        <button type="button" id="locate-me" class="bg-white text-gray-700 px-3 py-2 rounded-lg shadow-md hover:bg-gray-50 flex items-center">
                            <i class="fas fa-location-arrow mr-2"></i> Mi ubicación
                        </button>
                    </div>
                </div>
                
               
           
        </div>
    </div>
</div>

   

</x-app-layout>

<!--  -->

 <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Inicializar el mapa
        const map = L.map('map').setView([4.5709, -74.2973], 10); // Coordenadas por defecto (Bogotá)
        
        // Añadir capa de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Marcador inicial
        let marker = L.marker(map.getCenter(), {
            draggable: true
        }).addTo(map);
        
        // Popup para el marcador
        marker.bindPopup("<b>Ubicación seleccionada</b><br>Arrastra para ajustar").openPopup();
        
        // Actualizar coordenadas cuando se mueve el marcador
        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            document.getElementById('latitud').value = position.lat.toFixed(6);
            document.getElementById('longitud').value = position.lng.toFixed(6);
            marker.setPopupContent(`<b>Ubicación seleccionada</b><br>Lat: ${position.lat.toFixed(6)}<br>Lng: ${position.lng.toFixed(6)}`).openPopup();
        });
        
        // Actualizar marcador cuando se cambian las coordenadas manualmente
        document.getElementById('latitud').addEventListener('change', updateMarkerFromInputs);
        document.getElementById('longitud').addEventListener('change', updateMarkerFromInputs);
        
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
        
        // Añadir nuevo marcador al hacer clic en el mapa
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latitud').value = e.latlng.lat.toFixed(6);
            document.getElementById('longitud').value = e.latlng.lng.toFixed(6);
            marker.setPopupContent(`<b>Ubicación seleccionada</b><br>Lat: ${e.latlng.lat.toFixed(6)}<br>Lng: ${e.latlng.lng.toFixed(6)}`).openPopup();
        });
        
        // Botón para ubicación actual
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
        
        // Cargar áreas padre según el tipo seleccionado
        document.getElementById('tipo').addEventListener('change', function() {
            const tipo = this.value;
            const areaPadreSelect = document.getElementById('area_padre_id');
            
            // Limpiar opciones actuales excepto la primera
            while (areaPadreSelect.options.length > 1) {
                areaPadreSelect.remove(1);
            }
            
            if (tipo) {
                // Simular carga de áreas según el tipo (en una aplicación real, harías una petición AJAX)
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
        
        // Inicializar el selector de área padre si ya hay un tipo seleccionado
        if (document.getElementById('tipo').value) {
            document.getElementById('tipo').dispatchEvent(new Event('change'));
        }
        
        // Establecer el valor del área padre si existe
        const areaPadreId = "{{ old('area_padre_id', $area->area_padre_id ?? '') }}";
        if (areaPadreId) {
            setTimeout(() => {
                document.getElementById('area_padre_id').value = areaPadreId;
            }, 500);
        }
        
        // Inicializar el mapa con las coordenadas existentes si las hay
        const initialLat = parseFloat("{{ old('latitud', $area->latitud ?? '0') }}");
        const initialLng = parseFloat("{{ old('longitud', $area->longitud ?? '0') }}");
        
        if (initialLat !== 0 && initialLng !== 0) {
            const initialLatLng = L.latLng(initialLat, initialLng);
            marker.setLatLng(initialLatLng);
            map.setView(initialLatLng, 13);
            marker.setPopupContent(`<b>Ubicación actual</b><br>Lat: ${initialLat.toFixed(6)}<br>Lng: ${initialLng.toFixed(6)}`).openPopup();
        }
    </script>