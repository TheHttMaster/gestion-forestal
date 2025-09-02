<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <div class="bg-stone-100/90 dark:bg-custom-gray overflow-hidden shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-8">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight mb-6">
                Editar Proveedor
            </h2>
            <form action="{{ route('providers.update', $provider) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="name" :value="__('Nombre del Proveedor *')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name', $provider->name)" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="contact_name" :value="__('Persona de Contacto')" />
                        <x-text-input id="contact_name" class="block mt-1 w-full" type="text" name="contact_name"
                            :value="old('contact_name', $provider->contact_name)" autocomplete="contact_name" />
                        <x-input-error :messages="$errors->get('contact_name')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email', $provider->email)" autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="address" :value="__('Dirección')" />
                        <textarea id="address" name="address" rows="2"
                            class="block mt-1 w-full rounded-md border-gray-300 dark:bg-custom-gray dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 @error('address') border-red-500 @enderror">{{ old('address', $provider->address) }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                    
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="city" :value="__('Ciudad')" />
                        <x-text-input id="city" class="block mt-1 w-full" type="text" name="city"
                            :value="old('city', $provider->city)" autocomplete="city" />
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="country" :value="__('País')" />
                        <x-text-input id="country" class="block mt-1 w-full" type="text" name="country"
                            :value="old('country', $provider->country)" autocomplete="country" />
                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="notes" :value="__('Notas')" />
                    <textarea id="notes" name="notes" rows="3"
                        class="block mt-1 w-full rounded-md border-gray-300 dark:bg-custom-gray dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 @error('notes') border-red-500 @enderror">{{ old('notes', $provider->notes) }}</textarea>
                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                </div>

                <div class="flex items-center mt-2">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        {{ old('is_active', $provider->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">Proveedor activo</label>
                </div>

                <div class="flex items-center justify-end mt-6 space-x-4">
                    <x-go-back-button />
                    <x-primary-button>
                        Actualizar Proveedor
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>