/**
 * DeforestationMap
 * Clase principal para gestionar el mapa de deforestación.
 * Permite dibujar, importar y visualizar múltiples áreas (polígonos) con etiquetas y detalles.
 * Soporta GeoJSON, KML y SHP (usando shpjs).
 * Autor: Inspirado en principios de "Código Limpio".
 */
class DeforestationMap {
    constructor() {
        // Instancias y configuraciones principales
        this.map = null;                // Instancia OpenLayers Map
        this.draw = null;               // Interacción de dibujo
        this.source = null;             // Fuente vectorial para features
       
        this.polygonStyle = null;       // Estilo para polígonos
        this.pointStyle = null;         // Estilo para puntos/vértices
        this.labelStyle = null;         // Estilo para etiquetas
        this.coordinateDisplay = null;  // Elemento para mostrar coordenadas
        this.baseLayers = {};           // Capas base disponibles
        this.currentBaseLayer = null;   // Capa base actual

        this.gfwLossLayer = null; // La instancia de la capa GFW de OpenLayers
        this.STORAGE_KEY = 'gfwLossLayerState'; // Clave para localStorage
        
        // Inicialización
        this.initializeMap();
        this.setupEventListeners();
        this.setupCoordinateDisplay();
        this.initializeGfWLayerToggle();
    }

    setGFWOpacity(opacity) {
        if (this.gfwLossLayer) {
            this.gfwLossLayer.setOpacity(opacity);
        }
    }

    /**
     * Obtiene la opacidad actual de la capa GFW
     * @returns {number} Opacidad entre 0 y 1
     */
    getGFWOpacity() {
        return this.gfwLossLayer ? this.gfwLossLayer.getOpacity() : 0.9;
    }

    /**
     * Alterna la visibilidad de la capa GFW
     */
    toggleGFWVisibility() {
        if (this.gfwLossLayer) {
            const currentVisibility = this.gfwLossLayer.getVisible();
            this.gfwLossLayer.setVisible(!currentVisibility);
            return !currentVisibility;
        }
        return false;
    }

    /**
     * Inicializa el mapa, las capas base y los estilos.
     * Nota: Mantén los estilos y capas bien organizados para facilitar el mantenimiento.
     */
   // En el método initializeMap(), modifica la capa maptiler_satellite:

