import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/admin/admin.js',
                'resources/scss/admin/admin.scss',
                'resources/scss/home/home.scss',
                'resources/scss/home/home.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            'jquery': 'jquery/dist/jquery.js'
        }
    },
});
