// Animación para el menú de usuario

document.addEventListener('DOMContentLoaded', function() {
    const userMenuToggle = document.getElementById('userMenuToggle');
    const userMenu = document.getElementById('userMenu');
    let isUserMenuOpen = false;

    function toggleUserMenu(show) {
        if (show) {
            userMenu.classList.remove('hidden');
            // Forzar reflow para que la animación funcione
            void userMenu.offsetWidth;
            userMenu.classList.remove('scale-95', 'opacity-0');
            userMenu.classList.add('scale-100', 'opacity-100');
            isUserMenuOpen = true;
        } else {
            userMenu.classList.remove('scale-100', 'opacity-100');
            userMenu.classList.add('scale-95', 'opacity-0');
            // Esperar a que termine la animación antes de ocultar
            setTimeout(() => {
                if (!isUserMenuOpen) {
                    userMenu.classList.add('hidden');
                }
            }, 300);
            isUserMenuOpen = false;
        }
    }

    userMenuToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        const willShow = !isUserMenuOpen;
        toggleUserMenu(willShow);
    });

    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (isUserMenuOpen && !userMenu.contains(e.target) && !userMenuToggle.contains(e.target)) {
            toggleUserMenu(false);
        }
    });

    // Cerrar menú con tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isUserMenuOpen) {
            toggleUserMenu(false);
        }
    });

    // Cerrar menú al hacer clic en un enlace (opcional)
    userMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function() {
            toggleUserMenu(false);
        });
    });
});
