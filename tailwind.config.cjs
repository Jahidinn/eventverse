/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/views/event-studio/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    50: '#f2f8ff',
                    100: '#ebf3ff',
                    200: '#c2dcff',
                    300: '#8ec5ff',
                    400: '#5aa9ff',
                    500: '#3898ff',
                    600: '#2282ff',
                    700: '#1b6cd6',
                    800: '#1859b0',
                    900: '#174a8f',
                },
                ink: {
                    950: '#070d19',
                    900: '#0b1220',
                    800: '#0f172a',
                    700: '#1e293b',
                    600: '#334155',
                    500: '#475569',
                    400: '#64748b',
                    300: '#94a3b8',
                    200: '#cbd5e1',
                    100: '#e2e8f0',
                    50: '#f1f5f9',
                },
                canvas: '#f8fafc',
                surface: '#ffffff',
                line: '#e2e8f0',
            },
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'Segoe UI', 'sans-serif'],
                display: ['Plus Jakarta Sans', 'Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            boxShadow: {
                card: '0 1px 2px rgba(15, 23, 42, 0.04), 0 12px 28px -18px rgba(15, 23, 42, 0.18)',
                float: '0 18px 48px -24px rgba(15, 23, 42, 0.28)',
                brand: '0 12px 26px -14px rgba(34, 130, 255, 0.65)',
            },
            borderRadius: {
                xl2: '1.125rem',
            },
            keyframes: {
                'ev-fade-up': {
                    '0%': { opacity: '0', transform: 'translateY(8px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'ev-scale-in': {
                    '0%': { opacity: '0', transform: 'translateY(12px) scale(.98)' },
                    '100%': { opacity: '1', transform: 'translateY(0) scale(1)' },
                },
                'ev-pop': {
                    '0%': { opacity: '0', transform: 'scale(.94)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                'ev-spin': {
                    to: { transform: 'rotate(360deg)' },
                },
            },
            animation: {
                'ev-fade-up': 'ev-fade-up .35s ease both',
                'ev-scale-in': 'ev-scale-in .22s ease both',
                'ev-pop': 'ev-pop .2s ease both',
                'ev-spin': 'ev-spin 1s linear infinite',
            },
        },
    },

    plugins: [],
};
