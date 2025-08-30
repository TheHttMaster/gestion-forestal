<x-app-layout>
    <x-slot name="header">
        
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto">
            <div class="bg-stone-100/90 dark:bg-custom-gray overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 ">

                    <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight md:mb-6">
                        {{ __('Crear Usuario') }}
                    </h2>
                    
                        <livewire:form-user />

                </div>
            </div>
        </div>
    </div>
</x-app-layout>