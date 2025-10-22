import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/DataTableCss.css',
                'resources/css/styleDas.css', 

                'resources/img/user.jpg', 

                'resources/js/jquery-3.7.1.min.js',
                'resources/js/DashFunctions.js', 
                'resources/js/DataTableJs.js',
                'resources/js/app.js' 
            ],
            refresh: true,
        }),
    ],
});
