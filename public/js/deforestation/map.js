/**
 * Clase principal para gestionar el mapa de deforestación.
 * Permite dibujar polígonos, calcular área, convertir a GeoJSON y enviar el formulario.
 * Usa OpenLayers.
 */
class DeforestationMap {
    constructor() {
        this.map = null;      // Instancia del mapa
        this.draw = null;     // Interacción de dibujo
        this.source = null;   // Fuente de datos vectoriales
        this.polygonStyle = null; // Estilo para polígonos
        this.pointStyle = null;   // Estilo para puntos/vértices

        this.initializeMap();
        this.setupEventListeners();
    }

    /**
     * Inicializa el mapa, las capas y los estilos.
     */
    initializeMap() {
        // Capa base OpenStreetMap
        const osmLayer = new ol.layer.Tile({
            source: new ol.source.OSM()
        });

        // Fuente para las geometrías dibujadas
        this.source = new ol.source.Vector();

        // Estilo para polígonos
        this.polygonStyle = new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'blue',
                width: 3
            }),
            fill: new ol.style.Fill({
                color: 'rgba(0, 0, 255, 0.2)'
            })
        });

        // Estilo mejorado para mostrar etiquetas
        this.polygonStyle = new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'blue',
                width: 3
            }),
            fill: new ol.style.Fill({
                color: 'rgba(0, 0, 255, 0.2)'
            })
        });

        // Estilo para etiquetas con mejor contraste
        this.labelStyle = new ol.style.Style({
            text: new ol.style.Text({
                text: '', // Se establecerá dinámicamente
                font: 'bold 14px Arial',
                fill: new ol.style.Fill({ color: '#000' }),
                stroke: new ol.style.Stroke({ color: '#fff', width: 3 }),
                offsetY: -20,
                overflow: true,
                background: true,
                backgroundFill: new ol.style.Fill({
                    color: 'rgba(255, 255, 255, 0.6)'
                }),
                padding: [3, 5, 3, 5]
            })
        });

        // Capa vectorial con estilo mejorado
        const vectorLayer = new ol.layer.Vector({
            source: this.source,
            style: (feature) => {
                const geometry = feature.getGeometry();
                const styles = [this.polygonStyle];
                
                // Añadir etiqueta si existe
                const label = feature.get('label');
                if (label && geometry.getType() !== 'Point') {
                    const labelStyle = this.labelStyle.clone();
                    const center = ol.extent.getCenter(geometry.getExtent());
                    labelStyle.getText().setText(label);
                    
                    // Crear un punto en el centro para la etiqueta
                    const pointFeature = new ol.Feature({
                        geometry: new ol.geom.Point(center)
                    });
                    pointFeature.setStyle(labelStyle);
                    
                    // Añadir la etiqueta como feature separada
                    this.source.addFeature(pointFeature);
                }
                
                return styles;
            }
        });

        // Inicializar el mapa centrado en Colombia
        this.map = new ol.Map({
            target: 'map',
            layers: [osmLayer, vectorLayer],
            view: new ol.View({
                center: ol.proj.fromLonLat([-74.0, 4.6]), // Coordenadas de Colombia
                zoom: 6
            })
        });
    }

    /**
     * Configura los listeners de los botones y el formulario.
     */
    setupEventListeners() {
        // Botón para activar el dibujo de polígono
        document.getElementById('draw-polygon').addEventListener('click', () => {
            this.activateDrawing();
        });

        // Botón para limpiar el mapa
        document.getElementById('clear-map').addEventListener('click', () => {
            this.clearMap();
        });

        // Envío del formulario de análisis
        document.getElementById('analysis-form').addEventListener('submit', (e) => {
            this.handleFormSubmit(e);
        });
    }

    /**
     * Activa la herramienta de dibujo de polígonos en el mapa.
     * Limpia interacciones previas y muestra instrucciones.
     */
    activateDrawing() {
        // Eliminar interacción de dibujo previa si existe
        if (this.draw) {
            this.map.removeInteraction(this.draw);
        }

        // Crear nueva interacción de dibujo de polígonos
        this.draw = new ol.interaction.Draw({
            source: this.source,
            type: 'Polygon',
            style: (feature) => {
                // Añade el estilo de polígono y puntos en los vértices
                const geometry = feature.getGeometry();
                const styles = [this.polygonStyle];

                if (geometry.getType() === 'Polygon') {
                    const coordinates = geometry.getCoordinates()[0];
                    coordinates.forEach((coordinate) => {
                        const point = new ol.Feature({
                            geometry: new ol.geom.Point(coordinate)
                        });
                        point.setStyle(this.pointStyle);
                        this.source.addFeature(point);
                    });
                }
                return styles;
            }
        });

        // Evento al terminar de dibujar el polígono
        this.draw.on('drawend', (event) => {
            const feature = event.feature;

            // Limpiar puntos anteriores
            this.source.getFeatures().forEach(f => {
                if (f.getGeometry().getType() === 'Point') {
                    this.source.removeFeature(f);
                }
            });

            // Calcular y mostrar área aproximada en hectáreas
            const areaHa = this.calculateArea(feature);
            this.showAlert(`Polígono dibujado. Área aproximada: ${areaHa} hectáreas`);

            // Convertir a GeoJSON y guardar la geometría
            this.convertToGeoJSON(feature);

            // Desactivar la interacción de dibujo
            this.map.removeInteraction(this.draw);
        });

        // Agregar la interacción de dibujo al mapa
        this.map.addInteraction(this.draw);

        // Mostrar instrucciones al usuario
        this.showAlert('Dibuja el área de interés en el mapa. Haz clic para añadir vértices y doble clic para terminar.');
    }

    /**
     * Calcula el área de un polígono en hectáreas.
     * @param {ol.Feature} feature - El polígono dibujado.
     * @returns {number} Área en hectáreas.
     */
    calculateArea(feature) {
        const geometry = feature.getGeometry();
        const area = ol.sphere.getArea(geometry);
        return Math.round(area / 10000); // Convertir m² a hectáreas
    }

    /**
     * Convierte la geometría a GeoJSON y la guarda en el input oculto.
     * @param {ol.Feature} feature - El polígono dibujado.
     */
    convertToGeoJSON(feature) {
        try {
            const format = new ol.format.GeoJSON();
            const geojson = format.writeFeature(feature, {
                dataProjection: 'EPSG:4326',
                featureProjection: 'EPSG:3857'
            });

            const geojsonObj = JSON.parse(geojson);

            if (!geojsonObj.geometry) {
                throw new Error('El polígono no tiene geometría válida');
            }

            // Guardar solo la geometría en el input oculto
            document.getElementById('geometry').value = JSON.stringify(geojsonObj.geometry);

            this.showAlert('Polígono guardado. Ahora puedes enviar el formulario.');
        } catch (error) {
            console.error('Error al convertir GeoJSON:', error);
            this.showAlert('Error al guardar el polígono: ' + error.message, 'error');
        }
    }

    /**
     * Limpia todas las geometrías del mapa y el input oculto.
     */
    clearMap() {
        this.source.clear();
        document.getElementById('geometry').value = '';
    }

    /**
     * Maneja el envío del formulario de análisis.
     * Valida que exista un polígono, muestra spinner y envía por AJAX.
     * @param {Event} event
     */
    async handleFormSubmit(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');
        const spinner = document.getElementById('loading-spinner');

        // Validar que se haya dibujado un polígono
        if (!document.getElementById('geometry').value) {
            this.showAlert('Por favor, dibuja un polígono en el mapa primero.', 'warning');
            return;
        }

        // Mostrar spinner y desactivar botón
        spinner.classList.remove('d-none');
        submitButton.disabled = true;

        try {
            // Obtener el token CSRF de la meta
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Enviar la solicitud AJAX
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
                }
            });

            const result = await response.json();

            if (result.success) {
                // Redirigir a la página de resultados
                window.location.href = `/deforestation/results/${result.polygon_id}`;
            } else {
                this.showAlert('Error: ' + result.message, 'error');
            }

        } catch (error) {
            console.error('Error:', error);
            this.showAlert('Error al procesar la solicitud', 'error');
        } finally {
            spinner.classList.add('d-none');
            submitButton.disabled = false;
        }
    }

    /**
     * Muestra una alerta al usuario.
     * Usa SweetAlert2 si está disponible, si no usa alert nativo.
     * @param {string} message - Mensaje a mostrar.
     * @param {string} [icon='info'] - Tipo de alerta: 'success', 'error', 'warning', 'info'.
     */
    showAlert(message, icon = 'info') {
        if (window.Swal) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-xl shadow-lg bg-stone-100/95 dark:bg-custom-gray border border-gray-200 dark:border-gray-700',
                    title: 'text-sm font-semibold text-gray-900 dark:text-white mb-1'
                }
            });
        } else {
            alert(message);
        }
    }

    /**
     * Importa uno o varios polígonos desde un objeto GeoJSON y los dibuja en el mapa.
     * Si las features tienen nombre, lo muestra como etiqueta.
     * @param {Object} geojson - Objeto GeoJSON válido.
     */
    importGeoJSON(geojson) {
        try {
            this.clearMap();

            const format = new ol.format.GeoJSON();
            const features = format.readFeatures(geojson, {
                featureProjection: 'EPSG:3857'
            });

            if (features.length === 0) {
                this.showAlert('El archivo no contiene geometría válida.', 'error');
                return;
            }

            // Añadir todas las features al mapa
            features.forEach(feature => {
                this.source.addFeature(feature);
                const name = feature.get('name') || feature.get('Nombre') || feature.get('NOMBRE') || feature.get('title');
                if (name) {
                    feature.set('label', name);
                }
            });

            // Centrar el mapa en la extensión de todas las features
            const extent = this.source.getExtent();
            this.map.getView().fit(extent, {
                padding: [50, 50, 50, 50],
                duration: 1000
            });

            // Guardar la geometría (puedes guardar el GeoJSON completo o solo el primero, según tu backend)
            // Aquí guardamos el GeoJSON de todas las features
            const geojsonAll = format.writeFeatures(features, {
                dataProjection: 'EPSG:4326',
                featureProjection: 'EPSG:3857'
            });
            document.getElementById('geometry').value = geojsonAll;

            this.showAlert('Áreas importadas correctamente.', 'success');
        } catch (error) {
            this.showAlert('Error al importar el área: ' + error.message, 'error');
        }
    }

    /**
     * Importa un polígono desde un string KML y lo dibuja en el mapa.
     * @param {string} kmlText - Contenido del archivo KML.
     */
    // map.js - Modificar la función importKML
    importKML(kmlText) {
        try {
            this.clearMap();

            const format = new ol.format.KML();
            const features = format.readFeatures(kmlText, {
                featureProjection: 'EPSG:3857'
            });

            if (features.length === 0) {
                this.showAlert('El archivo KML no contiene geometría válida.', 'error');
                return;
            }

            // Procesar TODOS los features, no solo el primero
            const allFeatures = [];
            
            features.forEach(feature => {
                // Extraer datos del KML (nombres de productores)
                const productor = this.extractKMLData(feature);
                
                if (productor) {
                    // Establecer etiqueta con la información del productor
                    feature.set('label', productor);
                    feature.set('productor', productor);
                }
                
                this.source.addFeature(feature);
                allFeatures.push(feature);
            });

            // Centrar el mapa en todas las features
            const extent = this.source.getExtent();
            this.map.getView().fit(extent, {
                padding: [50, 50, 50, 50],
                duration: 1000
            });

            // Guardar todas las geometrías
            const geojsonAll = new ol.format.GeoJSON().writeFeatures(allFeatures, {
                dataProjection: 'EPSG:4326',
                featureProjection: 'EPSG:3857'
            });
            document.getElementById('geometry').value = geojsonAll;

            this.showAlert(`${features.length} áreas importadas correctamente.`, 'success');
        } catch (error) {
            this.showAlert('Error al importar el área KML: ' + error.message, 'error');
        }
    }

    // En map.js - Mejorar la función extractKMLData
    extractKMLData(feature) {
        try {
            // Obtener la descripción KML que contiene los datos extendidos
            const kmlDescription = feature.get('description');
            if (!kmlDescription) return null;

            // Parsear el HTML de la descripción para encontrar los datos extendidos
            const parser = new DOMParser();
            const doc = parser.parseFromString(kmlDescription, 'text/html');
            
            // Buscar datos extendidos
            const simpleDataElements = doc.querySelectorAll('simpledata');
            const data = {};
            
            simpleDataElements.forEach(el => {
                const name = el.getAttribute('name');
                const value = el.textContent;
                if (name && value) {
                    data[name.toLowerCase()] = value;
                }
            });
            
            // Priorizar Productor, luego Name, luego otros campos
            return data.productor || data.name || data.nombre || null;
            
        } catch (error) {
            console.warn('Error extrayendo datos KML:', error);
            return null;
        }
    }

    // Mejorar la función processMultiPolygonInfo para extraer más datos
    processMultiPolygonInfo(features) {
        const polygonsInfo = [];
        
        features.forEach(feature => {
            const geometry = feature.getGeometry();
            if (geometry.getType() === 'Polygon') {
                const productor = feature.get('productor') || feature.get('name') || 'Propietario desconocido';
                const areaHa = this.calculateArea(feature);
                
                // Extraer más datos si están disponibles
                const localidad = feature.get('localidad') || feature.get('municipio') || 'No especificado';
                
                polygonsInfo.push({
                    productor: productor,
                    localidad: localidad,
                    area: areaHa
                });
            }
        });
        
        this.displayPolygonsInfo(polygonsInfo);
    }

