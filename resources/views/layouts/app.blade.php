<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sistema de Gestion Geografica</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- DataTables CSS (CDN) -->
       
        
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/css/styleDas.css'])
        

         <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

        <!-- Lucide Icons (mejor práctica) -->
        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            lucide.createIcons(); // Inicializa los íconos
        </script>
        <script>
        // Verifica el tema guardado o el preferido del sistema ANTES de renderizar
        const storedTheme = localStorage.getItem('theme') || 
        (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        
            if (storedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        </script>
       
    </head>
    
    <body class="bg-neutral-200 dark:bg-custom-dark ">
        <!-- Mobile sidebar overlay -->
        <div id="sidebarOverlay" class="sidebar-overlay"></div>

        <!-- Mobile dark mode toggle button -->
        <button id="mobileDarkToggle" class="mobile-dark-toggle">
            <i id="mobileDarkIcon" data-lucide="sun" class="w-6 h-6 text-white"></i>
        </button>

        <div class="flex h-screen ">
            @include('layouts.navigation')
            
            <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>

        <!-- jQuery (CDN) -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        
        <!-- DataTables JS (CDN) -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        
        <!-- Scripts locales (optimizado) -->
        @vite(['resources/js/app.js', 'resources/js/DashFunctions.js'])
        
       
    </body>
</html>