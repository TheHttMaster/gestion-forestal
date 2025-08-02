<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard del Administrador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Resumen del Sistema</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-100 p-4 rounded-lg shadow">
                            <p class="text-gray-600">Total de Usuarios Registrados</p>
                            <p class="text-4xl font-bold">{{ $totalUsers }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow">
                            <p class="text-gray-600">Total de Acciones Registradas</p>
                            <p class="text-4xl font-bold">{{ $totalActions }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


  <!-- Main Content Area -->
           
                <!-- Stats Cards -->

                    <div class="bg-white rounded-xl shadow-soft p-4 md:p-6 lg:p-8 hover-lift">
                        <div class="flex items-center justify-between mb-4 md:mb-6">
                            <h3 class="text-xs md:text-sm font-medium text-gray-500">Usuarios Activos</h3>
                            <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-gradient-blue rounded-lg flex items-center justify-center">
                                <i data-lucide="users" class="w-4 h-4 md:w-5 lg:w-6 md:h-5 lg:h-6 text-white"></i>
                            </div>
                        </div>
                        <div class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 mb-2 md:mb-3">{{ $totalUsers }}</div>
                        <div class="flex items-center text-xs md:text-sm">
                            <div class="flex items-center bg-blue-100 text-blue-700 px-2 md:px-3 py-1 rounded-full">
                                <i data-lucide="arrow-up" class="w-2 h-2 md:w-3 md:h-3 mr-1"></i>
                                <span class="font-medium">+180.1%</span>
                            </div>
                            <span class="text-gray-500 ml-2">del mes pasado</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-soft p-4 md:p-6 lg:p-8 hover-lift">
                        <div class="flex items-center justify-between mb-4 md:mb-6">
                            <h3 class="text-xs md:text-sm font-medium text-gray-500">Aciones Realizadas</h3>
                            <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-gradient-purple rounded-lg flex items-center justify-center">
                                <i data-lucide="credit-card" class="w-4 h-4 md:w-5 lg:w-6 md:h-5 lg:h-6 text-white"></i>
                            </div>
                        </div>
                        <div class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 mb-2 md:mb-3">{{ $totalActions }}</div>
                        <div class="flex items-center text-xs md:text-sm">
                            <div class="flex items-center bg-purple-100 text-purple-700 px-2 md:px-3 py-1 rounded-full">
                                <i data-lucide="arrow-up" class="w-2 h-2 md:w-3 md:h-3 mr-1"></i>
                                <span class="font-medium">+19%</span>
                            </div>
                            <span class="text-gray-500 ml-2">del mes pasado</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-soft p-4 md:p-6 lg:p-8 hover-lift">
                        <div class="flex items-center justify-between mb-4 md:mb-6">
                            <h3 class="text-xs md:text-sm font-medium text-gray-500">Activos Ahora</h3>
                            <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-gradient-orange rounded-lg flex items-center justify-center">
                                <i data-lucide="activity" class="w-4 h-4 md:w-5 lg:w-6 md:h-5 lg:h-6 text-white"></i>
                            </div>
                        </div>
                        <div class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 mb-2 md:mb-3">573</div>
                        <div class="flex items-center text-xs md:text-sm">
                            <div class="flex items-center bg-red-100 text-red-700 px-2 md:px-3 py-1 rounded-full">
                                <i data-lucide="arrow-down" class="w-2 h-2 md:w-3 md:h-3 mr-1"></i>
                                <span class="font-medium">-2%</span>
                            </div>
                            <span class="text-gray-500 ml-2">de la última hora</span>
                        </div>
                    </div>
                </div>