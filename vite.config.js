import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/styleDas.css',
                'resources/css/DataTableCss.css',
                'resources/js/app.js',
                'resources/js/DashFunctions.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            host: process.env.RAILWAY_STATIC_URL || 'localhost',
        },
    },
    build: {
        cssCodeSplit: false,
    }
});