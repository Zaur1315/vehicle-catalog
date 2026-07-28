import '../css/app.css';

import {createInertiaApp} from '@inertiajs/vue3';
import {createApp, h} from 'vue';

const appName = import.meta.env.VITE_APP_NAME || 'Kohl Auto Sales';

createInertiaApp({
    title: (title) => title ? `${title} | ${appName}` : appName,
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', {eager: true});

        return pages[`./Pages/${name}.vue`];
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .mount(el);
    },
});
