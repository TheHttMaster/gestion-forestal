import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Esta línea es crucial para el modo oscuro
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: { // Añade tus colores personalizados aquí.
                custom: {
                    dark: '#0e1013ff',
                    light: '#e7e5db',
                    gray: '#15171dff', 
                    gray2:'#040507',
                    gray3:'#0f131bff',
                    gold: {
                        light: '#e2ad39',
                        medium: '#cf7f17',
                        dark: '#ce7829',
                        darker: '#7e4a0e',
                        darkest: '#503017'
                    },
                    brown: '#7c4728'
                },
                amber: {
                    700: '#503017',
                    800: '#7c4728'                
                }
            },
        },
    },

    plugins: [forms],
};