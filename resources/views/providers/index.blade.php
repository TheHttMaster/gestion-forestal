<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <div class="bg-stone-100/90 dark:bg-custom-gray overflow-hidden shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-8">
            <div class="text-gray-900 dark:text-gray-100">
                <h2 class="font-semibold text-xl leading-tight mb-4">
                    {{ __('Lista de Proveedores') }}
                </h2>
                <div class="flex justify-end mb-4 space-x-4">
                    <a href="{{ route('providers.create') }}" class="px-4 py-2 bg-lime-600/90 text-white rounded-md hover:bg-lime-600">
                        {{ __('Nuevo Proveedor') }}
                    </a>
                </div>

                <!-- Filtros -->
                <form method="GET" action="{{ route('providers.index') }}" class="mb-6">
                    <div class="flex flex-wrap gap-4">
                        <input type="text" name="search" class="form-input rounded-md border-gray-300" placeholder="Buscar proveedores..." value="{{ $search ?? '' }}">
                        <select name="status" class="form-select rounded-md border-gray-300">
                            <option value="all" {{ ($status ?? '') == 'all' ? 'selected' : '' }}>Todos</option>
                            <option value="active" {{ ($status ?? '') == 'active' ? 'selected' : '' }}>Activos</option>
                            <option value="inactive" {{ ($status ?? '') == 'inactive' ? 'selected' : '' }}>Inactivos</option>
                            <option value="deleted" {{ ($status ?? '') == 'deleted' ? 'selected' : '' }}>Eliminados</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Filtrar</button>
                    </div>
                </form>

                @if($providers->count() > 0)
                    <div class="overflow-x-auto">
                        <table id="providers-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-stone-100/90 dark:bg-custom-gray">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Contacto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="bg-stone-100/90 dark:bg-custom-gray divide-y divide-gray-200">
                                @foreach($providers as $provider)
                                    <tr id="provider-row-{{ $provider->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400">{{ $provider->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400">{{ $provider->contact_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400">{{ $provider->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($provider->deleted_at)
                                                <span class="inline-block px-3 py-1 text-xs font-semibold bg-red-600 text-white rounded-full">Eliminado</span>
                                            @else
                                                <span class="inline-block px-3 py-1 text-xs font-semibold {{ $provider->is_active ? 'bg-green-600 text-white' : 'bg-yellow-500 text-white' }} rounded-full">
                                                    {{ $provider->is_active ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                @if(!$provider->deleted_at)
                                                    <a href="{{ route('providers.show', $provider) }}" class="inline-flex items-center text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors" title="Ver">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon w-7 h-7 lucide-eye">
                                                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/>
                                                        </svg>
                                                    </a>

                                                    <!-- Botón Editar -->
                                                    <a href="{{ route('providers.edit', $provider) }}" 
                                                    class="inline-flex items-center text-indigo-600 hover:text-indigo-900 dark:text-indigo-500 dark:hover:text-indigo-300 transition-colors"
                                                    title="Editar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line-icon w-7 h-7 lucide-pencil-line">
                                                            <path d="M13 21h8"/><path d="m15 5 4 4"/><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                                                        </svg>
                                                    </a>
                                            
                                                    <form action="{{ route('providers.toggle-status', $provider) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center p-2 rounded-lg transition-all duration-300 hover:bg-opacity-10 hover:scale-105" 
                                                                title="Cambiar estado"
                                                                :class="$provider->is_active ? 'hover:bg-green-600' : 'hover:bg-yellow-600'">
                                                            
                                                            <!-- Estado activo - Verde -->
                                                            @if($provider->is_active)
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500 w-7 h-7">
                                                                    <circle cx="12" cy="12" r="10" class="fill-yellow-100"/>
                                                                    <line x1="15" y1="9" x2="9" y2="15" class="stroke-yellow-600"/>
                                                                    <line x1="9" y1="9" x2="15" y2="15" class="stroke-yellow-600"/>
                                                                </svg>
                                                            
                                                            <!-- Estado inactivo - Amarillo -->
                                                            @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500 w-7 h-7">
                                                                    <circle cx="12" cy="12" r="10" class="fill-green-100"/>
                                                                    <path d="m8 12 2.5 2.5L16 9" class="stroke-green-600"/>
                                                                </svg>
                                                                
                                                            @endif
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('providers.destroy', $provider) }}" method="POST" class="inline sweet-confirm-form" data-action="deshabilitar">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-300 transition-colors" title="Eliminar">
                                                             <svg x-show="!loading" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-x-icon w-7 h-7 lucide-user-x">
                                                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="17" x2="22" y1="8" y2="13"/><line x1="22" x2="17" y1="8" y2="13"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('providers.restore', $provider->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center text-green-600 hover:text-green-900 dark:text-green-500 dark:hover:text-green-300 transition-colors" title="Restaurar">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-ccw-icon w-7 h-7 lucide-rotate-ccw">
                                                                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('providers.force-delete', $provider->id) }}" method="POST" class="inline sweet-confirm-form" data-action="eliminar">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-300 transition-colors" title="Eliminar permanentemente">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon w-7 h-7 lucide-trash-2">
                                                                <path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $providers->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        No se encontraron proveedores.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>