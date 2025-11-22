<div>
    <form wire:submit="update">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nombre del productor *')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" wire:model.live.debounce.250ms="name" autofocus />
            <x-input-error :messages="$errors->first('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="contact_name" :value="__('Persona de Contacto')" />
            <x-text-input id="contact_name" class="block mt-1 w-full" type="text" wire:model.live.debounce.250ms="contact_name" />
            <x-input-error :messages="$errors->first('contact_name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" wire:model.live.debounce.250ms="email" />
            <x-input-error :messages="$errors->first('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="address" :value="__('Dirección')" />
            <textarea id="address" wire:model.live="address" rows="2" class="block mt-1 w-full rounded-md border-gray-300 dark:bg-custom-gray dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            <x-input-error :messages="$errors->first('address')" class="mt-2" />
        </div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="city" :value="__('Ciudad')" />
                <x-text-input id="city" class="block mt-1 w-full" type="text" wire:model.live.debounce.250ms="city" />
                <x-input-error :messages="$errors->first('city')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="country" :value="__('País')" />
                <x-text-input id="country" class="block mt-1 w-full" type="text" wire:model.live.debounce.250ms="country" />
                <x-input-error :messages="$errors->first('country')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="notes" :value="__('Notas')" />
            <textarea id="notes" wire:model.live="notes" rows="3" class="block mt-1 w-full rounded-md border-gray-300 dark:bg-custom-gray dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            <x-input-error :messages="$errors->first('notes')" class="mt-2" />
        </div>

        <div class="mt-4 flex items-center">
            <input type="checkbox" id="is_active" wire:model="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">productor activo</label>
        </div>

        <div class="flex items-center justify-end mt-6 space-x-4">
            <x-go-back-button />
            <x-primary-button>
                {{ __('Actualizar productor') }}
            </x-primary-button>
        </div>
    </form>
</div>