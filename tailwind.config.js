import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Outfit', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                gray: {
                    55: '#f8fafc',
                    105: '#f1f5f9',
                    150: '#eef1f4',
                    155: '#e2e8f0',
                    405: '#94a3b8',
                    450: '#8592a3',
                    555: '#64748b',
                    650: '#4e5b7c',
                    750: '#334155',
                    850: '#1e293b',
                    855: '#1a2238',
                    905: '#0f172a',
                    955: '#020617',
                }
            }
        },
    },

    plugins: [forms],
};
