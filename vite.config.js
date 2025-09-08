import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/DataTableCss.css',
                'resources/css/global.css',

                'resources/img/**', 

                'resources/js/jquery-3.7.1.min.js',
                'resources/js/DataTableJs.js',
                'resources/js/app.js',
                'resources/js/global.js'
            ],
            refresh: true,
        }),
    ],
});
