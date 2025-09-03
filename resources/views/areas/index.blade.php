<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto">
            <div class="bg-stone-100/90 dark:bg-custom-gray overflow-hidden shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-8">
                <div class="text-gray-900 dark:text-gray-100">
                    <h2 class="font-semibold text-xl leading-tight">
                        {{ __('Lista de Áreas de Cultivo') }}
                    </h2>
                    
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('areas.create') }}" class="px-4 py-2 bg-lime-600/90 text-white rounded-md hover:bg-lime-600 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-circle w-5 h-5">
                                <circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/>
                            </svg>
                            <span>{{ __('Nueva Área') }}</span>
                        </a>
                    </div>

                    <div class="bg-stone-100/90 dark:bg-custom-gray rounded-lg p-4 mb-6 shadow-sm">
                        <h3 class="font-medium text-lg mb-4">{{ __('Filtros') }}</h3>
                        <form method="GET" action="{{ route('areas.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div class="col-span-1">
                                <label for="search" class="sr-only">Buscar</label>
                                <input type="text" name="search" id="search" placeholder="Buscar..." value="{{ request('search') }}"
                                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            </div>
                            <div class="col-span-1">
                                <label for="tipo" class="sr-only">Tipo</label>
                                <select name="tipo" id="tipo" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    <option value="">Todos los tipos</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>
                                            {{ ucfirst($tipo) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-1">
                                <label for="activo" class="sr-only">Estado</label>
                                <select name="activo" id="activo" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    <option value="">Todos</option>
                                    <option value="1" {{ request('activo') == '1' ? 'selected' : '' }}>Activas</option>
                                    <option value="0" {{ request('activo') == '0' ? 'selected' : '' }}>Inactivas</option>
                                </select>
                            </div>
                            <div class="col-span-1 flex items-end">
                                <button type="submit" class="w-full px-4 py-2 bg-blue-600/90 text-white rounded-md hover:bg-blue-600 flex items-center justify-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-filter w-5 h-5">
                                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                                    </svg>
                                    <span>{{ __('Filtrar') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto bg-stone-100/90 dark:bg-custom-gray rounded-lg shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-stone-100/90 dark:bg-custom-gray">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Código</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Área Padre</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-custom-gray divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($areas as $area)
                                <tr id="area-row-{{ $area->id }}"
                                    x-data="{
                                        loading: false,
                                        async toggleStatus() {
                                            this.loading = true;
                                            try {
                                                const response = await fetch('{{ route('areas.toggle-status', $area) }}', {
                                                    method: 'GET',
                                                    headers: {
                                                        'X-Requested-With': 'XMLHttpRequest',
                                                        'Accept': 'application/json'
                                                    }
                                                });
                                                const data = await response.json();
                                                if (data.success) {
                                                    showCustomAlert('success', '¡Éxito!', 'Estado del área actualizado.');
                                                    window.location.reload();
                                                } else {
                                                    showCustomAlert('error', 'Error', 'Ocurrió un error al cambiar el estado.');
                                                }
                                            } catch (error) {
                                                console.error('Error:', error);
                                                showCustomAlert('error', 'Error', 'Ocurrió un error al procesar la solicitud.');
                                            } finally {
                                                this.loading = false;
                                            }
                                        },
                                        async deleteArea() {
                                            const result = await showCustomConfirmation(false, '¿Está seguro de eliminar esta área?');
                                            if (result.isConfirmed) {
                                                this.loading = true;
                                                try {
                                                    const response = await fetch('{{ route('areas.destroy', $area) }}', {
                                                        method: 'POST',
                                                        headers: {
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                            'X-Requested-With': 'XMLHttpRequest',
                                                            'Accept': 'application/json'
                                                        },
                                                        body: new URLSearchParams({
                                                            '_method': 'DELETE'
                                                        })
                                                    });
                                                    const data = await response.json();
                                                    if (data.success) {
                                                        showCustomAlert('success', '¡Éxito!', 'Área eliminada exitosamente.');
                                                        window.location.reload();
                                                    } else {
                                                        showCustomAlert('error', 'Error', data.message);
                                                    }
                                                } catch (error) {
                                                    console.error('Error:', error);
                                                    showCustomAlert('error', 'Error', 'Ocurrió un error al eliminar el área.');
                                                } finally {
                                                    this.loading = false;
                                                }
                                            }
                                        }
                                    }">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400">{{ $area->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400">{{ $area->codigo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">{{ ucfirst($area->tipo) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400">{{ $area->padre->nombre ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $area->activo ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                            {{ $area->activo ? 'Activa' : 'Inactiva' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <a href="{{ route('areas.edit', $area) }}"
                                               class="inline-flex items-center text-indigo-600 hover:text-indigo-900 dark:text-indigo-500 dark:hover:text-indigo-300 transition-colors"
                                               title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line-icon w-7 h-7 lucide-pencil-line">
                                                    <path d="M13 21h8"/><path d="m15 5 4 4"/><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                                                </svg>
                                            </a>
                                            
                                            <button x-on:click="toggleStatus()"
                                                    :disabled="loading"
                                                    class="inline-flex items-center transition-colors disabled:opacity-50
                                                           {{ $area->activo ? 'text-orange-500 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-200' : 'text-green-600 hover:text-green-800 dark:text-green-500 dark:hover:text-green-300' }}"
                                                    title="{{ $area->activo ? 'Desactivar' : 'Activar' }}">
                                                <svg x-show="!loading && {{ $area->activo ? 'true' : 'false' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-x w-7 h-7">
                                                    <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>
                                                </svg>
                                                <svg x-show="!loading && {{ $area->activo ? 'false' : 'true' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-check w-7 h-7">
                                                    <rect width="18" height="18" x="3" y="3" rx="2"/><path d="m9 12 2 2 4-4"/>
                                                </svg>
                                                <svg x-show="loading" class="animate-spin h-7 w-7 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </button>

                                            <button x-on:click="deleteArea()" 
                                                    :disabled="loading"
                                                    class="inline-flex items-center text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-300 transition-colors disabled:opacity-50"
                                                    title="Eliminar">
                                                <svg x-show="!loading" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2 w-7 h-7">
                                                    <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/>
                                                </svg>
                                                <svg x-show="loading" class="animate-spin h-7 w-7 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $areas->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
    // Se asume que 'showCustomAlert' y 'showCustomConfirmation' están definidos globalmente.
    // Si no es así, necesitarás incluirlos.
@push('scripts')
<script>
$(document).ready(function() {
    // Toggle status
    $('.toggle-status').click(function() {
        const url = $(this).data('url');
        const button = $(this);
        
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    // Recargar la página para ver los cambios
                    location.reload();
                } else {
                    alert(response.message);
                }
            }
        });
    });

    // Eliminar área
    $('.delete-form').submit(function(e) {
        e.preventDefault();
        
        if (confirm('¿Está seguro de eliminar esta área?')) {
            const form = $(this);
            
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });
});
</script>
@endpush
