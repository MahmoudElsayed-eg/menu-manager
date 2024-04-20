import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { InertiaProgress } from "@inertiajs/progress";
import MenuLayout from '@/Layouts/MenuLayout.vue'
import AdminLayout from "@/Layouts/AdminLayout.vue";

InertiaProgress.init({
    delay: 0,
    color: "#29d",
    includeCSS: true,
    showSpinner: true,
});
createInertiaApp({
    title: (title) => `${title}`,
    resolve: async (name) => {
        const page = await resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        );
        page.default.layout = name.startsWith("Admin/")
            ? page.default.layout || AdminLayout
            : page.default.layout || MenuLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    // progress: {
    //   color: '#4B5563',
    // },
}).then(() => {
    document.getElementById("init_page").style.display = "none";
});
