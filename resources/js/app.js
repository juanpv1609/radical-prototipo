/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//window.Vue = require('vue');
import Vue from 'vue';
import vuetify from './src/plugins/vuetify' // path to vuetify export
import Vuex from 'vuex';
import 'es6-promise/auto';
window.Vue = Vue;
import App from './App.vue';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import axios from 'axios';
import store from './store/store';
import { routes } from './router/routes';
import VCalendar from 'v-calendar';
// import Multiselect from 'vue-multiselect'
import InputTag from 'vue-input-tag'
import Toasted from 'vue-toasted';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
let options = {
    theme: 'bubble',
    duration: 2000,
    //iconPack: 'fontawesome'
};
Vue.use(VueSweetalert2);
Vue.use(Toasted, options)
// Vue.component('multiselect', Multiselect)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(VueRouter);
//Vue.use(Swal);
axios.defaults.withCredentials = true;
//axios.defaults.baseURL = 'http://127.0.0.1:8000';
axios.defaults.baseURL = process.env.MIX_APP_URL;
//axios.defaults.baseURL = 'http://10.1.1.130';
Vue.use(VueAxios, axios);
Vue.use(Vuex);



Vue.use(VCalendar, {
    componentPrefix: 'vc',
});
Vue.component('input-tag', InputTag);

export const bus = new Vue()
const router = new VueRouter({
    mode: 'history',
    routes: routes
});
store.dispatch('getUser')
router.beforeEach((to, from, next) => {

    if (  to.matched.some(record => record.meta.requiresAuth)) {
    //store.dispatch('getUser')

        if ( store.getters.loggedIn) {
            next()
            return
        }
        next('/login')
    } else {
        next()
    }
})



const app = new Vue({
    el: '#app',
    router:router,
    store:store,
    vuetify,
    render: h => h(App),
});


