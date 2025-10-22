import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // SOLO CSS
                'resources/css/app.css',
                'resources/css/styleDas.css', 
                'resources/css/DataTableCss.css',
                
                // SOLO JS - EN ORDEN CORRECTO
                'resources/js/app.js',           // PRIMERO - el principal
                'resources/js/jquery-3.7.1.min.js',
                'resources/js/DataTableJs.js',
                'resources/js/DashFunctions.js'  // ÚLTIMO - depende de los otros
            ],
            refresh: true,
        }),
    ],
});
