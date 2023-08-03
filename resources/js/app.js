import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Icons from './Components/Icons.vue';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const VueApp = createApp({ render: () => h(App, props) })
        VueApp.config.globalProperties.$filters = {
            formatCurrency(value) {
                return value.toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD'
                })
            }
        }
        VueApp
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component('Icon', Icons)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
