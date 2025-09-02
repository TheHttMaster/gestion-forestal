<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto ">
            <div class="bg-stone-100/90 dark:bg-custom-gray overflow-hidden shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-8 ">
                <div class="text-gray-900 dark:text-gray-100 ">
                    <h2 class="font-semibold text-xl leading-tight ">
                        {{ __('Lista de Usuarios') }}
                    </h2>
                    <div class="flex justify-end mb-4 space-x-4">
                        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-lime-600/90 text-white rounded-md hover:bg-lime-600">
                            {{ __('Crear Nuevo Usuario') }}
                        </a>
                        <a href="{{ route('admin.users.disabled') }}" class="px-4 py-2 bg-orange-500/90 text-white rounded-md hover:bg-amber-600">
                            {{ __('Ver Deshabilitados') }}
                        </a>
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
                            @php $i = 1; @endphp
                            @foreach($users as $user)
                                <tr id="user-row-{{ $user->id }}" 
                                    x-data="{
                                    loading: false,
                                    async disableUser() {
                                        this.loading = true;
                                        try {
                                            const response = await fetch('{{ route('admin.users.destroy', $user) }}', {
                                                method: 'DELETE',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'X-Requested-With': 'XMLHttpRequest',
                                                    'Accept': 'application/json'
                                                }
                                            });
                                            
                                            const data = await response.json();
                                            
                                            if (data.success) {
                                                const table = $('#users-table').DataTable();
                                                const row = $('#user-row-{{ $user->id }}');
                                                table.row(row).remove().draw();
                                                
                                                showCustomAlert('success', '¡Éxito!', data.message);
                                            } else {
                                                showCustomAlert('error', 'Error', data.message);
                                            }
                                        } catch (error) {
                                            console.error('Error:', error);
                                            showCustomAlert('error', 'Error', 'Ocurrió un error al deshabilitar el usuario.');
                                        } finally {
                                            this.loading = false;
                                        }
                                    }
                                }">
                                    <!-- ... contenido de la fila ... -->
                          
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400">{{ $i++ }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
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
                                               class="inline-flex items-center text-indigo-600 hover:text-indigo-900 dark:text-indigo-500 dark:hover:text-indigo-300 transition-colors"
                                               title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line-icon w-7 h-7 lucide-pencil-line">
                                                    <path d="M13 21h8"/><path d="m15 5 4 4"/><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                                                </svg>
                                            </a>
                                            
                                           <!-- Botón Deshabilitar -->
                                            <button x-on:click="
                                                const result = await showCustomConfirmation(false, 'Vas a deshabilitar al usuario: {{ $user->name }}');
                                                if (result.isConfirmed) {
                                                    disableUser();
                                                }
                                            " 
                                            :disabled="loading"
                                            class="inline-flex items-center text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-300 transition-colors disabled:opacity-50"
                                            title="Deshabilitar">
                                                <svg x-show="!loading" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-x-icon w-7 h-7 lucide-user-x">
                                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="17" x2="22" y1="8" y2="13"/><line x1="22" x2="17" y1="8" y2="13"/>
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
            </div>
        </div>
    </div>
</x-app-layout>