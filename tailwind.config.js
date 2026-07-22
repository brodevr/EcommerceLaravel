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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                petfy: {
                    light:   '#6dd5ed',
                    DEFAULT: '#2193b0',
                    dark:    '#176b87',
                    accent:  '#ffe082',
                },
            },
        },
    },

    plugins: [forms],
};
