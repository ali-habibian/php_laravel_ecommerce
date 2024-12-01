import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/admin/admin.js',
                'resources/scss/admin/admin.scss'
            ],
            refresh: true,
        }),
    ],
});
