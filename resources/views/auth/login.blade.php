<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestion Geografica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
    // Verifica el tema guardado o el preferido del sistema ANTES de renderizar
    const storedTheme = localStorage.getItem('theme') || 
    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    
        if (storedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
   
   <script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                     // Tus colores personalizados
                    custom: {
                        dark: '#07090cff',       // Antes .a.mber-900
                        light: '#e7e5dbff',      // Antes a.mber-50
                        gray: '#0d0f16ff', 
                        gold: {
                            light: '#e2ad39ff',    // Antes a.mber-300
                            medium: '#cf7f17ff',   // Antes a.mber-400
                            dark: '#ce7829ff',     // Antes a.mber-500
                            darker: '#7e4a0eff',   // Antes a.mber-600
                            darkest: '#503017ff'   // Antes a.mber-700
                        },
                        brown: '#7c4728ff'       // Antes a.mber-800
                        },
                        
                    amber: {
                        
                        700: '#503017ff',
                        800: '#7c4728ff',
                        
                    },
                  
                }
            }
        }
    }
</script>
 <style>
        /* Estilos del SVG de fondo */
        .svg-background {
            position: fixed;
            
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.20;
            pointer-events: none;
        }
        .dark .svg-background {
            opacity: 0.15;
        }
    </style>
