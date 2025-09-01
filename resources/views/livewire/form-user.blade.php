<div>
    <form wire:submit="store">
        @csrf

        <div class="mt-4">
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" wire:model.live.debounce.250ms="name" autofocus onkeypress="return evitarNumeros(event)" />
            <x-input-error :messages="$errors->first('name')" class="mt-2" />
        </div>
    
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" wire:model.live.debounce.250ms="email" />
            <x-input-error :messages="$errors->first('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" wire:model.live.debounce.250ms="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" wire:model.live.debounce.250ms="password_confirmation" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 space-x-4">
            <x-go-back-button />
            <x-primary-button class="ms-4">
                {{ __('Crear Usuario') }}
            </x-primary-button>
        </div>
    </form>
</div>

<script>
   /*  function evitarNumeros(event) {
        const charCode = event.which ? event.which : event.keyCode;
        
        // Permitir teclas de control (backspace, delete, tab, etc.)
        if (charCode === 8 || charCode === 0 || charCode === 9) {
            return true;
        }
        
        // Permitir letras, espacios y caracteres especiales en español
        const esLetra = (charCode >= 65 && charCode <= 90) || // A-Z
                       (charCode >= 97 && charCode <= 122) || // a-z
                       charCode === 32 || // espacio
                       charCode === 209 || charCode === 241 || // Ñ, ñ
                       (charCode >= 192 && charCode <= 255); // caracteres acentuados
        
        return esLetra;
    }
 */
</script>