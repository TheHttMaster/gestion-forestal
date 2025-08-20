        <aside id="sidebar" class="sidebar sidebar-expanded bg-stone-100/90 dark:bg-custom-gray ">
            <!-- Sidebar Header -->
             <div class="sidebar-header relative" style="padding-top:0.5rem;padding-bottom:2rem;">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-blue rounded-lg flex items-center justify-center absolute left-0">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard text-white">
                        <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>
                    </svg>
                </div>
                <span class="sidebar-text font-bold text-gray-900 dark:text-gray-200 text-base md:text-lg whitespace-nowrap pl-11 md:pl-12">
                    Cacao San José
                </span>
            </div>
            
            <!-- Navigation -->
            <nav style="flex:1;">
                <div style="margin-bottom:2rem;">
                    <h3 class="sidebar-text text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider" style="margin-bottom:1rem;">Aplicación</h3>
                    <ul style="list-style:none;padding:0;margin:0;">
                        <li>
                            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house-icon lucide-house">
                                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                </svg>
                                <span class="sidebar-text">Inicio</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-bar-icon lucide-chart-bar">
                                    <path d="M3 3v16a2 2 0 0 0 2 2h16"/><path d="M7 16h8"/><path d="M7 11h12"/><path d="M7 6h3"/>
                                </svg>
                                <span class="sidebar-text">Analisis.X</span>
                            </a>
                        </li>

                        {{-- Este enlace solo se mostrará para los administradores --}}
                        @if (auth()->check() && auth()->user()->role === 'administrador')
                   
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/>
                                </svg>
                                <span class="sidebar-text">Usuarios</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.audit') }}" class="nav-item {{ request()->routeIs('admin.audit') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>
                                </svg>
                                <span class="sidebar-text">Historial</span>
                            </a>
                        </li>
                        @endif
                       
                    </ul>
                </div>
            </nav>
            <!-- Sidebar Footer -->
            <div class="sidebar-header" style="padding-bottom:2rem;">
                <a href="#" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings">
                        <path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                    <span class="sidebar-text">Configuración.X</span>
                </a>
            </div>
        </aside>
    <div class="flex-1 flex flex-col overflow-hidden">
        @php
            $routeNames = [
                'dashboard' => 'Inicio',
                'admin.users.*' => 'Usuarios',
                'profile.*' => 'Pefil de Usuario',
                'admin.audit' => 'Historial', // Aplica a cualquier ruta que empiece con "posts."
            ];
            
            $currentRouteName = 'Página Principal'; // Valor por defecto
            
            foreach ($routeNames as $route => $name) {
                if (request()->routeIs($route)) {
                    $currentRouteName = $name;
                    break;
                }
            }
        @endphp



        <header class="headi bg-stone-100/90 dark:bg-custom-gray px-4 md:px-6 lg:px-8 py-1 md:py-1  shadow-soft">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 md:space-x-6">
                    <button id="sidebarToggle" class="p-2 md:p-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700/70 hover-lift">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu-icon lucide-menu w-4 h-4 md:w-5 md:h-5">
                            <path d="M4 12h16"/><path d="M4 18h16"/><path d="M4 6h16"/>
                        </svg>
                    </button>
                    <nav class="hidden sm:flex items-center space-x-2 md:space-x-3 text-sm">
                        <a href="#" class="text-gray-800 dark:text-custom-gold-medium hover:text-gray-950  px-2 md:px-3 py-1 md:py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-700/50">{{ $currentRouteName }}</a>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon w-3 h-3 md:w-4 md:h-4 text-gray-400 lucide-chevron-right">
                            <path d="m9 18 6-6-6-6"/>
                        </svg>
                        <span class="text-gray-900 px-2 md:px-3 py-1 md:py-2 bg-stone-200 dark:bg-stone-400 rounded-lg font-medium">Resumen</span>
                    </nav>
                </div>
                <div class="flex items-center space-x-2 md:space-x-4">
                    
                   
                    <!-- Desktop dark mode toggle -->
                    <div class="hidden sm:flex items-center space-x-2 md:space-x-3 bg-gray-200 dark:text-custom-gold-medium rounded-lg px-3 md:px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun-icon lucide-sun w-3 h-3 md:w-4 md:h-4 text-gray-600 dark:text-custom-gold-medium">
                            <circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
                        </svg>
                        <label class="toggle-switch">
                            <input type="checkbox" id="darkModeToggle">
                            <span class="toggle-slider"></span>
                        </label>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon-icon lucide-moon w-3 h-3 md:w-4 md:h-4 text-gray-600 dark:text-custom-gold-medium">
                            <path d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.46.402.803a6 6 0 0 0 8.268 8.268c.344-.215.825-.004.803.401"/>
                        </svg>
                    </div>
                    <div class="relative">
                        <button id="userMenuToggle" class="flex items-center space-x-2 md:space-x-3 p-1 md:p-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-700/50 hover-lift">
                            <img 
                                src="{{ Vite::asset('resources/img/01db27489ea9a74e7cfdcfb4220832ae.jpg') }}" 
                                alt="Foto de perfil"
                                class="w-10 h-10 rounded-full"
                            >
                            <div class="hidden lg:block text-left">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-custom-gold-medium">{{ Auth::user()->role }}</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down-icon hidden md:block w-3 h-3 md:w-4 md:h-4 text-gray-400 lucide-chevron-down">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>
                        <div id="userMenu" class="dropdown-menu absolute right-0 mt-2 w-48 md:w-64 bg-stone-100 dark:bg-custom-gray rounded-xl shadow-soft py-2 z-50">
                            <div class="px-4 md:px-6 py-3 md:py-4">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="border-t border-gray-400/70 dark:border-gray-700 my-2"></div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 md:px-6 py-2 md:py-3 text-sm text-gray-700 dark:text-gray-400 hover:bg-gray-200 rounded-lg mx-2">Perfil</a>
                            <a href="#" class="block px-4 md:px-6 py-2 md:py-3 text-sm text-gray-700 dark:text-gray-400 hover:bg-gray-200 rounded-lg mx-2">Configuración</a>
                            <a href="#" class="block px-4 md:px-6 py-2 md:py-3 text-sm text-gray-700 dark:text-gray-400 hover:bg-gray-200 rounded-lg mx-2">Soporte</a>
                            <div class="border-t border-gray-400/70 dark:border-gray-700 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}" class="mx-2">
                                @csrf
                                <a href="{{ route('logout') }}" 
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="block px-4 md:px-6 py-2 md:py-3 text-sm text-red-600 hover:bg-red-100 rounded-lg">
                                    {{ __('Cerrar Sección') }}
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>