</head>
<body class="min-h-screen bg-neutral-300 dark:bg-custom-dark transition-colors duration-300">
    <!-- Fondo SVG -->
    <div class="svg-background">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 304 304" class="w-full h-full" preserveAspectRatio="xMidYMid slice">
            <path fill="#ce7829ff" d="M44.1 224a5 5 0 1 1 0 2H0v-2h44.1zm160 48a5 5 0 1 1 0 2H82v-2h122.1zm57.8-46a5 5 0 1 1 0-2H304v2h-42.1zm0 16a5 5 0 1 1 0-2H304v2h-42.1zm6.2-114a5 5 0 1 1 0 2h-86.2a5 5 0 1 1 0-2h86.2zm-256-48a5 5 0 1 1 0 2H0v-2h12.1zm185.8 34a5 5 0 1 1 0-2h86.2a5 5 0 1 1 0 2h-86.2zM258 12.1a5 5 0 1 1-2 0V0h2v12.1zm-64 208a5 5 0 1 1-2 0v-54.2a5 5 0 1 1 2 0v54.2zm48-198.2V80h62v2h-64V21.9a5 5 0 1 1 2 0zm16 16V64h46v2h-48V37.9a5 5 0 1 1 2 0zm-128 96V208h16v12.1a5 5 0 1 1-2 0V210h-16v-76.1a5 5 0 1 1 2 0zm-5.9-21.9a5 5 0 1 1 0 2H114v48H85.9a5 5 0 1 1 0-2H112v-48h12.1zm-6.2 130a5 5 0 1 1 0-2H176v-74.1a5 5 0 1 1 2 0V242h-60.1zm-16-64a5 5 0 1 1 0-2H114v48h10.1a5 5 0 1 1 0 2H112v-48h-10.1zM66 284.1a5 5 0 1 1-2 0V274H50v30h-2v-32h18v12.1zM236.1 176a5 5 0 1 1 0 2H226v94h48v32h-2v-30h-48v-98h12.1zm25.8-30a5 5 0 1 1 0-2H274v44.1a5 5 0 1 1-2 0V146h-10.1zm-64 96a5 5 0 1 1 0-2H208v-80h16v-14h-42.1a5 5 0 1 1 0-2H226v18h-16v80h-12.1zm86.2-210a5 5 0 1 1 0 2H272V0h2v32h10.1zM98 101.9V146H53.9a5 5 0 1 1 0-2H96v-42.1a5 5 0 1 1 2 0zM53.9 34a5 5 0 1 1 0-2H80V0h2v34H53.9zm60.1 3.9V66H82v64H69.9a5 5 0 1 1 0-2H80V64h32V37.9a5 5 0 1 1 2 0zM101.9 82a5 5 0 1 1 0-2H128V37.9a5 5 0 1 1 2 0V82h-28.1zm16-64a5 5 0 1 1 0-2H146v44.1a5 5 0 1 1-2 0V18h-26.1zm102.2 270a5 5 0 1 1 0 2H98v14h-2v-16h124.1zM242 149.9V160h16v34h-16v62h48v48h-2v-46h-48v-66h16v-30h-16v-12.1a5 5 0 1 1 2 0zM53.9 18a5 5 0 1 1 0-2H64V2H48V0h18v18H53.9zm112 32a5 5 0 1 1 0-2H192V0h50v2h-48v48h-28.1zm-48-48a5 5 0 0 1-9.8-2h2.07a3 3 0 1 0 5.66 0H178v34h-18V21.9a5 5 0 1 1 2 0V32h14V2h-58.1zm0 96a5 5 0 1 1 0-2H137l32-32h39V21.9a5 5 0 1 1 2 0V66h-40.17l-32 32H117.9zm28.1 90.1a5 5 0 1 1-2 0v-76.51L175.59 80H224V21.9a5 5 0 1 1 2 0V82h-49.59L146 112.41v75.69zm16 32a5 5 0 1 1-2 0v-99.51L184.59 96H300.1a5 5 0 0 1 3.9-3.9v2.07a3 3 0 0 0 0 5.66v2.07a5 5 0 0 1-3.9-3.9H185.41L162 121.41v98.69zm-144-64a5 5 0 1 1-2 0v-3.51l48-48V48h32V0h2v50H66v55.41l-48 48v2.69zM50 53.9v43.51l-48 48V208h26.1a5 5 0 1 1 0 2H0v-65.41l48-48V53.9a5 5 0 1 1 2 0zm-16 16V89.41l-34 34v-2.82l32-32V69.9a5 5 0 1 1 2 0zM12.1 32a5 5 0 1 1 0 2H9.41L0 43.41V40.6L8.59 32h3.51zm265.8 18a5 5 0 1 1 0-2h18.69l7.41-7.41v2.82L297.41 50H277.9zm-16 160a5 5 0 1 1 0-2H288v-71.41l16-16v2.82l-14 14V210h-28.1zm-208 32a5 5 0 1 1 0-2H64v-22.59L40.59 194H21.9a5 5 0 1 1 0-2H41.41L66 216.59V242H53.9zm150.2 14a5 5 0 1 1 0 2H96v-56.6L56.6 162H37.9a5 5 0 1 1 0-2h19.5L98 200.6V256h106.1zm-150.2 2a5 5 0 1 1 0-2H80v-46.59L48.59 178H21.9a5 5 0 1 1 0-2H49.41L82 208.59V258H53.9zM34 39.8v1.61L9.41 66H0v-2h8.59L32 40.59V0h2v39.8zM2 300.1a5 5 0 0 1 3.9 3.9H3.83A3 3 0 0 0 0 302.17V256h18v48h-2v-46H2v42.1zM34 241v63h-2v-62H0v-2h34v1zM17 18H0v-2h16V0h2v18h-1zm273-2h14v2h-16V0h2v16zm-32 273v15h-2v-14h-14v14h-2v-16h18v1zM0 92.1A5.02 5.02 0 0 1 6 97a5 5 0 0 1-6 4.9v-2.07a3 3 0 1 0 0-5.66V92.1zM80 272h2v32h-2v-32zm37.9 32h-2.07a3 3 0 0 0-5.66 0h-2.07a5 5 0 0 1 9.8 0zM5.9 0A5.02 5.02 0 0 1 0 5.9V3.83A3 3 0 0 0 3.83 0H5.9zm294.2 0h2.07A3 3 0 0 0 304 3.83V5.9a5 5 0 0 1-3.9-5.9zm3.9 300.1v2.07a3 3 0 0 0-1.83 1.83h-2.07a5 5 0 0 1 3.9-3.9zM97 100a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-48 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 48a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 96a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-144a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-96 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm96 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-32 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM49 36a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-32 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM33 68a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-48a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 240a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm80-176a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 48a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm112 176a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM17 180a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM17 84a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
            
        </svg>
    </div>

    <div class="min-h-screen flex items-center justify-center p-2 sm:p-3 md:p-4">
        <div class="w-full max-w-xs sm:max-w-sm md:max-w-md ">
            <!-- Toggle de modo oscuro -->
            <div class="flex justify-end mb-2 sm:mb-3">
                <button
                    id="themeToggle"
                    class="p-1.5 sm:p-2 rounded-md bg-white/80 dark:bg-gray-800/80 backdrop-blur border border-amber-200 dark:border-gray-600 hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 shadow-sm"
                    title="Cambiar tema"
                >
                    <!-- Icono de sol (modo claro) -->
                    <svg id="sunIcon" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-custom-gold-darker dark:text-custom-gold-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <!-- Icono de luna (modo oscuro) -->
                    <svg id="moonIcon" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-custom-gold-darker dark:text-custom-gold-medium hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>
            </div>

            <!-- Logo y título de la empresa -->
            <div class="text-center mb-4 sm:mb-5 md:mb-6">
                <div class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 bg-amber-800 dark:bg-amber-700 rounded-full mb-2 sm:mb-3 shadow-lg">
                    <!-- Icono de café/cacao usando SVG -->
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"></path>
                    </svg>
                </div>
                <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-custom-dark dark:text-amber-100 mb-1 transition-colors">Cacao San José</h1>
                <p class="text-xs sm:text-sm md:text-base text-amber-700 dark:text-custom-gold-light transition-colors">Gestion Forestal</p>
            </div>

         <div class="shadow-2xl hover:shadow-3xl dark:shadow-gray-900/50 bg-stone-100/90 dark:bg-custom-gray rounded-lg transition-all duration-300">
                <!-- Header del card -->
                <div class="px-3 sm:px-4 md:px-5 py-3 sm:py-4 pb-3 sm:pb-4">
                    <h2 class="text-base sm:text-lg md:text-xl lg:text-2xl text-center text-custom-dark dark:text-amber-100 font-semibold transition-colors">Iniciar Sesión</h2>
                </div>
           

                <!-- Contenido del card -->
                <div class="px-3 sm:px-4 md:px-5 pb-3 sm:pb-4 md:pb-5">
                    <form method="POST" class="space-y-2.5 sm:space-y-3 md:space-y-4" action="{{ route('login') }}">
                        @csrf
                        <!-- Campo de email -->
                        <div class="space-y-1 sm:space-y-1.5">
                            <label for="email" class="block text-custom-dark dark:text-amber-100 font-medium text-xs sm:text-sm transition-colors">
                                Correo Electrónico
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="usuario@empresa.com"
                                class="w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm border border-stone-400/80 dark:border-gray-600 !bg-stone-50 dark:!bg-gray-800/50 text-custom-gray dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-custom-gold-dark dark:focus:ring-custom-gold-medium/70 focus:border-custom-gold-dark dark:focus:border-custom-gold-medium/70 transition-all duration-200"
                                required
                            />
                            @error('email')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo de contraseña -->
                        <div class="space-y-1 sm:space-y-1.5">
                            <label for="password" class="block text-custom-dark dark:text-amber-100 font-medium text-xs sm:text-sm transition-colors">
                                Contraseña
                            </label>
                            <div class="relative">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="Contraseña"
                                    class="w-full px-2.5 sm:px-3 py-1.5 sm:py-2 pr-8 sm:pr-9 text-xs sm:text-sm border border-stone-400/80  dark:border-gray-600 bg-white dark:bg-gray-800/50 text-custom-gray dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-custom-gold-dark dark:focus:ring-custom-gold-medium/70 focus:border-custom-gold-dark dark:focus:border-custom-gold-medium/70 transition-all duration-200"
                                    required
                                />
                                @error('password')
                                    <span>{{ $message }}</span>
                                @enderror
                                <button
                                    type="button"
                                    title="Mostrar/Ocultar Contraseña"
                                    id="togglePassword"
                                    class="absolute right-2.5 sm:right-3 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors p-0.5"
                                >
                                    <!-- Icono de ojo cerrado (por defecto) -->
                                    <svg id="eyeOff" class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                    <!-- Icono de ojo abierto (oculto por defecto) -->
                                    <svg id="eyeOn"  class="w-5 h-5 sm:w-6 sm:h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Recordarme y olvidé contraseña -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-1.5 sm:space-y-0 pt-0.5">
                            <div class="flex items-center space-x-1.5">
                                <input
                                    name="remember"
                                    type="checkbox"
                                    class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-custom-gold-darker bg-gray-100 dark:bg-gray-600 border-custom-gold-light dark:border-gray-500 rounded focus:ring-custom-gold-dark dark:focus:ring-custom-gold-medium focus:ring-2 transition-colors"
                                />
                                <label for="remember" class="text-xs text-amber-700 dark:text-custom-gold-light transition-colors">
                                    Recordarme
                                </label>
                            </div>
                            <button type="button" class="text-xs text-custom-gold-darker dark:text-custom-gold-medium hover:text-amber-800 dark:hover:text-amber-200 hover:underline transition-colors text-left sm:text-right">
                                 
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs text-custom-gold-darker dark:text-custom-gold-medium hover:text-amber-800 dark:hover:text-amber-200 hover:underline transition-colors text-left sm:text-right">
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                @endif
        
                            </button>
                        </div>

                        <!-- Botón de submit -->
                        <button
                            type="submit"
                            title="Iniciar sección"
                            class="w-full bg-amber-800 dark:bg-amber-700 hover:bg-amber-950/90 dark:hover:bg-custom-gold-dark/50 text-white font-medium py-2 sm:py-2.5 px-3 text-xs sm:text-sm md:text-base rounded-md transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-custom-gold-dark dark:focus:ring-amber-700 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                        >
                            Iniciar Sesión
                        </button>
                    </form>

                    <!-- Separador y enlace de contacto -->
                    <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-amber-200 dark:border-gray-600 transition-colors">
                        <p class="text-center text-xs text-custom-gold-darker dark:text-custom-gold-medium transition-colors">
                            ¿Necesitas acceso?
                            <button class="text-amber-800 dark:text-custom-gold-light hover:text-custom-dark dark:hover:text-amber-100 font-medium hover:underline ml-1 transition-colors">
                                Contacta al administrador
                            </button>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 sm:mt-4 md:mt-5 text-xs text-custom-gold-darker dark:text-custom-gold-medium transition-colors px-2">
                <p>© 2024 Todos los derechos reservados.</p>
            </div>
        </div>
    </div>

    <script>
        // Gestión del tema (modo oscuro/claro)
        class ThemeManager {
            constructor() {
                this.theme = localStorage.getItem('theme') || 'light';
                this.init();
            }

            init() {
                this.applyTheme();
                this.setupToggle();
            }

            applyTheme() {
                const html = document.documentElement;
                const sunIcon = document.getElementById('sunIcon');
                const moonIcon = document.getElementById('moonIcon');

                if (this.theme === 'dark') {
                    html.classList.add('dark');
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                } else {
                    html.classList.remove('dark');
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                }
            }

            toggleTheme() {
                this.theme = this.theme === 'light' ? 'dark' : 'light';
                localStorage.setItem('theme', this.theme);
                this.applyTheme();
                
                // Añadir feedback visual al cambiar tema
                const button = document.getElementById('themeToggle');
                button.classList.add('scale-95');
                setTimeout(() => {
                    button.classList.remove('scale-95');
                }, 150);
            }

            setupToggle() {
                const toggleButton = document.getElementById('themeToggle');
                toggleButton.addEventListener('click', () => {
                    this.toggleTheme();
                });
            }
        }

        // Inicializar el gestor de temas cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            new ThemeManager();
        });

        // Funcionalidad para mostrar/ocultar contraseña
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeOff = document.getElementById('eyeOff');
            const eyeOn = document.getElementById('eyeOn');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOff.classList.add('hidden');
                eyeOn.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOff.classList.remove('hidden');
                eyeOn.classList.add('hidden');
            }
        });

        // Manejo del formulario de login
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const remember = document.getElementById('remember').checked;
            const currentTheme = localStorage.getItem('theme') || 'light';
            
            // Feedback visual del botón
            const submitButton = e.target.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            submitButton.textContent = 'Iniciando...';
            submitButton.disabled = true;
            
            // Simular proceso de login
            setTimeout(() => {
                submitButton.textContent = originalText;
                submitButton.disabled = false;
                
                // Aquí iría la lógica de autenticación
                console.log('Login attempt:', { 
                    email, 
                    password, 
                    remember, 
                    theme: currentTheme,
                    screenSize: window.innerWidth + 'x' + window.innerHeight
                });
                
                // Ejemplo de validación simple
                if (email && password) {
                    alert(`✅ Datos capturados correctamente\n📱 Pantalla: ${window.innerWidth}px\n🎨 Tema: ${currentTheme}`);
                } else {
                    alert('❌ Por favor, completa todos los campos.');
                }
            }, 1000);
        });

        // Efecto de focus mejorado para los inputs
        const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.add('ring-2');
                this.parentElement.classList.add('transform', 'scale-[1.01]');
            });
            
            input.addEventListener('blur', function() {
                this.classList.remove('ring-2');
                this.parentElement.classList.remove('transform', 'scale-[1.01]');
            });
        });

        // Detectar preferencia del sistema si no hay tema guardado
        if (!localStorage.getItem('theme')) {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (prefersDark) {
                localStorage.setItem('theme', 'dark');
            }
        }

        // Mejorar la experiencia táctil en dispositivos móviles
        if ('ontouchstart' in window) {
            document.body.classList.add('touch-device');
            
            // Añadir estilos específicos para dispositivos táctiles
            const style = document.createElement('style');
            style.textContent = `
                .touch-device button:active {
                    transform: scale(0.98);
                }
                .touch-device input:focus {
                    transform: scale(1.01);
                }
            `;
            document.head.appendChild(style);
        }
    </script>
</body>
</html>

