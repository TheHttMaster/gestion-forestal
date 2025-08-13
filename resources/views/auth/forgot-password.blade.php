<x-guest-layout>
    <div class="shadow-2xl hover:shadow-3xl dark:shadow-gray-900/50 bg-stone-100/90 dark:bg-custom-gray rounded-lg transition-all duration-300">
        <!-- Header del card -->
        <div class="px-3 sm:px-4 md:px-5 py-3 sm:py-4 pb-3 sm:pb-4">
            <h2 class="text-base sm:text-lg md:text-xl lg:text-2xl text-center text-custom-dark dark:text-amber-100 font-semibold transition-colors">Recuperación de Contraseña</h2>
        </div>

        <div class="px-3 sm:px-4 md:px-5 py-3 sm:py-4 pb-3 sm:pb-4 mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('¿Olvidaste tu contraseña? No hay problema. Solo dinos tu dirección de correo electrónico y te enviaremos un enlace para restablecerla, el cual te permitirá elegir una nueva.') }}
        </div>

        <!-- Contenido del card -->
        <div class="px-3 sm:px-4 md:px-5 pb-3 sm:pb-4 md:pb-5">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Correo')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4 space-x-6">
                    <x-go-back-button />
                    <x-primary-button>
                        {{ __('Enviar enlace') }}
                    </x-primary-button>
                </div>
                
            </form>
            
            <!-- Separador y enlace de contacto -->
            <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-amber-200 dark:border-gray-600 transition-colors">
                <p class="text-center text-xs text-custom-gold-darker dark:text-custom-gold-medium transition-colors">
                    ¿Necesitas acceso?
                    <button class="text-amber-800 dark:text-custom-gold-light hover:text-custom-dark dark:hover:text-amber-100 font-medium hover:underline ml-1 transition-colors">
                        Contacta al administrador
                    </button>
                </p>
            </div>
        </div>
    </div>


    <!-- Session Status -->
    
</x-guest-layout>
