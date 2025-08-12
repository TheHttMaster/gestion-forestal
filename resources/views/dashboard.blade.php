<x-app-layout>
   
    @if (auth()->check() && auth()->user()->role === 'administrador')
    <!-- Stats Cards -->
     
        <div class="stats-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8 mb-6 md:mb-8">
        
            <div class="bg-stone-100/90 dark:bg-custom-gray  rounded-2xl shadow-soft p-4 md:p-6 lg:p-8 hover-lift">
                <div class="flex items-center justify-between mb-4 md:mb-6">
                    <h3 class="text-xs md:text-sm font-medium text-gray-500">Usuarios Activos</h3>
                    <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-gradient-blue rounded-lg flex items-center justify-center">
                        <i data-lucide="users" class="w-4 h-4 md:w-5 lg:w-6 md:h-5 lg:h-6 text-white"></i>
                    </div>
                </div>
                <div class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-gray-200 mb-2 md:mb-3">{{ $userCount }}</div>
                <div class="flex items-center text-xs md:text-sm">
                    <div class="flex items-center bg-blue-100 text-blue-700 px-2 md:px-3 py-1 rounded-full">
                        <i data-lucide="arrow-up" class="w-2 h-2 md:w-3 md:h-3 mr-1"></i>
                        <span class="font-medium">+1.%</span>
                    </div>
                    <span class="text-gray-500 ml-2">del mes pasado</span>
                </div>
            </div>

            <div class="bg-stone-100/90 dark:bg-custom-gray  rounded-2xl shadow-soft p-4 md:p-6 lg:p-8 hover-lift">
                <div class="flex items-center justify-between mb-4 md:mb-6">
                    <h3 class="text-xs md:text-sm font-medium text-gray-500">Actividades realizadas</h3>
                    <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-gradient-orange rounded-lg flex items-center justify-center">
                        <i data-lucide="activity" class="w-4 h-4 md:w-5 lg:w-6 md:h-5 lg:h-6 text-white"></i>
                    </div>
                </div>
                <div class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-gray-200  mb-2 md:mb-3">{{ $activityCount }}</div>
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
        <div class="bg-stone-100/90 dark:bg-custom-gray rounded-2xl shadow-soft p-4 md:p-6 lg:p-8 hover-lift">
            <div class="mb-4 md:mb-6 lg:mb-8">
                <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-gray-200 mb-1 md:mb-2">Actividad Reciente</h3>
                <p class="text-xs md:text-sm text-gray-500 ">Últimas acciones de tu equipo</p>
            </div>
            
            <div class="overflow-x-auto">
                <table id="auditoria-table" class="w-full">
                    <thead>
                        <tr class="text-left border-b border-gray-200">
                            <th class="pb-2 text-xs md:text-sm font-semibold text-gray-900 dark:text-gray-300 ">Usuario</th>
                            <th class="pb-2 text-xs md:text-sm font-semibold text-gray-900 dark:text-gray-300 ">Acción</th>
                            <th class="pb-2 text-xs md:text-sm font-semibold text-gray-900 dark:text-gray-300 text-right">Tiempo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($activities as $activity)
                            <tr class="hover:bg-gray-200 dark:bg-custom-gray dark:hover:bg-gray-700 ">
                                <td class="py-3">
                                    <div class="flex items-center space-x-3 md:space-x-4">
                                        {{-- <img src="resources\img\01db27489ea9a74e7cfdcfb4220832ae.jpg" alt="{{ $activity->causer->name }}" class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 rounded-lg"> --}}
                                        <span class="text-xs md:text-sm font-semibold text-gray-900 dark:text-gray-400 ">{{ $activity->causer ? $activity->causer->name : 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="py-3 text-xs md:text-sm text-gray-500">{{ $activity->description }}</td>
                                <td class="py-3 text-xs text-gray-500 text-left">{{ $activity->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <h2 class="!text-3xl !font-extrabold !text-black dark:text-white !mb-4">
                Bienvenido Usuario {{ Auth::user()->name }}
            </h2>
            @endif

        </div>
</x-app-layout>


  <!-- Main Content Area -->
           
        <script>
            $(document).ready(function() {
                $('#auditoria-table').DataTable({
                    // Opciones de configuración
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                    }
                });
            });
        </script>
    