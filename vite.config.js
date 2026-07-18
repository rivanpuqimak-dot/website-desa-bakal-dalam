import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/app.public-home.css',
                'resources/css/app.public-profile.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});