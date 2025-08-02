        <aside id="sidebar" class="sidebar sidebar-expanded">
            <!-- Sidebar Header -->
             <div class="sidebar-header relative" style="padding-top:0.5rem;padding-bottom:2rem;">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-blue rounded-lg flex items-center justify-center absolute left-0">
                    <i data-lucide="layout-dashboard" class="text-white"></i>
                </div>
                <span class="sidebar-text font-bold text-gray-900 text-base md:text-lg whitespace-nowrap pl-11 md:pl-12">
                    Cacao San José
                </span>
            </div>
            
            <!-- Navigation -->
            <nav style="flex:1;">
                <div style="margin-bottom:2rem;">
                    <h3 class="sidebar-text text-xs font-semibold text-gray-500 uppercase tracking-wider" style="margin-bottom:1rem;">Aplicación</h3>
                    <ul style="list-style:none;padding:0;margin:0;">
                        <li>
                            <a href="http://127.0.0.1:8000/dashboard" class="nav-item active" >
                                <i data-lucide="home"></i>
                                <span class="sidebar-text">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-item">
                                <i data-lucide="bar-chart-3"></i>
                                <span class="sidebar-text">Analytics</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-item">
                                <i data-lucide="users"></i>
                                <span class="sidebar-text">Usuarios</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-item">
                                <i data-lucide="file-text"></i>
                                <span class="sidebar-text">Reportes</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-item">
                                <i data-lucide="calendar"></i>
                                <span class="sidebar-text">Calendario</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-item">
                                <i data-lucide="inbox"></i>
                                <span class="sidebar-text">Mensajes</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Sidebar Footer -->
            <div class="sidebar-header" style="padding-bottom:2rem;">
                <a href="#" class="nav-item">
                    <i data-lucide="settings"></i>
                    <span class="sidebar-text">Configuración</span>
                </a>
            </div>
        </aside>


            <header class="bg-white px-4 md:px-6 lg:px-8 py-1 md:py-1 rounded-b-xl shadow-soft">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3 md:space-x-6">
                        <button id="sidebarToggle" class="p-2 md:p-3 rounded-lg hover:bg-gray-200 hover-lift">
                            <i data-lucide="menu" class="w-4 h-4 md:w-5 md:h-5"></i>
                        </button>
                        <nav class="hidden sm:flex items-center space-x-2 md:space-x-3 text-sm">
                            <a href="#" class="text-gray-500 hover:text-gray-700 px-2 md:px-3 py-1 md:py-2 rounded-lg hover:bg-gray-200">Dashboard</a>
                            <i data-lucide="chevron-right" class="w-3 h-3 md:w-4 md:h-4 text-gray-400"></i>
                            <span class="text-gray-900 px-2 md:px-3 py-1 md:py-2 bg-stone-200 rounded-lg font-medium">Resumen</span>
                        </nav>
                    </div>
                    <div class="flex items-center space-x-2 md:space-x-4">
                        
                        <button class="p-1 md:p-1 rounded-lg hover:bg-gray-200 relative hover-lift">
                            <i data-lucide="bell" class="w-4 h-4 md:w-5 md:h-5"></i>
                            <span class="absolute -top-1 -right-1 w-3 h-3 md:w-4 md:h-4 bg-red-500 rounded-full flex items-center justify-center">
                                <span class="w-1.5 h-1.5 md:w-2 md:h-2 bg-white rounded-full"></span>
                            </span>
                        </button>
                        <!-- Desktop dark mode toggle -->
                        <div class="hidden sm:flex items-center space-x-2 md:space-x-3 bg-gray-50 rounded-lg px-3 md:px-4 py-2">
                            <i data-lucide="sun" class="w-3 h-3 md:w-4 md:h-4 text-gray-500 dark:text-gray-400"></i>
                            <label class="toggle-switch">
                                <input type="checkbox" id="darkModeToggle">
                                <span class="toggle-slider"></span>
                            </label>
                            <i data-lucide="moon" class="w-3 h-3 md:w-4 md:h-4 text-gray-500 dark:text-gray-400"></i>
                        </div>
                        <div class="relative">
                            <button id="userMenuToggle" class="flex items-center space-x-2 md:space-x-3 p-1 md:p-2 rounded-lg hover:bg-gray-200 hover-lift">
                                <img src="/placeholder.svg?height=32&width=32" alt="Usuario" class="w-8 h-8 md:w-10 md:h-10 rounded-lg">
                                <div class="hidden lg:block text-left">
                                    <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">Administrador</p>
                                </div>
                                <i data-lucide="chevron-down" class="hidden md:block w-3 h-3 md:w-4 md:h-4 text-gray-400"></i>
                            </button>
                            <div id="userMenu" class="dropdown-menu absolute right-0 mt-2 w-48 md:w-64 bg-white rounded-xl shadow-soft py-2 z-50">
                                <div class="px-4 md:px-6 py-3 md:py-4">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="border-t border-gray-100 my-2"></div>
                                <a href="#" class="block px-4 md:px-6 py-2 md:py-3 text-sm text-gray-700 hover:bg-gray-200 rounded-lg mx-2">Perfil</a>
                                <a href="#" class="block px-4 md:px-6 py-2 md:py-3 text-sm text-gray-700 hover:bg-gray-200 rounded-lg mx-2">Configuración</a>
                                <a href="#" class="block px-4 md:px-6 py-2 md:py-3 text-sm text-gray-700 hover:bg-gray-200 rounded-lg mx-2">Soporte</a>
                                <div class="border-t border-gray-100 my-2"></div>
                                <a href="#" class="block px-4 md:px-6 py-2 md:py-3 text-sm text-red-600 hover:bg-red-100 rounded-lg mx-2">Cerrar Sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>


<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- Este enlace solo se mostrará para los administradores --}}
                    @if (auth()->check() && auth()->user()->role === 'administrador')
                    
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                            {{ __('Usuarios') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.audit')" :active="request()->routeIs('admin.audit')">
                            {{ __('Auditoría') }}
                        </x-nav-link>

                    @endif

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>



