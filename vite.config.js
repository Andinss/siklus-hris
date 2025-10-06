import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
	plugins: [
		laravel({
			input: [
				// 'resources/css/app.css',
				'resources/sass/style.scss', // SCSS entry
				'resources/js/app.js', // JS entry
			],
			refresh: true,
		}),
	],
	build: {
        outDir: 'public',
        emptyOutDir: false,
        rollupOptions: {
            output: {
                entryFileNames: 'assets/js/[name].js',
                chunkFileNames: 'assets/js/[name].js',
                assetFileNames: ({ names, type }) => {
                    const filename = names?.[0] ?? 'asset';
                    if (type === 'asset' && filename.endsWith('.css')) {
                        return 'assets/css/[name][extname]';
                    }
                    return 'assets/[name][extname]';
                },
            },
        },
    },
});
