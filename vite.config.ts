import vue from '@vitejs/plugin-vue';
import autoprefixer from 'autoprefixer';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import tailwindcss from 'tailwindcss';
import { resolve } from 'node:path';
import { defineConfig, loadEnv } from 'vite';

export default defineConfig(({ mode }) => {
    // Lädt die .env-Variablen
    const env = loadEnv(mode, process.cwd(), '');

    return {
        plugins: [
            laravel({
                input: ['resources/js/app.ts'],
                ssr: 'resources/js/ssr.ts',
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
        ],
        resolve: {
            alias: {
                '@': path.resolve(__dirname, './resources/js'),
                'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
            },
        },
        css: {
            postcss: {
                plugins: [tailwindcss, autoprefixer],
            },
        },
        // KORREKTUR: Der Server-Block wird jetzt dynamisch konfiguriert.
        // Er wird nur hinzugefügt, wenn VITE_HMR_HOST in der .env-Datei definiert ist.
        // auf Privatem rechner in die .env datei Packen VITE_HMR_HOST=192.168.178.72
        server: env.VITE_HMR_HOST ? {
            host: '0.0.0.0',
            hmr: {
                host: env.VITE_HMR_HOST,
            },
            cors: true,
        } : undefined,
    };
});
