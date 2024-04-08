import {defineConfig} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';
import livewire from '@defstudio/vite-livewire-plugin';

export default defineConfig({
    build: {
        assetsDir: 'fonts',
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: false,
        }),
        livewire({
            refresh: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
        }),
    ],
});