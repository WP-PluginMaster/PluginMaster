import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import liveReload from 'vite-plugin-live-reload'

// https://vitejs.dev/config/

export default defineConfig({

    plugins: [
        vue(),
        liveReload('resources/js/vue3')
    ],

    // config
    root: 'resources/js/vue3',
    base: '/',

    build: {
        // output dir for production build
        outDir: path.resolve(__dirname, 'assets/vue'),
        emptyOutDir: true,

        // emit manifest so PHP can find the hashed files
        manifest: true,

        // esbuild target
        target: 'es2018',

        // our entry
        rollupOptions: {
            input: '/app.js',
            output: {
                entryFileNames: `assets/[name].js`,
                chunkFileNames: `assets/[name].js`,
                assetFileNames: `assets/[name].[ext]`
            }
        },
    },

    server: {
        fs: {
            strict: false,
        },
        // required to load scripts from custom host
        cors: true,

        // we need a strict port to match on PHP side
        // change freely, but update on PHP to match the same port
        strictPort: true,
        port: 3000
    },

    // required for in-browser template compilation
    // https://v3.vuejs.org/guide/installation.html#with-a-bundler
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js'
        }
    }
})