    initializeMap() {
        // Definir capas base
        this.baseLayers = {
            osm: new ol.layer.Tile({
                source: new ol.source.OSM(),
                visible: true,
                title: 'OpenStreetMap'
            }),
            satellite: new ol.layer.Tile({
                source: new ol.source.XYZ({
                    url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                    attributions: 'Tiles © Esri'
                }),
                visible: false,
                title: 'Satélite Esri'
            }),
            terrain: new ol.layer.Tile({
                source: new ol.source.XYZ({
                    url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Shaded_Relief/MapServer/tile/{z}/{y}/{x}',
                    attributions: 'Tiles © Esri'
                }),
                visible: false,
                title: 'Relieve'
            }),
            dark: new ol.layer.Tile({
                source: new ol.source.XYZ({
                    url: 'https://{a-c}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png',
                    attributions: '© CartoDB'
                }),
                visible: false,
                title: 'Oscuro'
            }),
            // CAPA MAPTILER SATELLITE CON TU API KEY
            maptiler_satellite: new ol.layer.Tile({
                source: new ol.source.XYZ({
                    url: 'https://api.maptiler.com/maps/satellite/{z}/{x}/{y}.jpg?key=scUozK4fig7bE6jg7TPi',
                    attributions: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
                    tileSize: 512,
                    maxZoom: 20
                }),
                visible: false,
                title: 'MapTiler Satélite'
            })
        };

        // También puedes ajustar la vista inicial a tu ubicación de Venezuela
        const initialCenter = ol.proj.fromLonLat([-63.26716, 10.63673]); // [lon, lat]
        const initialZoom = 12; // Ajusta según necesites

        // Resto del código de GFW y capas vectoriales permanece igual...
        const GFW_LOSS_URL = 'https://tiles.globalforestwatch.org/umd_tree_cover_loss/latest/dynamic/{z}/{x}/{y}.png';

        this.gfwLossLayer = new ol.layer.Tile({
            source: new ol.source.XYZ({
                url: GFW_LOSS_URL,
                attributions: 'Hansen/UMD/Google/USGS/NASA | GFW',
            }),
            opacity: 0.9, 
            visible: false,
            title: 'Pérdida Arbórea GFW'
        });

        // Fuente vectorial para geometrías dibujadas/importadas
        this.source = new ol.source.Vector();

        // Estilo para polígonos
        this.polygonStyle = new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'rgba(26, 166, 30, 0.63)',
                width: 3
            }),
            fill: new ol.style.Fill({
                color: 'rgba(0, 255, 55, 0.2)'
            })
        });

        // Estilo para puntos/vértices
        this.pointStyle = new ol.style.Style({
            image: new ol.style.Circle({
                radius: 6,
                fill: new ol.style.Fill({ color: 'red' }),
                stroke: new ol.style.Stroke({ color: 'white', width: 2 })
            })
        });

        // Estilo para etiquetas sobre los polígonos
        this.labelStyle = new ol.style.Style({
            text: new ol.style.Text({
                text: '', // Se asigna dinámicamente
                font: 'bold 14px Arial',
                fill: new ol.style.Fill({ color: '#000000' }),
                stroke: new ol.style.Stroke({ color: '#04a3072b', width: 3 }),
                offsetY: -20,
                overflow: true,
                backgroundFill: new ol.style.Fill({
                    color: 'rgba(242, 242, 242, 0.52)'
                }),
                padding: [3, 8, 3, 8]
            })
        });

        // Capa vectorial con soporte para etiquetas
        const vectorLayer = new ol.layer.Vector({
            source: this.source,
            style: (feature) => {
                const geometry = feature.getGeometry();
                const styles = [this.polygonStyle];

                // Si la feature tiene 'label', mostrarla como etiqueta sobre el polígono
                const label = feature.get('label');
                if (label && geometry.getType() !== 'Point') {
                    const labelStyle = this.labelStyle.clone();
                    labelStyle.getText().setText(label);

                    // Ubicar la etiqueta en el centro del polígono
                    const center = ol.extent.getCenter(geometry.getExtent());
                    const pointFeature = new ol.Feature({
                        geometry: new ol.geom.Point(center)
                    });
                    pointFeature.setStyle(labelStyle);

                    // Añadir la etiqueta como feature separada (no afecta el backend)
                    this.source.addFeature(pointFeature);
                }
                return styles;
            }
        });

        // Grupo de capas base
        const baseLayerGroup = new ol.layer.Group({
            layers: Object.values(this.baseLayers)
        });

        // Inicializar el mapa con la nueva ubicación
        this.map = new ol.Map({
            target: 'map',
            layers: [baseLayerGroup, vectorLayer, this.gfwLossLayer],
            view: new ol.View({
                center: initialCenter, // Usa la nueva ubicación
                zoom: initialZoom      // Usa el nuevo zoom
            })
        });

        this.currentBaseLayer = this.baseLayers.osm;
    }

    /**
     * Permite cambiar la capa base del mapa.
     * @param {string} layerKey - Clave de la capa base ('osm', 'satellite', etc.)
     */
    
    changeBaseLayer(layerKey) {
        
        Object.values(this.baseLayers).forEach(layer => layer.setVisible(false));
        this.baseLayers[layerKey].setVisible(true);
        this.currentBaseLayer = this.baseLayers[layerKey];
    }

    /**
     * Configura los listeners de los botones y el formulario.
     * Nota: Mantén los IDs consistentes en el HTML.
     */
    setupEventListeners() {
        document.getElementById('draw-polygon').addEventListener('click', () => this.activateDrawing());
        document.getElementById('clear-map').addEventListener('click', () => this.clearMap());
        document.getElementById('analysis-form').addEventListener('submit', (e) => this.handleFormSubmit(e));
    }

    /**
     * Configura el display de coordenadas UTM/geográficas en el mapa.
     * Nota: Útil para usuarios técnicos y para depuración.
     */
    setupCoordinateDisplay() {
    console.log('🟢 INICIANDO COORDINATE DISPLAY UTM...');
    
    // Eliminar cualquier display anterior
    const existingDisplays = document.querySelectorAll('.coordinate-display');
    existingDisplays.forEach(display => display.remove());
    
    this.coordinateDisplay = document.createElement('div');
    this.coordinateDisplay.className = 'coordinate-display';
    this.coordinateDisplay.style.display = 'none';
    
    const mapContainer = this.map.getTargetElement();
    mapContainer.appendChild(this.coordinateDisplay);

    // **SOLUCIÓN SIMPLIFICADA Y CONFIABLE**
    this.map.on('pointermove', (evt) => {
        if (evt.dragging) return;
        
        const coordinate = evt.coordinate;
        const lonLat = ol.proj.toLonLat(coordinate);
        const lon = lonLat[0];
        const lat = lonLat[1];
        
        // Calcular zona UTM
        const zone = Math.floor((lon + 180) / 6) + 1;
        const hemisphere = lat >= 0 ? 'north' : 'south';
        
        // **CONVERSIÓN MANUAL SIMPLIFICADA - SIN DEPENDER DE PROYECCIONES UTM**
        // Fórmula aproximada para mostrar UTM (solo para display, no para cálculos precisos)
        const earthRadius = 6378137; // Radio terrestre en metros
        const scale = 0.9996; // Factor de escala UTM
        
        // Coordenadas relativas al meridiano central
        const centralMeridian = (zone * 6 - 183) * (Math.PI / 180);
        const lonRad = lon * (Math.PI / 180);
        const latRad = lat * (Math.PI / 180);
        
        // Cálculo simplificado de UTM
        const x = (lonRad - centralMeridian) * earthRadius * scale + 500000;
        const y = Math.log(Math.tan(Math.PI/4 + latRad/2)) * earthRadius * scale;
        const northing = hemisphere === 'north' ? y : 10000000 + y;
        
        // **MOSTRAR SOLO UTM**
        this.coordinateDisplay.textContent = 
            `Zona ${zone}${hemisphere === 'north' ? 'N' : 'S'} | ` +
            `Este: ${x.toFixed(2)} m | ` +
            `Norte: ${northing.toFixed(2)} m`;
            
        this.coordinateDisplay.style.display = 'block';
    });

    
}

    /**
     * Activa la herramienta de dibujo de polígonos.
     * Limpia interacciones previas y muestra instrucciones.
     */
    
    activateDrawing() {
        if (this.draw) this.map.removeInteraction(this.draw);

        this.draw = new ol.interaction.Draw({
            source: this.source,
            type: 'Polygon',
            style: (feature) => {
                const geometry = feature.getGeometry();
                const styles = [this.polygonStyle];

                /* esto da puntos feo en el mapa */
               /*  if (geometry.getType() === 'Polygon') {
                    geometry.getCoordinates()[0].forEach(coordinate => {
                        const point = new ol.Feature({ geometry: new ol.geom.Point(coordinate) });
                        point.setStyle(this.pointStyle);
                        this.source.addFeature(point);
                    });
                } */
                return styles;
            }
        });

        // Evento al terminar de dibujar el polígono
        this.draw.on('drawend', (event) => {
            const feature = event.feature;

            // =======================================================
            //  MODIFICACIÓN CLAVE PARA INSPECCIÓN POR CONSOLA
            // =======================================================
            console.group(' Feature OpenLayers Capturada (Draw End)');
            console.log('Objeto Feature:', feature);
            
            // 1. Mostrar Geometría (en EPSG:3857)
            const geometry = feature.getGeometry();
            console.log('Tipo de Geometría:', geometry.getType());
            console.log('Coordenadas (EPSG:3857):', geometry.getCoordinates());
            
            // 2. Convertir y mostrar en Lat/Lon (EPSG:4326)
            const geojsonFormat = new ol.format.GeoJSON();
            const geojsonString = geojsonFormat.writeFeature(feature, {
                dataProjection: 'EPSG:4326',
                featureProjection: 'EPSG:3857'
            });
            const geojsonObj = JSON.parse(geojsonString);
            console.log('Coordenadas GeoJSON (EPSG:4326):', geojsonObj.geometry.coordinates);
            
            console.groupEnd();

            // =======================================================

            // Limpiar puntos anteriores
            this.source.getFeatures().forEach(f => {
                if (f.getGeometry().getType() === 'Point') this.source.removeFeature(f);
            });
            // Calcular y mostrar área aproximada
            const areaHa = this.calculateArea(feature);
            this.showAlert(`Polígono dibujado. Área aproximada: ${areaHa} hectáreas`);
            // Guardar la geometría
            this.convertToGeoJSON(feature);
            // Desactivar la interacción de dibujo
            this.map.removeInteraction(this.draw);
        });

        this.map.addInteraction(this.draw);
        this.showAlert('Dibuja el área de interés en el mapa. Haz clic para añadir vértices y doble clic para terminar.');
    }

    /**
     * Calcula el área de un polígono en hectáreas.
     * @param {ol.Feature} feature
     * @returns {number}
     */
    calculateArea(feature) {
        const geometry = feature.getGeometry();
        const area = ol.sphere.getArea(geometry);
        return Math.round(area / 10000); // m² a hectáreas
    }

    /**
     * Convierte la geometría a GeoJSON y la guarda en el input oculto.
     * @param {ol.Feature} feature
     */
    convertToGeoJSON(feature) {
        try {
            const format = new ol.format.GeoJSON();
            const geojson = format.writeFeature(feature, {
                dataProjection: 'EPSG:4326',
                featureProjection: 'EPSG:3857'
            });
            const geojsonObj = JSON.parse(geojson);
            if (!geojsonObj.geometry) throw new Error('El polígono no tiene geometría válida');
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
     * Valida que exista un polígono y permite el envío normal del formulario.
     * @param {Event} event
     */
    handleFormSubmit(event) {
        // 1. Detener el envío automático del formulario
        event.preventDefault(); 

        const geometryInput = document.getElementById('geometry');
        
        // 2. VALIDACIÓN: Revisar si el campo de geometría (que fue llenado por convertToGeoJSON) tiene un valor
        if (!geometryInput.value) {
            this.showAlert('Por favor, dibuja o importa un área de interés.', 'error');
            return; // Detener la ejecución
        }

        const form = event.target;
        // Selecciona el botón de tipo 'submit' dentro del formulario
        const submitButton = form.querySelector('button[type="submit"]');
        // Selecciona el elemento spinner (que debe estar oculto por defecto)
        const spinner = document.getElementById('loading-spinner');
        
        // Deshabilita el botón
        if (submitButton) {
            submitButton.disabled = true;
            // Opcional: Cambia el texto del botón
            submitButton.textContent = 'Analizando...'; 
        }

        // Muestra el spinner (asumiendo que 'd-none' de Tailwind/Bootstrap lo oculta)
        if (spinner) {
            spinner.classList.remove('d-none');
        }
        
        // 4. Enviar el formulario
        // El campo 'geometry' ya fue llenado por convertToGeoJSON (si se dibujó) o por importGeoJSON/KML.
        form.submit();
    }


    /**
     * Muestra una alerta al usuario.
     * Usa SweetAlert2 si está disponible, si no usa alert nativo.
     * @param {string} message
     * @param {string} [icon='info']
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
     * @param {Object} geojson
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

            features.forEach(feature => {
                this.source.addFeature(feature);
                const name = feature.get('name') || feature.get('Nombre') || feature.get('NOMBRE') || feature.get('title') || feature.get('Productor');
                if (name) {
                    feature.set('label', name);
                    feature.set('productor', name);
                }
            });

            const extent = this.source.getExtent();
            this.map.getView().fit(extent, { padding: [50, 50, 50, 50], duration: 1000 });

            document.getElementById('geometry').value = JSON.stringify(geojson);

            this.processMultiPolygonInfo(features);

            this.showAlert('Áreas importadas correctamente.', 'success');
        } catch (error) {
            this.showAlert('Error al importar el área: ' + error.message, 'error');
        }
    }

    /**
     * Importa uno o varios polígonos desde un string KML y los dibuja en el mapa.
     * Extrae nombres/productores si existen.
     * @param {string} kmlText
     */
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

            features.forEach(feature => {
                const productor = this.extractKMLData(feature);
                if (productor) {
                    feature.set('label', productor);
                    feature.set('productor', productor);
                }
                this.source.addFeature(feature);
            });

            const extent = this.source.getExtent();
            this.map.getView().fit(extent, { padding: [50, 50, 50, 50], duration: 1000 });

            // Guardar como FeatureCollection
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

            this.processMultiPolygonInfo(features);

            this.showAlert(`${features.length} áreas importadas correctamente.`, 'success');
        } catch (error) {
            this.showAlert('Error al importar el área KML: ' + error.message, 'error');
        }
    }

    /**
     * Extrae el nombre/productor de una feature KML.
     * Nota: Adapta según la estructura de tus archivos KML.
     * @param {ol.Feature} feature
     * @returns {string|null}
     */
    extractKMLData(feature) {
        try {
            const kmlDescription = feature.get('description');
            if (!kmlDescription) return null;
            const parser = new DOMParser();
            const doc = parser.parseFromString(kmlDescription, 'text/html');
            const simpleDataElements = doc.querySelectorAll('simpledata');
            const data = {};
            simpleDataElements.forEach(el => {
                const name = el.getAttribute('name');
                const value = el.textContent;
                if (name && value) data[name.toLowerCase()] = value;
            });
            return data.productor || data.name || data.nombre || null;
        } catch (error) {
            console.warn('Error extrayendo datos KML:', error);
            return null;
        }
    }

    /**
     * Procesa información de múltiples polígonos y la muestra en una tabla.
     * Nota: Útil para mostrar resumen de productores, localidad y área.
     * @param {Array<ol.Feature>} features
     */
    processMultiPolygonInfo(features) {
        const polygonsInfo = [];
        features.forEach(feature => {
            const geometry = feature.getGeometry();
            if (geometry.getType() === 'Polygon') {
                const productor = feature.get('productor') || feature.get('name') || 'Propietario desconocido';
                const areaHa = this.calculateArea(feature);
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

    /**
     * Muestra la información de los polígonos en una tabla HTML.
     * Nota: El contenedor y la tabla deben existir en el HTML.
     * @param {Array<Object>} polygonsInfo
     */
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

    /**
     * Aplica el estado de visibilidad a los íconos del botón y a la capa GFW.
     * @param {boolean} isVisible - Si la capa debe ser visible (true) u oculta (false).
     */
    applyGfwLayerState(isVisible) {
        const iconVisible = document.getElementById('icon-eye-open');
        const iconHidden = document.getElementById('icon-eye-closed');
        
        // 1. Lógica de ÍCONOS (Ojo Abierto o Cerrado)
        if (iconVisible && iconHidden) {
            // Mostrar ojo abierto si es visible
            iconVisible.style.display = isVisible ? 'inline-block' : 'none';
            // Mostrar ojo tachado si está oculta
            iconHidden.style.display = isVisible ? 'none' : 'inline-block';
        }

        // 2. Lógica del MAPA (Alternar visibilidad en OpenLayers)
        if (this.gfwLossLayer) {
            // Usamos el método nativo de OpenLayers para controlar la visibilidad
            this.gfwLossLayer.setVisible(isVisible);
            console.log(`Capa GFW: ${isVisible ? 'VISIBLE' : 'OCULTA'}`);
        }
    }

    /**
     * Configura el botón de alternancia, la persistencia con localStorage y previene el parpadeo.
     */
    initializeGfWLayerToggle() {
        // Usamos DOMContentLoaded para garantizar que el botón existe, aunque ya estamos en el constructor.
        // Lo incluimos aquí por seguridad. Si usas un patrón de módulo, esto podría ir fuera del constructor.
        
        const toggleButton = document.getElementById('visibility-toggle-button');
        
        if (!toggleButton) return;

        // 1. Obtener el estado guardado (Persistencia)
        let storedState = localStorage.getItem(this.STORAGE_KEY);
        // Si el estado guardado es 'false', isLayerVisible será false; de lo contrario, true.
        let isLayerVisible = storedState === 'false' ? false : true;
        
        // 2. Aplicar el estado inicial
        // Se llama a la función de control para ajustar los íconos y la visibilidad de la capa ANTES de mostrar el botón.
        this.applyGfwLayerState(isLayerVisible);
        
        // 3. Revelar el botón (Previene el Parpadeo)
        // Se remueve la clase 'invisible' de Tailwind CSS.
        toggleButton.classList.remove('invisible');

        // 4. Asignar el evento click
        toggleButton.addEventListener('click', () => {
            isLayerVisible = !isLayerVisible; // Invertir el estado
            this.applyGfwLayerState(isLayerVisible); // Aplicar el nuevo estado
            // Guardar el nuevo estado en localStorage
            localStorage.setItem(this.STORAGE_KEY, isLayerVisible.toString()); 
        });
    }
}

// Inicializar el mapa cuando el documento esté listo
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('map')) {
        window.deforestationMapInstance = new DeforestationMap();
    }
});