// Mejorar la función displayPolygonsInfo
displayPolygonsInfo(polygonsInfo) {
    const container = document.getElementById('producers-info');
    const list = document.getElementById('producers-list');
    
    if (polygonsInfo.length > 0) {
        list.innerHTML = '';
        
        polygonsInfo.forEach(info => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-white">${info.productor}</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-white">${info.localidad}</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-white">${info.area} Ha</td>
            `;
            list.appendChild(row);
        });
        
        container.classList.remove('hidden');
    } else {
        container.classList.add('hidden');
    }
}

// Modificar la función importKML para procesar múltiples polígonos
importKML(kmlText) {
    try {
        this.clearMap();

        const format = new ol.format.KML();
        const features = format.readFeatures(kmlText, {
            featureProjection: 'EPSG:3857'
        });

        if (features.length === 0) {
            this.showAlert('El archivo KML no contiene geometría válida.', 'error');
            return;
        }

        // Procesar TODOS los features
        features.forEach(feature => {
            const productor = this.extractKMLData(feature);
            
            if (productor) {
                feature.set('label', productor);
                feature.set('productor', productor);
            }
            
            this.source.addFeature(feature);
        });

        // Centrar el mapa en todas las features
        const extent = this.source.getExtent();
        this.map.getView().fit(extent, {
            padding: [50, 50, 50, 50],
            duration: 1000
        });

        // Guardar todas las geometrías como FeatureCollection
        const featureCollection = {
            type: 'FeatureCollection',
            features: features.map(feature => {
                const geoJSONFormat = new ol.format.GeoJSON();
                return JSON.parse(geoJSONFormat.writeFeature(feature, {
                    dataProjection: 'EPSG:4326',
                    featureProjection: 'EPSG:3857'
                }));
            })
        };
        
        document.getElementById('geometry').value = JSON.stringify(featureCollection);

        // Procesar información de múltiples polígonos
        this.processMultiPolygonInfo(features);

        this.showAlert(`${features.length} áreas importadas correctamente.`, 'success');
    } catch (error) {
        this.showAlert('Error al importar el área KML: ' + error.message, 'error');
    }
}

// Modificar también la función importGeoJSON para múltiples polígonos
importGeoJSON(geojson) {
    try {
        this.clearMap();

        const format = new ol.format.GeoJSON();
        const features = format.readFeatures(geojson, {
            featureProjection: 'EPSG:3857'
        });

        if (features.length === 0) {
            this.showAlert('El archivo no contiene geometría válida.', 'error');
            return;
        }

        // Añadir todas las features al mapa
        features.forEach(feature => {
            this.source.addFeature(feature);
            const name = feature.get('name') || feature.get('Nombre') || feature.get('NOMBRE') || feature.get('title') || feature.get('Productor');
            if (name) {
                feature.set('label', name);
                feature.set('productor', name);
            }
        });

        // Centrar el mapa en la extensión de todas las features
        const extent = this.source.getExtent();
        this.map.getView().fit(extent, {
            padding: [50, 50, 50, 50],
            duration: 1000
        });

        // Guardar la geometría como FeatureCollection
        document.getElementById('geometry').value = JSON.stringify(geojson);

        // Procesar información de múltiples polígonos
        this.processMultiPolygonInfo(features);

        this.showAlert('Áreas importadas correctamente.', 'success');
    } catch (error) {
        this.showAlert('Error al importar el área: ' + error.message, 'error');
    }
}

// Modificar handleFormSubmit para manejar múltiples polígonos
async handleFormSubmit(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    const spinner = document.getElementById('loading-spinner');

    // Validar que se haya dibujado un polígono
    if (!document.getElementById('geometry').value) {
        this.showAlert('Por favor, dibuja un polígono en el mapa primero.', 'warning');
        return;
    }

    // Mostrar spinner y desactivar botón
    spinner.classList.remove('d-none');
    submitButton.disabled = true;

    try {
        // Obtener el token CSRF de la meta
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Enviar la solicitud AJAX
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token
            }
        });

        const result = await response.json();

        if (result.success) {
            if (result.multiple) {
                // Para múltiples polígonos, redirigir a página de resumen
                const polygonIds = result.results.map(r => r.polygon_id);
                window.location.href = `/deforestation/multiple-results?polygon_ids=${polygonIds.join(',')}`;
            } else {
                // Para un solo polígono, redirigir a la página de resultados normal
                window.location.href = `/deforestation/results/${result.polygon_id}`;
            }
        } else {
            this.showAlert('Error: ' + result.message, 'error');
        }

    } catch (error) {
        console.error('Error:', error);
        this.showAlert('Error al procesar la solicitud', 'error');
    } finally {
        spinner.classList.add('d-none');
        submitButton.disabled = false;
    }
}
}

// Inicializar el mapa cuando el documento esté listo
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('map')) {
        window.deforestationMapInstance = new DeforestationMap();
    }
});

