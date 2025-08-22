import './bootstrap';

import 'animate.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Swal from 'sweetalert2';

window.Swal = Swal; // Así puedes usarlo en scripts inline

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.sweet-confirm-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Obtener la acción del formulario
            const action = form.getAttribute('data-action');
            const isEnable = action === 'habilitar';
            
            // Personalizar mensajes según la acción
            const title = isEnable ? '¿Estás seguro?' : '¿Estás seguro?';
            const message = isEnable 
                ? '¡Esta acción habilitará al usuario!' 
                : '¡Esta acción deshabilitará al usuario!';
            const confirmText = isEnable ? 'Sí, habilitar' : 'Sí, deshabilitar';
            const iconColor = isEnable ? '#10b981' : '#f59f0bea';
            
            Swal.fire({
                title: title,
                html: `<div class="text-center">
                         <p class="text-gray-700 dark:text-gray-300 mb-4">${message}</p>
                       </div>`,
                icon: 'warning',
                iconColor: iconColor,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: 'Cancelar',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl bg-stone-100/90 dark:bg-custom-gray border border-gray-200 dark:border-gray-700',
                    title: 'text-2xl font-bold text-gray-900 dark:text-white',
                    htmlContainer: 'text-gray-600 dark:text-gray-300',
                    actions: 'gap-4 mt-6',
                    confirmButton: isEnable 
                        ? 'px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 ease-out border border-green-400/30'
                        : 'px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 ease-out border border-emerald-400/30',
                    cancelButton: 'px-6 py-3 bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 ease-out border border-rose-400/30'
                },
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
