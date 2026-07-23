import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'tightenco-ziggy';

// Layout Imports (js/Layout/ sibling of Pages)
import FrontLayout from './Layout/frontend/FrontLayout.vue';
import AdminLayout from './Layout/admin/AdminLayout.vue';
import 'vue3-toastify/dist/index.css';

createInertiaApp({
    resolve: name => {
        // Vite Glob Import for all nested components inside js/Pages/
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })

        // Direct Path Lookup (e.g., ./Pages/backend/dashboard/Dashboard.vue)
        let page = pages[`./Pages/${name}.vue`]

        // Fallback Fuzzy Search (If case sensitive mismatch occurs)
        if (!page) {
            const match = Object.keys(pages).find(path => 
                path.toLowerCase().endsWith(`${name.toLowerCase()}.vue`)
            )
            if (match) {
                page = pages[match]
            }
        }

        if (!page) {
            throw new Error(`Page ./Pages/${name}.vue not found.`)
        }

        // Layout Auto-Assignment Logic
        if (page.default.layout === undefined) {
            // 'backend/' ফোল্ডারের ভেতরের সব পেজের জন্য AdminLayout সেট হবে
            const isBackend = name.toLowerCase().startsWith('backend/');
            page.default.layout = isBackend ? AdminLayout : FrontLayout;
        }

        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el)
    },
})