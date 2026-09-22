import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                finpulse: {
                    navy:  '#39E554',   /* primary green — replaces old dark navy */
                    gold:  '#28a04a',   /* secondary green — replaces old gold */
                    cream: '#f0fdf4',   /* light mint background */
                    gray:  '#64748b',   /* slate-500 for body text */
                },
                emerald: {
                    DEFAULT: '#00C48C',
                    50: '#F0FDF8',
                    100: '#DCFCE7',
                    200: '#BBF7D0',
                    400: '#34D399',
                    500: '#00C48C',
                    600: '#00A86B',
                    700: '#059669',
                    800: '#065F46',
                    900: '#064E3B',
                },
                forest: {
                    DEFAULT: '#061A14',
                    800: '#0B2A20',
                    900: '#061A14',
                    950: '#03100C',
                },
            },
        },
    },

    plugins: [forms],
};
