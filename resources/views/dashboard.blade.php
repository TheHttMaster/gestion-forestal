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
