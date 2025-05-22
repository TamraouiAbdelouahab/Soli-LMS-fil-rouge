import "../css/app.css";
import "./bootstrap";

import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createApp, h } from "vue";
import { ZiggyVue } from "ziggy-js";
import Chart from "chart.js/auto";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

const modulePages = import.meta.glob("/modules/**/Resources/js/Pages/**/*.vue");

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        // Handle module pages (Core::Welcome format)
        if (name.includes("::")) {
            const [module, page] = name.split("::");
            const path = `/modules/${module}/Resources/js/Pages/${page}.vue`;

            if (modulePages[path]) {
                const component = await modulePages[path]();
                return component;
            }

            console.error("Available module pages:", Object.keys(modulePages));
            throw new Error(`Module page not found: ${path}`);
        }

        throw new Error(`Page not found: ${name}`);
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: { color: "#4B5563" },
});
