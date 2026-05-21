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
                    455: '#7d8c9f',
                    550: '#5f6e89',
                    555: '#64748b',
                    650: '#4e5b7c',
                    750: '#334155',
                    850: '#1e293b',
                    855: '#1a2238',
                    905: '#0f172a',
                    955: '#020617',
                },
                blue: {
                    550: '#3170e8',
                    605: '#2155d3',
                    650: '#1d40d0',
                    705: '#1e3a8a',
                },
                indigo: {
                    650: '#493ecb',
                    705: '#3730a3',
                },
                amber: {
                    550: '#cc7000',
                }
            }
        },
    },

    plugins: [forms],
};
