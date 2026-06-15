import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: colors.indigo,
                muted: colors.slate,
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                xl: '1rem',
                '2xl': '1.25rem',
            },
            boxShadow: {
                soft: '0 6px 18px rgba(15, 23, 42, 0.06)',
            },
        },
    },

    plugins: [forms],
};
