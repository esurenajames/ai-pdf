import './bootstrap';
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp, Link, Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { InertiaApp } from '@inertiajs/inertia-vue3';
import { createPinia } from 'pinia';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { useThemeStore } from './Stores/Theme';
import DefaultLayout from './Layouts/DefaultLayout.vue';

// Create Pinia instance
const pinia = createPinia();
createInertiaApp({
  title: (title) => `${title} Ai PDF`,
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    const page = pages[`./Pages/${name}.vue`];
    
    // If the page does not have a layout, use DefaultLayout
    if (page) {
      page.default.layout = page.default.layout || DefaultLayout;
      return page.default;
    } else {
      throw new Error(`Page component for ${name} not found`);
    }
  },

  setup({ el, App, props, plugin }) {
    const app = createApp({
      render: () => h(App, { ...props }),
    });

    app.use(pinia);
    const themeStore = useThemeStore();
    themeStore.applyThemeToBody();

    app.use(plugin);
    app.use(ZiggyVue);

    app.component('Link', Link);
    app.component('Head', Head);

    app.mount(el);
  },
});
