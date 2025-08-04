<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
   <script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    amber: {
                        50: '#e7e5dbff',
                        100: '#fef3c7',
                        200: '#fde68a',
                        300: '#e2ad39ff',
                        400: '#cf7f17ff',
                        500: '#ce7829ff',
                        600: '#7e4a0eff',
                        700: '#503017ff',
                        800: '#7c4728ff',
                        900: '#07090cff'
                    },
                    gray: {  // Añade esta sección
                        900: '#0d0f16ff'  // Mismo color que amber-900
                    }
                }
            }
        }
    }
</script>
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 dark:from-amber-900 dark:via-amber-900 dark:to-amber-900 transition-colors duration-300">
    <div class="min-h-screen flex items-center justify-center p-2 sm:p-3 md:p-4">
        <div class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg">
            <!-- Toggle de modo oscuro -->
            <div class="flex justify-end mb-2 sm:mb-3">
                <button
                    id="themeToggle"
                    class="p-1.5 sm:p-2 rounded-md bg-white/80 dark:bg-gray-800/80 backdrop-blur border border-amber-200 dark:border-gray-600 hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 shadow-sm"
                    title="Cambiar tema"
                >
                    <!-- Icono de sol (modo claro) -->
                    <svg id="sunIcon" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <!-- Icono de luna (modo oscuro) -->
                    <svg id="moonIcon" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-amber-600 dark:text-amber-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-amber-900 dark:text-amber-100 mb-1 transition-colors">Cacao San José</h1>
                <p class="text-xs sm:text-sm md:text-base text-amber-700 dark:text-amber-300 transition-colors">Gestion Forestal</p>
            </div>

            <!-- Card de login -->
            <div class="shadow-lg border-0 bg-white/95 dark:bg-gray-900 rounded-lg transition-colors duration-300">
                <!-- Header del card -->
                <div class="px-3 sm:px-4 md:px-5 py-3 sm:py-4 pb-3 sm:pb-4">
                    <h2 class="text-base sm:text-lg md:text-xl lg:text-2xl text-center text-amber-900 dark:text-amber-100 font-semibold transition-colors">Iniciar Sesión</h2>
                    <p class="text-center text-amber-700 dark:text-amber-300 mt-1 text-xs sm:text-sm transition-colors">Accede a tu cuenta</p>
                </div>

                <!-- Contenido del card -->
                <div class="px-3 sm:px-4 md:px-5 pb-3 sm:pb-4 md:pb-5">
                    <form method="POST" class="space-y-2.5 sm:space-y-3 md:space-y-4" action="{{ route('login') }}">
                        @csrf
                        <!-- Campo de email -->
                        <div class="space-y-1 sm:space-y-1.5">
                            <label for="email" class="block text-amber-900 dark:text-amber-100 font-medium text-xs sm:text-sm transition-colors">
                                Correo Electrónico
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="usuario@empresa.com"
                                class="w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm border border-amber-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 dark:focus:ring-amber-400 focus:border-amber-500 dark:focus:border-amber-400 transition-all duration-200"
                                required
                            />
                            @error('email')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo de contraseña -->
                        <div class="space-y-1 sm:space-y-1.5">
                            <label for="password" class="block text-amber-900 dark:text-amber-100 font-medium text-xs sm:text-sm transition-colors">
                                Contraseña
                            </label>
                            <div class="relative">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="Contraseña"
                                    class="w-full px-2.5 sm:px-3 py-1.5 sm:py-2 pr-8 sm:pr-9 text-xs sm:text-sm border border-amber-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 dark:focus:ring-amber-400 focus:border-amber-500 dark:focus:border-amber-400 transition-all duration-200"
                                    required
                                />
                                @error('password')
                                    <span>{{ $message }}</span>
                                @enderror
                                <button
                                    type="button"
                                    id="togglePassword"
                                    class="absolute right-2.5 sm:right-3 top-1/2 transform -translate-y-1/2 text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-200 transition-colors p-0.5"
                                >
                                    <!-- Icono de ojo cerrado (por defecto) -->
                                    <svg id="eyeOff" class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                    <!-- Icono de ojo abierto (oculto por defecto) -->
                                    <svg id="eyeOn" class="w-3.5 h-3.5 sm:w-4 sm:h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-amber-600 bg-gray-100 dark:bg-gray-600 border-amber-300 dark:border-gray-500 rounded focus:ring-amber-500 dark:focus:ring-amber-400 focus:ring-2 transition-colors"
                                />
                                <label for="remember" class="text-xs text-amber-700 dark:text-amber-300 transition-colors">
                                    Recordarme
                                </label>
                            </div>
                            <button type="button" class="text-xs text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-200 hover:underline transition-colors text-left sm:text-right">
                                 
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-200 hover:underline transition-colors text-left sm:text-right">
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                @endif
        
                            </button>
                        </div>

                        <!-- Botón de submit -->
                        <button
                            type="submit"
                            class="w-full bg-amber-800 dark:bg-amber-700 hover:bg-amber-900 dark:hover:bg-amber-600 text-white font-medium py-2 sm:py-2.5 px-3 text-xs sm:text-sm md:text-base rounded-md transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                        >
                            Iniciar Sesión
                        </button>
                    </form>

                    <!-- Separador y enlace de contacto -->
                    <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-amber-200 dark:border-gray-600 transition-colors">
                        <p class="text-center text-xs text-amber-600 dark:text-amber-400 transition-colors">
                            ¿Necesitas acceso?
                            <button class="text-amber-800 dark:text-amber-300 hover:text-amber-900 dark:hover:text-amber-100 font-medium hover:underline ml-1 transition-colors">
                                Contacta al administrador
                            </button>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-3 sm:mt-4 md:mt-5 text-xs text-amber-600 dark:text-amber-400 transition-colors px-2">
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

