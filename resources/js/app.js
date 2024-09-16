import './bootstrap';
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import 'primeicons/primeicons.css'; // Ikon PrimeVue
import 'vue-multiselect/dist/vue-multiselect.css'; // Gaya Multiselect Vue
import Aura from '../js/presets/aura'; // Konfigurasi Aura (jika digunakan)
import ThemeProvider from '@/Components/ThemeProvider.vue'; // Komponen ThemeProvider
import ToastService from 'primevue/toastservice'; // Layanan Toast
import Toast from 'primevue/toast'; // Komponen Toast

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),

    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(ThemeProvider, [h(App, props)]) })
            .use(plugin)
            .use(PrimeVue, {
                unstyled: true,
                pt: Aura
            })
            .use(ZiggyVue)
            .use(ToastService) // Menambahkan ToastService ke aplikasi
            .component('Toast', Toast); // Mendaftarkan komponen Toast

        // Mount aplikasi
        app.mount(el);

        return app;
    },
    progress: {
        color: '#4B5563',
    },
});
