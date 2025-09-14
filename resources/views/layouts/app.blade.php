<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistema de Gestion Geografica</title>

        @livewireStyles
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Super importante para usar en la convercion de los mapas, no borrar --}}
        <script src="https://unpkg.com/shpjs@latest/dist/shp.min.js"></script>

        {{-- Super importante para usar en la convercion de los mapas, no borrar --}}
        <script src="https://unpkg.com/shpjs@latest/dist/shp.min.js"></script>

        <!-- Styles -->
        @vite([
            'resources/css/app.css', 
            'resources/css/styleDas.css', 
            'resources/css/DataTableCss.css',
            'resources/js/app.js'
        ])

        {{-- Estilos y scripts específicos del head --}}
        @yield('head-styles')
        @yield('head-scripts')
         <script>
        // Verifica el tema guardado o el preferido del sistema ANTES de renderizar
        const storedTheme = localStorage.getItem('theme') || 
        (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        
            if (storedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            }

            // Aplica sidebar colapsado antes de pintar (solo escritorio)
            if (window.innerWidth > 768 && localStorage.getItem('sidebarCollapsed') === '1') {
                // Espera a que el sidebar esté en el DOM y aplica la clase lo antes posible
                const applySidebarCollapsed = () => {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar && !sidebar.classList.contains('collapsed')) {
                        sidebar.classList.add('collapsed');
                        return true;
                    }
                    return false;
                };
                if (!applySidebarCollapsed()) {
                    // Si aún no existe, observa el DOM hasta que aparezca
                    const observer = new MutationObserver(() => {
                        if (applySidebarCollapsed()) observer.disconnect();
                    });
                    observer.observe(document.documentElement, { childList: true, subtree: true });
                }
            }
        </script>

    </head>
    
    <body class="bg-neutral-200 dark:bg-custom-dark ">
        <!-- Mobile sidebar overlay -->
        <div id="sidebarOverlay" class="sidebar-overlay"></div>

        <!-- Mobile dark mode toggle button -->
        <button id="mobileDarkToggle" class="mobile-dark-toggle">
            <svg id="mobileDarkIcon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun-icon lucide-sun w-6 h-6 text-white">
                <circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
            </svg>
        </button>

        <div class="flex h-screen ">
            @include('layouts.navigation')
            
            <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
       
        <!-- Scripts locales (optimizado) -->
        @vite([
            'resources/js/jquery-3.7.1.min.js',
            'resources/js/app.js', 
            'resources/js/DataTableJs.js',
            'resources/js/DashFunctions.js'
        ])
    @if(session('swal'))
    <script>
        /* Alerta para las notificaciones de la confirmación de las cosas */
        document.addEventListener('DOMContentLoaded', function() {
            const swalData = @json(session('swal'));
            Swal.fire({
                position: "top-end",
                icon: swalData.icon,
                title: swalData.title,
                showConfirmButton: false,
                timer: 3700,
                timerProgressBar: true,
                toast: true,
                width: '380px',
                padding: '1rem',
                html: `<div class="text-center">
                         <p class="text-sm text-gray-700 dark:text-gray-300">${swalData.text ?? ''}</p>
                       </div>`,
                customClass: {
                    popup: 'rounded-xl shadow-lg bg-stone-100/95 dark:bg-custom-gray border border-gray-200 dark:border-gray-700',
                    title: 'text-lg font-semibold text-gray-900 dark:text-white mb-1',
                    htmlContainer: 'text-sm text-gray-600 dark:text-gray-300',
                    timerProgressBar: 'bg-gradient-to-r from-emerald-400 to-emerald-600'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInRight animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutRight animate__faster'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
            // Limpiar la sesión flash después de mostrar
            fetch('/clear-swal-session', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
        });
    </script>
@endif
@livewireScripts
    </body>
</html>