/**
 * NOTAS:
 * - Mantén los IDs y clases del HTML consistentes con los usados en el JS.
 * - Para soporte SHP, asegúrate de incluir la librería shpjs y llamar a importGeoJSON con el resultado.
 * - El método displayPolygonsInfo requiere un contenedor y una tabla en el HTML:
 *   <div id="producers-info" class="hidden">
 *     <table><tbody id="producers-list"></tbody></table>
 *   </div>
 * - Puedes personalizar los estilos y campos según tus necesidades.
 * - El código está ampliamente comentado para facilitar el mantenimiento y la extensión.
 */


// logia para el boton de mostrar u ocultar capa de deforestacion

/* document.addEventListener('DOMContentLoaded', (event) => {
    // 1. Obtener referencias
    const toggleButton = document.getElementById('visibility-toggle-button');
    const iconVisible = document.getElementById('icon-eye-open');
    const iconHidden = document.getElementById('icon-eye-closed');
    const STORAGE_KEY = 'polygonVisibilityState';

    // 2. Función para aplicar el estado (Actualiza iconos y estado interno)
    function applyState(isVisible) {
        if (isVisible) {
            // Estado VISIBLE: Mostrar icono de Ojo Abierto, ocultar Ojo Tachado
            iconVisible.style.display = 'inline-block';
            iconHidden.style.display = 'none';
            // Lógica REAL para hacer el polígono visible
        } else {
            // Estado OCULTO: Mostrar icono de Ojo Tachado, ocultar Ojo Abierto
            iconVisible.style.display = 'none';
            iconHidden.style.display = 'inline-block';
            // Lógica REAL para hacer el polígono invisible
        }
    }

    // 3. Inicializar el estado al cargar la página (ANTES de mostrar el botón)
    let storedState = localStorage.getItem(STORAGE_KEY);
    let isPolygonVisible = storedState === 'false' ? false : true;
    
    // Aplicar el estado inicial (el botón sigue invisible)
    applyState(isPolygonVisible);
    
    // **Paso clave para evitar el parpadeo:**
    // Una vez que el estado correcto se aplica a los iconos, mostramos el botón.
    if (toggleButton) {
        toggleButton.classList.remove('invisible');
        toggleButton.classList.add('visible'); // o la clase que maneje la visibilidad
    }

    // 4. Función para alternar y guardar el estado
    function toggleIconAndSave() {
        isPolygonVisible = !isPolygonVisible;
        applyState(isPolygonVisible);
        localStorage.setItem(STORAGE_KEY, isPolygonVisible.toString());
        console.log(`Estado guardado: ${isPolygonVisible}`);
    }

    // 5. Asignar el evento click
    if (toggleButton) {
        toggleButton.addEventListener('click', toggleIconAndSave);
    }
}); */

