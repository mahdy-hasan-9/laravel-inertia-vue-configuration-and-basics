import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'tightenco-ziggy';
import DefaultLayout from './Layout/default/DefaultLayout.vue';
import FrontLayout from './Layout/frontend/FrontLayout.vue';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        let page = pages[`./Pages/${name}.vue`]
        if (!page) {
            throw new Error(`Page ./Pages/${name}.vue not found.`)
        }        
        page.default.layout = page.default.layout === undefined ? FrontLayout : page.default.layout
        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el)
    },
})