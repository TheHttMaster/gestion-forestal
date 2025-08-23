<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:space-x-8">
            <div class="flex-1">
                <div class="bg-stone-100/90 dark:bg-custom-gray rounded-2xl shadow-soft p-6 mb-6">
                    <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight mb-4">
                        Detalles del Proveedor
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h6 class="text-indigo-600 font-bold mb-2">Información Básica</h6>
                            <p><span class="font-semibold">Nombre:</span> {{ $provider->name }}</p>
                            <p><span class="font-semibold">Contacto:</span> {{ $provider->contact_name ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Email:</span> {{ $provider->email ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Teléfono:</span> {{ $provider->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h6 class="text-indigo-600 font-bold mb-2">Ubicación</h6>
                            <p><span class="font-semibold">Dirección:</span> {{ $provider->address ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Ciudad:</span> {{ $provider->city ?? 'N/A' }}</p>
                            <p><span class="font-semibold">País:</span> {{ $provider->country ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Estado:</span>
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $provider->is_active ? 'bg-green-600 text-white' : 'bg-yellow-500 text-white' }}">
                                    {{ $provider->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    @if($provider->notes)
                        <div class="mt-6">
                            <h6 class="text-indigo-600 font-bold mb-2">Notas</h6>
                            <p>{{ $provider->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="w-full md:w-80 flex-shrink-0">
                <div class="bg-stone-100/90 dark:bg-custom-gray rounded-2xl shadow-soft p-6 mb-6">
                    <h6 class="font-bold text-indigo-600 mb-4">Acciones</h6>
                    <div class="flex flex-col gap-4">
                        <a href="{{ route('providers.edit', $provider) }}"
                           class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-edit mr-2"></i> Editar Proveedor
                        </a>
                        <form action="{{ route('providers.toggle-status', $provider) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 rounded-md
                                    {{ $provider->is_active ? 'bg-yellow-500 text-white hover:bg-yellow-600' : 'bg-green-600 text-white hover:bg-green-700' }}
                                    transition-colors">
                                <i class="fas {{ $provider->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }} mr-2"></i>
                                {{ $provider->is_active ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                        <form action="{{ route('providers.destroy', $provider) }}" method="POST" class="sweet-confirm-form" data-action="eliminar">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                <i class="fas fa-trash mr-2"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
                <div class="bg-stone-100/90 dark:bg-custom-gray rounded-2xl shadow-soft p-6">
                    <h6 class="font-bold text-indigo-600 mb-4">Información Adicional</h6>
                    <p><span class="font-semibold">Creado:</span> {{ $provider->created_at->format('d/m/Y H:i') }}</p>
                    <p><span class="font-semibold">Actualizado:</span> {{ $provider->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('providers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>
    </div>
</x-app-layout>