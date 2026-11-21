/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/views/dashboard/layouts/modern.blade.php',
        './resources/views/dashboard/components/dashboard-*.blade.php',
        './resources/views/dashboard/components/create-event-modal.blade.php',
        './resources/views/dashboard/components/pagination.blade.php',
        './resources/views/dashboard/components/article-manager.blade.php',
        './resources/views/dashboard/page-dashboard.blade.php',
        './resources/views/dashboard/myevent.blade.php',
        './resources/views/dashboard/page-checkin-event.blade.php',
        './resources/views/dashboard/page-participant.blade.php',
        './resources/views/dashboard/page-transaction.blade.php',
        './resources/views/dashboard/manajemen-event.blade.php',
        './resources/views/dashboard/page-profile.blade.php',
        './resources/views/dashboard/page-organization.blade.php',
        './resources/views/dashboard/participant-event.blade.php',
        './resources/views/dashboard/checkin-event.blade.php',
        './resources/views/dashboard/admin-dashboard/admin-index.blade.php',
        './resources/views/dashboard/admin-dashboard/admin-users.blade.php',
        './resources/views/dashboard/admin-dashboard/admin-user-edit.blade.php',
        './resources/views/dashboard/admin-dashboard/admin-roles.blade.php',
        './resources/views/dashboard/admin-dashboard/admin-role-permissions.blade.php',
        './resources/views/dashboard/admin-dashboard/admin-article-category.blade.php',
        './resources/views/dashboard/admin-dashboard/admin-article.blade.php',
        './resources/views/dashboard/admin-dashboard/admin-audit-logs.blade.php',
        './resources/views/dashboard/admin-dashboard/admin-payments.blade.php',
        './resources/views/dashboard/admin-dashboard/admin-wd-request.blade.php',
        './resources/views/dashboard/admin-dashboard/admin-selected-event.blade.php',
        './resources/views/dashboard/admin-dashboard/admin-promotion-event.blade.php',
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
                    900: '#0f172a',
                    800: '#1e293b',
                    700: '#334155',
                    600: '#475569',
                    500: '#64748b',
                    400: '#94a3b8',
                    300: '#cbd5e1',
                    200: '#e2e8f0',
                    100: '#f1f5f9',
                    50: '#f8fafc',
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
                card: '0 1px 2px rgba(15, 23, 42, 0.03), 0 16px 40px -28px rgba(15, 23, 42, 0.22)',
                float: '0 24px 60px -32px rgba(15, 23, 42, 0.32)',
            },
            borderRadius: {
                xl2: '1.125rem',
            },
            keyframes: {
                'dash-fade-up': {
                    '0%': { opacity: '0', transform: 'translateY(6px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
            animation: {
                'dash-fade-up': 'dash-fade-up .3s ease both',
            },
        },
    },

    plugins: [],
};
