<x-app-layout>
   <!-- Stats Cards -->

         <!-- Stats Cards -->
                <div class="stats-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 lg:gap-8 mb-6 md:mb-8">
                    <div class="bg-white rounded-xl shadow-soft p-4 md:p-6 lg:p-8 hover-lift">
                        <div class="flex items-center justify-between mb-4 md:mb-6">
                            <h3 class="text-xs md:text-sm font-medium text-gray-500">Ingresos Totales</h3>
                            <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-gradient-green rounded-lg flex items-center justify-center">
                                <i data-lucide="dollar-sign" class="w-4 h-4 md:w-5 lg:w-6 md:h-5 lg:h-6 text-white"></i>
                            </div>
                        </div>
                        <div class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 mb-2 md:mb-3">$45,231.89</div>
                        <div class="flex items-center text-xs md:text-sm">
                            <div class="flex items-center bg-green-100 text-green-700 px-2 md:px-3 py-1 rounded-full">
                                <i data-lucide="arrow-up" class="w-2 h-2 md:w-3 md:h-3 mr-1"></i>
                                <span class="font-medium">+20.1%</span>
                            </div>
                            <span class="text-gray-500 ml-2">del mes pasado</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-soft p-4 md:p-6 lg:p-8 hover-lift">
                        <div class="flex items-center justify-between mb-4 md:mb-6">
                            <h3 class="text-xs md:text-sm font-medium text-gray-500">Usuarios Activos</h3>
                            <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-gradient-blue rounded-lg flex items-center justify-center">
                                <i data-lucide="users" class="w-4 h-4 md:w-5 lg:w-6 md:h-5 lg:h-6 text-white"></i>
                            </div>
                        </div>
                        <div class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 mb-2 md:mb-3">2,350</div>
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
                            <h3 class="text-xs md:text-sm font-medium text-gray-500">Ventas</h3>
                            <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-gradient-purple rounded-lg flex items-center justify-center">
                                <i data-lucide="credit-card" class="w-4 h-4 md:w-5 lg:w-6 md:h-5 lg:h-6 text-white"></i>
                            </div>
                        </div>
                        <div class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 mb-2 md:mb-3">12,234</div>
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

                <!-- Charts and Activity -->
                <div class="main-grid grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8">
                    <!-- Charts Section -->
                    <div class="lg:col-span-2 space-y-4 md:space-y-6 lg:space-y-8">
                        <!-- Revenue Chart -->
                        <div class="bg-white rounded-xl shadow-soft p-4 md:p-6 lg:p-8 hover-lift">
                            <div class="mb-4 md:mb-6 lg:mb-8">
                                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-1 md:mb-2">Resumen de Ingresos</h3>
                                <p class="text-xs md:text-sm text-gray-500">Ingresos mensuales de los últimos 6 meses</p>
                            </div>
                            <div class="h-48 md:h-56 lg:h-64 bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-12 h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 bg-gradient-blue rounded-xl flex items-center justify-center mx-auto mb-3 md:mb-4">
                                        <i data-lucide="bar-chart-3" class="w-6 h-6 md:w-7 md:h-7 lg:w-8 lg:h-8 text-white"></i>
                                    </div>
                                    <div class="text-base md:text-lg font-semibold text-gray-600">Gráfico de Ingresos</div>
                                    <p class="text-xs md:text-sm text-gray-500">Visualización de datos de ingresos</p>
                                </div>
                            </div>
                        </div>

                        <!-- Goals Progress -->
                        <div class="bg-white rounded-xl shadow-soft p-4 md:p-6 lg:p-8 hover-lift">
                            <div class="mb-4 md:mb-6 lg:mb-8">
                                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-1 md:mb-2">Progreso de Objetivos</h3>
                                <p class="text-xs md:text-sm text-gray-500">Progreso actual hacia los objetivos mensuales</p>
                            </div>
                            <div class="space-y-4 md:space-y-6 lg:space-y-8">
                                <div>
                                    <div class="flex items-center justify-between mb-2 md:mb-3">
                                        <span class="text-xs md:text-sm font-semibold text-gray-700">Objetivo de Ingresos</span>
                                        <span class="text-xs md:text-sm text-gray-500 bg-gray-100 px-2 md:px-3 py-1 rounded-full">$32,000 / $50,000</span>
                                    </div>
                                    <div class="progress-bar w-full bg-gray-200 h-2 md:h-3">
                                        <div class="progress-fill bg-gradient-blue h-2 md:h-3" style="width: 64%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-2 md:mb-3">
                                        <span class="text-xs md:text-sm font-semibold text-gray-700">Adquisición de Usuarios</span>
                                        <span class="text-xs md:text-sm text-gray-500 bg-gray-100 px-2 md:px-3 py-1 rounded-full">1,847 / 2,500</span>
                                    </div>
                                    <div class="progress-bar w-full bg-gray-200 h-2 md:h-3">
                                        <div class="progress-fill bg-gradient-green h-2 md:h-3" style="width: 74%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-2 md:mb-3">
                                        <span class="text-xs md:text-sm font-semibold text-gray-700">Satisfacción del Cliente</span>
                                        <span class="text-xs md:text-sm text-gray-500 bg-gray-100 px-2 md:px-3 py-1 rounded-full">4.2 / 5.0</span>
                                    </div>
                                    <div class="progress-bar w-full bg-gray-200 h-2 md:h-3">
                                        <div class="progress-fill bg-gradient-orange h-2 md:h-3" style="width: 84%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-xl shadow-soft p-4 md:p-6 lg:p-8 hover-lift">
                        <div class="mb-4 md:mb-6 lg:mb-8">
                            <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-1 md:mb-2">Actividad Reciente</h3>
                            <p class="text-xs md:text-sm text-gray-500">Últimas acciones de tu equipo</p>
                        </div>
                        <div class="space-y-3 md:space-y-4 lg:space-y-6">
                            <div class="flex items-center space-x-3 md:space-x-4">
                                <img src="/placeholder.svg?height=40&width=40" alt="Alice" class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 rounded-lg">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs md:text-sm font-semibold text-gray-900">Alice Johnson</p>
                                    <p class="text-xs md:text-sm text-gray-500">Creó nuevo proyecto</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2 md:px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Éxito</span>
                                    <p class="text-xs text-gray-500 mt-1">hace 2 min</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 md:space-x-4">
                                <img src="/placeholder.svg?height=40&width=40" alt="Bob" class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 rounded-lg">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs md:text-sm font-semibold text-gray-900">Bob Smith</p>
                                    <p class="text-xs md:text-sm text-gray-500">Actualizó perfil de usuario</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2 md:px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Info</span>
                                    <p class="text-xs text-gray-500 mt-1">hace 5 min</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 md:space-x-4">
                                <img src="/placeholder.svg?height=40&width=40" alt="Carol" class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 rounded-lg">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs md:text-sm font-semibold text-gray-900">Carol Davis</p>
                                    <p class="text-xs md:text-sm text-gray-500">Eliminó archivos antiguos</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2 md:px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Aviso</span>
                                    <p class="text-xs text-gray-500 mt-1">hace 10 min</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 md:space-x-4">
                                <img src="/placeholder.svg?height=40&width=40" alt="David" class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 rounded-lg">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs md:text-sm font-semibold text-gray-900">David Wilson</p>
                                    <p class="text-xs md:text-sm text-gray-500">Completó revisión de tarea</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2 md:px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Éxito</span>
                                    <p class="text-xs text-gray-500 mt-1">hace 15 min</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 md:space-x-4">
                                <img src="/placeholder.svg?height=40&width=40" alt="Eva" class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 rounded-lg">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs md:text-sm font-semibold text-gray-900">Eva Brown</p>
                                    <p class="text-xs md:text-sm text-gray-500">Falló respaldo del sistema</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2 md:px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Error</span>
                                    <p class="text-xs text-gray-500 mt-1">hace 20 min</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</x-app-layout>


  <!-- Main Content Area -->
           
    