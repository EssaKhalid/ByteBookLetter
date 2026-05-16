import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
    ],
    server: {
        host: '0.0.0.0', // Listen on all networks inside Docker
        port: 5173,
        strictPort: true,
        // CRITICAL: Tells the browser the assets are coming from the DDEV domain
        origin: 'https://bytebookletter.ddev.site:5173',
        hmr: {
            host: 'bytebookletter.ddev.site',
            protocol: 'wss', // Secure websocket for DDEV
        },
        cors: {
            origin: '*', // Allow the browser to accept the stream
        },
    },
});
