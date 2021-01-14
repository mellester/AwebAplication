require('./bootstrap');

require('moment');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';

Vue.mixin({ methods: { route } });
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
// Reuire all vue components
const req = require.context('./components/', false, /\.(vue)$/i)
for (const key of req.keys()) {
  const name = key.match(/\w+/)[0];//![0]
  Vue.component(name, req(key).default);
} 

//const app = document.getElementById('app');


new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount('#app');
