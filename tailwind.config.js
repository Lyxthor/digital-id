import { opacity } from 'html2canvas-pro/dist/types/css/property-descriptors/opacity';
import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                wiggle: {
                    '0%, 50%, 100%': { transform: 'rotate(0deg)' },
                    '25%': { transform: 'rotate(1deg)' },
                    '75%': { transform: 'rotate(-1deg)' }
                },
                'fade-out': {
                    '0%': {opacity: 1 },
                    '100%': {opacity: 0}
                }
            },
            animation: {
                wiggle: 'wiggle 1s ease-in-out infinite',
                'once-wiggle': 'wiggle 300ms ease',
                'fade-out': 'fade-out 1.5s ease forwards'
            }
        },
    },
    plugins:
    [
        require('daisyui')
    ],
};
