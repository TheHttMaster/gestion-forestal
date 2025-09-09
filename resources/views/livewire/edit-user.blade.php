<div>
    <form wire:submit="update">
        @csrf

        <div class="mt-4">
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" wire:model.live.debounce.250ms="name" autofocus />
            <x-input-error :messages="$errors->first('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" wire:model.live.debounce.250ms="email" />
            <x-input-error :messages="$errors->first('email')" class="mt-2" />
        </div>

        <div class="mt-4 text-gray-900 dark:text-gray-300">
            <x-input-label for="role" :value="__('Rol')" />
            <select id="role" class="block mt-1 w-full bg-gray-200  border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"" wire:model.live="role">
                <option value="basico" @if ($user->role === 'basico') selected @endif>{{ __('Básico') }}</option>
                <option value="administrador" @if ($user->role === 'administrador') selected @endif>{{ __('Administrador') }}</option>
            </select>
            <x-input-error :messages="$errors->first('role')" class="mt-2" />
        </div>
        
        <div class="flex items-center justify-end mt-4 space-x-4">

            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-red-600/90 dark:bg-red-600/80 border border-transparent rounded-md font-semibold text-xs text-white  uppercase tracking-widest hover:bg-red-600 dark:hover:bg-red-700 focus:bg-red-700 dark:focus:bg-red-600 active:bg-red-700/70 dark:active:bg-red-800/70 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Cancelar
            </a>
            <x-primary-button class="ms-4">
                {{ __('Actualizar Usuario') }}
            </x-primary-button>
        </div>
    </form>
</div>