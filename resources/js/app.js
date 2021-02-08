require('./bootstrap');

require('moment');

import Vue from 'vue';
import Vuex from 'vuex'
import searchPlugin from 'vuex-search';
import state from './store/state';
import actions from './store/actions';
import mutations from './store/mutations';
import getters from './store/getters';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';

//import { plugin } from '@inertiajs/inertia-vue'
//Vue.use(plugin);

import PortalVue from 'portal-vue';
import VueRx from 'vue-rx'
import Chat from 'vue-beautiful-chat'
Vue.use(Chat)
Vue.use(VueRx);

Vue.mixin({ methods: { route } });
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(Vuex);
Vue.use(PortalVue);
// Reuire all vue components
const req = require.context('./components/', false, /\.(vue)$/i)
for (const key of req.keys()) {
    const name = key.match(/\w+/)[0];//![0]
    Vue.component(name, req(key).default);
}



//const app = document.getElementById('app');

const store = new Vuex.Store({
    state,
    mutations,
    actions,
    getters,
    plugins: [
        searchPlugin({
            resources: {
                Products: {
                    // what fields to index
                    index: ['name', 'data', 'description'],
                    // access the state to be watched by Vuex Search
                    getter: (state) => state.PublishedProduct.data,
                    // how resource should be watched
                    watch: { delay: 500 },
                },
                // otherResource: { index, getter, watch, searchApi },
            },
        }),
    ],
})


new Vue({
    store,
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount('#app');
