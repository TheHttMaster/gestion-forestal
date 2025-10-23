<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto ">
            <div class="bg-stone-100/90 dark:bg-custom-gray overflow-hidden shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-8 ">
                <div class="text-gray-900 dark:text-gray-100 ">
                    <h2 class="font-semibold text-xl leading-tight ">
                        {{ __('Lista de Usuarios') }}
                    </h2>
                    <div class="flex justify-end mb-4 space-x-4">
                        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-gradient-to-r from-lime-500/90 to-lime-600/90 dark:from-lime-700/70 dark:to-lime-800/70 hover:from-lime-600/90 hover:to-lime-700/90 dark:hover:from-lime-700 dark:hover:to-lime-800  text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-350 ease-out border border-lime-400/30 dark:border-lime-800/40">
                            {{ __('Crear Nuevo Usuario') }}
                        </a>
                        <a href="{{ route('admin.users.disabled') }}" class="px-4 py-2 bg-gradient-to-r from-orange-500/90 to-orange-600/90 dark:from-orange-600/70 dark:to-orange-700/80 hover:from-orange-600/90 hover:to-orange-700/90 dark:hover:from-orange-600/90 dark:hover:to-orange-700/90  text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-350 ease-out border border-orange-400/30 dark:border-orange-800/40">
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
                           
                            @foreach($users as $user)
                                <tr id="user-row-{{ $user->id }}" 
                                    x-data="{
                                        async disableUser() {
                                            // Quitar this.loading = true y todo lo relacionado con loading
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
                                            }
                                        }
                                    }">

                                    
                                    {{-- CAMBIO CLAVE: Usamos $loop->iteration en su lugar --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400">
                                        {{ $loop->iteration }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-400">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                        <form x-data="{
                                                    originalRole: '{{ $user->role }}',
                                                    isSelf: {{ Auth::id() === $user->id ? 'true' : 'false' }},
                                                    
                                                    // Definición de accesos para la advertencia
                                                    permissions: {
                                                        'administrador': 'Acceso total a la administración de usuarios, auditoría, y gestión completa de datos.',
                                                        'basico': 'Acceso restringido a la visualización de datos y reportes personales.'
                                                    },
                                    
                                                    // Función que ejecuta la lógica final de confirmación (si es necesario) y el envío.
                                                    async proceedToSubmit(newRole) {
                                                        let finalConfirmation = true;
                                    
                                                        // Lógica de DOBLE CONFIRMACIÓN SOLO para el propio usuario y si está bajando de rol
                                                        if (this.isSelf && newRole === 'basico' && this.originalRole === 'administrador') {
                                                            
                                                            const lostAccess = this.permissions['administrador']; // Lista de lo que perderá
                                                            
                                                            const secondMessage = `
                                                                <b>ADVERTENCIA FINAL:</b> Estás cambiando tu rol de <b>Administrador</b> a <b>Básico</b>.
                                                                Estás a punto de <b>perder el siguiente acceso</b>:
                                                                
                                                                <p class='mt-2 p-2 bg-red-100 dark:bg-red-900/50 rounded-lg text-sm'>
                                                                    ${lostAccess}
                                                                </p>
                                                                
                                                                <b>¿CONFIRMAS BAJAR TUS PROPIOS PERMISOS?</b>
                                                            `;
                                                            
                                                            const result = await window.showCustomConfirmation(true, secondMessage, 'Cambiar');
                                                            
                                                            finalConfirmation = result.isConfirmed;
                                                        }
                                                        
                                                        if (finalConfirmation) {
                                                            $el.form.submit();
                                                        } else {
                                                            // Si cancela la segunda modal, restablece el valor del select.
                                                            $event.target.value = this.originalRole;
                                                        }
                                                    }
                                                }"
                                                action="{{ route('admin.users.update-role', $user) }}" 
                                                method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" 
                                                    x-on:change="
                                                        const newRole = $event.target.value;
                                                        const roleText = (newRole === 'administrador') ? 'Administrador' : 'Básico';
                                                        
                                                        // Solo procedemos a la doble confirmación si el rol cambia
                                                        if (newRole === originalRole) {
                                                            return; // No hacer nada si el rol no cambió realmente
                                                        }
                                    
                                                        let customMessage;
                                                        let customConfirmText = `Cambiar`;
                                    
                                                        // PRIMERA CAPA DE CONFIRMACIÓN (Alerta general)
                                                        if (isSelf) {
                                                            customMessage = `<b>¡ATENCIÓN!</b> Al cambiar tu propio rol, tu <b>acceso</b> y <b>permisos</b>
                                                                dentro del sistema se verán <b>afectados</b>. <b>¿Estás seguro de que quieres continuar?</b>`;
                                                            customConfirmText = `Cambiar`;
                                                        } else {
                                                            customMessage = `¿Estás seguro de que quieres cambiar el rol de 
                                                                <b>{{ $user->name }}</b> a <b>${roleText}</b>?`;
                                                        }
                                                            
                                                        const result = await window.showCustomConfirmation(false, customMessage, customConfirmText);
                                    
                                                        if (result.isConfirmed) {
                                                            // Si la primera confirmación es OK, lanza la lógica final (que incluye la segunda modal si aplica)
                                                            proceedToSubmit(newRole);
                                                        } else {
                                                            // Si cancela la primera modal, restablece el valor.
                                                            $event.target.value = originalRole;
                                                        }
                                                    "
                                                    class="block w-full bg-gray-200 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                
                                                <option value="basico" @if ($user->role === 'basico') selected @endif>Básico</option>
                                                <option value="administrador" @if ($user->role === 'administrador') selected @endif>Administrador</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               class="inline-flex items-center text-indigo-600 hover:text-indigo-900 dark:text-indigo-500 dark:hover:text-indigo-300 transform hover:-translate-y-0.5 transition-all duration-750 ease-out"
                                               title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line-icon w-7 h-7 lucide-pencil-line">
                                                    <path d="M13 21h8"/><path d="m15 5 4 4"/><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                                                </svg>
                                            </a>
                                            
                                            @if (Auth::id() !== $user->id)
                                                <button x-on:click="
                                                    const result = await showCustomConfirmation(false, 'Vas a deshabilitar al usuario: {{ $user->name }}');
                                                    if (result.isConfirmed) {
                                                        disableUser();
                                                    }
                                                " 
                                                class="inline-flex items-center text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-300 transform hover:-translate-y-0.5 transition-all duration-750 ease-out"
                                                title="Deshabilitar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-x-icon w-7 h-7 lucide-user-x">
                                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="17" x2="22" y1="8" y2="13"/><line x1="22" x2="17" y1="8" y2="13"/>
                                                    </svg>
                                                </button>
                                            @endif
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