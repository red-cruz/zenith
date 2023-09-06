// Vuetify
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import "./config/vts.config";
import Auth from "./Layouts/AuthLayout.vue";
import Layout from "./Layouts/HomeLayout.vue";

const vuetify = createVuetify({
    components,
    directives,
});
createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = name.startsWith("Auth/") ? Auth : Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .mount(el);
    },
});
