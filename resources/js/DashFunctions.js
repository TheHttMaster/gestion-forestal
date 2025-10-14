
// --- SIDEBAR TOGGLE ---
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');
let sidebarCollapsed = false;

// --- SIDEBAR STATE MEMORY ---
// Guarda el estado del sidebar en localStorage
function saveSidebarState(collapsed) {
    localStorage.setItem('sidebarCollapsed', collapsed ? '1' : '0');
}

// Recupera el estado del sidebar desde localStorage
function getSidebarState() {
    return localStorage.getItem('sidebarCollapsed') === '1';
}

// Aplica el estado guardado del sidebar al cargar la página (antes de mostrarlo)
function initializeSidebarState() {
    if (window.innerWidth > 768) { // Solo aplica en escritorio
        sidebarCollapsed = getSidebarState();
        if (sidebarCollapsed) {
            sidebar.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed');
        }
    } else {
        sidebar.classList.remove('collapsed');
    }
}

// Llama a la función lo antes posible para evitar parpadeo visual
initializeSidebarState();

// Maneja la apertura/cierre del sidebar (responsive y desktop)
sidebarToggle.addEventListener('click', () => {
    if (window.innerWidth <= 768) {
        // Sidebar móvil
        sidebar.classList.toggle('mobile-open');
        sidebarOverlay.classList.toggle('show');
    } else {
        // Sidebar escritorio
        sidebarCollapsed = !sidebarCollapsed;
        saveSidebarState(sidebarCollapsed); // Guarda el estado
        const icons = sidebar.querySelectorAll('.nav-item i, .sidebar-header i');
        const texts = sidebar.querySelectorAll('.sidebar-text');
        if (sidebarCollapsed) {
            sidebar.classList.add('collapsed');
            icons.forEach(icon => {
                icon.style.width = '1.75rem';
                icon.style.minWidth = '1.75rem';
                icon.style.maxWidth = '1.75rem';
            });
            texts.forEach(text => text.classList.remove('delayed-opacity'));
        } else {
            sidebar.classList.remove('collapsed');
            icons.forEach(icon => {
                icon.style.width = '1.75rem';
                icon.style.minWidth = '1.75rem';
                icon.style.maxWidth = '1.75rem';
            });
            // Añade animación de opacidad al expandir
            texts.forEach(text => text.classList.add('delayed-opacity'));
            setTimeout(() => {
                texts.forEach(text => text.classList.remove('delayed-opacity'));
            }, 700); // 0.2s delay + 0.5s transition
        }
        // Limpia estilos inline de iconos tras la animación
        setTimeout(() => {
            icons.forEach(icon => {
                icon.style.width = '';
                icon.style.minWidth = '';
                icon.style.maxWidth = '';
                
            });
        }, 400);

        setTimeout(() => {
        if (window.deforestationMapInstance && window.deforestationMapInstance.map) {
            window.deforestationMapInstance.map.updateSize();
            }
        }, 400); // 400ms para asegurar que la transición terminó

    }
});

// Cierra el sidebar móvil al hacer click en el overlay
sidebarOverlay.addEventListener('click', () => {
    sidebar.classList.remove('mobile-open');
    sidebarOverlay.classList.remove('show');
});

// Ajusta el sidebar al cambiar el tamaño de la ventana
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        sidebar.classList.remove('mobile-open');
        sidebarOverlay.classList.remove('show');
        initializeSidebarState(); // Reaplica el estado guardado en escritorio
    } else {
        sidebar.classList.remove('collapsed'); // Siempre abierto en móvil
    }
});

// --- DROPDOWN DE USUARIO ---
const userMenuToggle = document.getElementById('userMenuToggle');
const userMenu = document.getElementById('userMenu');
userMenuToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    userMenu.classList.toggle('show');
});
document.addEventListener('click', (e) => {
    if (!userMenuToggle.contains(e.target) && !userMenu.contains(e.target)) {
        userMenu.classList.remove('show');
    }
});

// --- ESTADO ACTIVO DE NAVEGACIÓN ---
const navItems = document.querySelectorAll('.nav-item');
navItems.forEach(item => {
    item.addEventListener('click', () => {
        navItems.forEach(nav => nav.classList.remove('active'));
        item.classList.add('active');
        // Cierra sidebar móvil al navegar
        if (window.innerWidth <= 768) {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('show');
        }
    });
});

