require('./bootstrap');

require('moment');

import Vue from 'vue';
import Vuex from 'vuex'
import searchPlugin from 'vuex-search';
import state from './store/state';
import actions from './store/actions';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import VueRx from 'vue-rx'

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
    mutations: {
        sendingRequest(state, boolean) {
            state.sendingRequest = boolean;
        },
        /**
         * 
         * @param {String} key The key in the store to set 
         * @param {Object} payload 
         * @param {string} payload.key - The key in the store 
         * @param {Object} payload.data - The Paginate Info
         */
        setInitState(state, payload) {
            // debugger;
            const key = payload.key;
            if (state[key] == null) {
                state[key] = payload.data.data;
            }
            else {
                payload.data.data.forEach(element => {
                    let index = state[key].findIndex((value => value.id == element.id))
                    if (index == -1)
                        state[key].push(element);
                    else {
                        state[key][index] = (element);
                    }
                });
            }
            state[key + 'Api'] = payload.data;
        },
    },
    actions,
    plugins: [
        searchPlugin({
            resources: {
                Products: {
                    // what fields to index
                    index: ['name', 'data', 'description'],
                    // access the state to be watched by Vuex Search
                    getter: (state) => state.PublishedProduct,
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
