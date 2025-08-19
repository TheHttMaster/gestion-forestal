<x-app-layout>
    
      
    

    <div class="">
        <div class="max-w-7xl mx-auto ">
            <div class="bg-stone-100/90 dark:bg-custom-gray overflow-hidden shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-8 ">
                <div class="text-gray-900 dark:text-gray-100 ">
                    <h2 class="font-semibold text-xl leading-tight ">
                        {{ __('Lista de Usuarios') }}
                    </h2>
                    <div class="flex justify-end mb-4 space-x-4">
                        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            {{ __('Crear Nuevo Usuario') }}
                        </a>

                        <!-- boton del modal que se podria llegar a usar
                        <x-primary-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        >{{ __('Eliminar Cuenta') }}</x-primary-button> -->

                        <a href="{{ route('admin.users.disabled') }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                            {{ __('Ver Deshabilitados') }}
                        </a>
                        @if (session('status'))
                            <script>
                                alert("{{ session('status') }}");
                            </script>
                        @endif
                    </div>

                    <table id="users-table" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-stone-100/90 dark:bg-custom-gray ">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Rol</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-gray-300 uppercase tracking-wider">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="bg-stone-100/90 dark:bg-custom-gray divide-y divide-gray-200">
                            @php
                                $i = 1;
                            @endphp
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400 ">{{ $i++ }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400 ">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400 ">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300 ">
                                        <form action="{{ route('admin.users.update-role', $user) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" onchange="this.form.submit()" class="block w-full bg-gray-200 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <option value="basico" @if ($user->role === 'basico') selected @endif>Básico</option>
                                                <option value="administrador" @if ($user->role === 'administrador') selected @endif>Administrador</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <!-- Botón Editar -->
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               class="inline-flex items-center text-indigo-600 hover:text-indigo-900 transition-colors"
                                               title="Editar">
                                                <i data-lucide="pencil" class="w-7 h-7"></i>
                                            </a>
                                            
                                            <!-- Botón Deshabilitar -->
                                            <form action="{{ route('admin.users.destroy', $user) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('¿Estás seguro de deshabilitar este usuario?')"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center text-red-600 hover:text-red-900 transition-colors"
                                                        title="Deshabilitar">
                                                    <i data-lucide="user-x" class="w-7 h-7"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   
<!-- 
        modal para posibilidad de usarlo

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
       
       
        <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 rounded-2xl shadow-soft">
            @csrf
             <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Crear Usuario') }}
            </h2>

            <div>
                <x-input-label for="name" :value="__('Nombre')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4 space-x-4">
                 <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button class="ms-4">
                    {{ __('Crear Usuario') }}
                </x-primary-button>
            </div>
        </form>

    </x-modal> -->

</x-app-layout>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
   
</script>