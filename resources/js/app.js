import './bootstrap';

import 'animate.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Swal from 'sweetalert2';

window.Swal = Swal; // Así puedes usarlo en scripts inline

/* ALERTA DEL INHABILITAR USUARIO */
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.sweet-confirm-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Estás seguro?',
                html: `<div class="text-center">
                         <p class="text-gray-700 dark:text-gray-300 mb-4">¡Esta acción deshabilitará al usuario!</p>
                       </div>`,
                icon: 'warning',
                iconColor: '#f59f0bea', // Color del icono de advertencia
                showCancelButton: true,
              
                confirmButtonText: 'Sí, deshabilitar',
                cancelButtonText: 'Cancelar',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl bg-stone-100/90 dark:bg-custom-gray border border-gray-200 dark:border-gray-700',
                    title: 'text-2xl font-bold text-gray-900 dark:text-white mb-2',
                    htmlContainer: 'text-gray-600 dark:text-gray-300',
                    actions: 'gap-4 mt-6',
                    confirmButton: 'px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 ease-out border border-emerald-400/30',
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

