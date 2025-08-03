<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistema de Gestion Geografica') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- DataTables CSS (CDN) -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/css/styleDas.css', 'resources/css/DataTableCss.css'])

        <!-- Lucide Icons (mejor práctica) -->
        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            lucide.createIcons(); // Inicializa los íconos
        </script>
    </head>
    
    <body class="bg-gray-50">
        <!-- Mobile sidebar overlay -->
        <div id="sidebarOverlay" class="sidebar-overlay"></div>

        <!-- Mobile dark mode toggle button -->
        <button id="mobileDarkToggle" class="mobile-dark-toggle">
            <i id="mobileDarkIcon" data-lucide="sun" class="w-6 h-6 text-white"></i>
        </button>

        <div class="flex h-screen">
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
        @vite(['resources/js/app.js', 'resources/js/DashFunctions.js', 'resources/js/DataTableJs.js'])
        
       
    </body>
</html>