// --- ANIMACIÓN DE TARJETAS AL CARGAR ---
document.querySelectorAll('.bg-white.rounded-xl').forEach((card, idx) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'all 0.6s ease';
    setTimeout(() => {
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
    }, idx * 100); // Efecto cascada
});

// --- MODO OSCURO SIMPLIFICADO ---
const darkModeToggle = document.getElementById('darkModeToggle');
const mobileDarkToggle = document.getElementById('mobileDarkToggle');
const mobileDarkIcon = document.getElementById('mobileDarkIcon');
const htmlElement = document.documentElement;

// Función para actualizar el icono móvil (se usa en ambos lugares)
function updateMobileIcon(isDark) {
    if (mobileDarkIcon) {
        if (isDark) {
            // Modo oscuro activado - mostrar sol
            mobileDarkIcon.innerHTML = `
                <circle cx="12" cy="12" r="4"/>
                <path d="M12 2v2"/><path d="M12 20v2"/>
                <path d="m4.93 4.93 1.41 1.41"/>
                <path d="m17.66 17.66 1.41 1.41"/>
                <path d="M2 12h2"/><path d="M20 12h2"/>
                <path d="m6.34 17.66-1.41 1.41"/>
                <path d="m19.07 4.93-1.41 1.41"/>
            `;
        } else {
            // Modo claro activado - mostrar luna
            mobileDarkIcon.innerHTML = `
                <path d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.46.402.803a6 6 0 0 0 8.268 8.268c.344-.215.825-.004.803.401"/>
            `;
        }
    }
}

// Alterna el modo oscuro/claro
function toggleDarkMode() {
    const isDark = htmlElement.classList.contains('dark');
    
    if (isDark) {
        htmlElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    } else {
        htmlElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    }
    
    // Actualiza todos los controles inmediatamente
    const newIsDark = !isDark;
    if (darkModeToggle) {
        darkModeToggle.checked = newIsDark;
    }
    updateMobileIcon(newIsDark);
}

// Solo añade los event listeners aquí (la inicialización ya se hizo en app.blade.php)
document.addEventListener('DOMContentLoaded', function() {
    // Listeners para los toggles
    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', toggleDarkMode);
    }
    
    if (mobileDarkToggle) {
        mobileDarkToggle.addEventListener('click', toggleDarkMode);
    }
});

// Detecta cambios en la preferencia del sistema (solo si no hay preferencia guardada)
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
    if (!localStorage.getItem('theme')) {
        if (e.matches) {
            htmlElement.classList.add('dark');
        } else {
            htmlElement.classList.remove('dark');
        }
        // Actualiza controles
        const isDark = htmlElement.classList.contains('dark');
        if (darkModeToggle) darkModeToggle.checked = isDark;
        updateMobileIcon(isDark);
    }
});



/*
NOTA:
- initializeSidebarState() se llama antes de cualquier render visual del sidebar.
- Así, si el usuario dejó el sidebar cerrado, no se verá abierto al recargar y luego cerrarse, evitando el "parpadeo".
- El estado se mantiene en localStorage y se aplica automáticamente al cargar la página.
- Se mejoró la lógica de apertura/cierre del sidebar en dispositivos móviles y escritorios.
- Se optimizó el manejo de eventos y se aseguró una experiencia de usuario fluida y consistente.
- Se mantuvieron las animaciones y transiciones suaves para el sidebar, dropdown de usuario y tarjetas.
- Se garantizó la accesibilidad y usabilidad en todos los dispositivos y tamaños de pantalla.
- Se mejoró la estructura general del código y se eliminaron comentarios innecesarios.
*/

/* DECLARACION DEL DATATABLE PARA LAS TABLAS */

$(document).ready(function() {
    $('#auditoria-table').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        },
        "columnDefs": [
            { "width": "20%", "targets": 0 },  // ID
            { "width": "40%", "targets": 1 }, // Nombre
            { "width": "40%", "targets": 2 }  // Acción
        ]
    });
});

$(document).ready(function() {
    $('#audit-table').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        }
    }); 
});
    


/* prueva para la carga del datatable a ver si carga mejor */
$(document).ready(function() {
    $('#users-table').DataTable({

        
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        },
        "columnDefs": [
            { "width": "5%", "targets": 0 },  // ID
            { "width": "20%", "targets": 1 }, // Nombre
            { "width": "34%", "targets": 2 }, // Email
            { "width": "20%", "targets": 3 }, // Rol
            { "width": "6%", "targets": 4 }  // Acción
        ]
    }); 

});

    // Configuración de DataTables
   
