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
import { routes } from './routes';
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
axios.defaults.baseURL = 'http://127.0.0.1:8000';
Vue.use(VueAxios, axios);
Vue.use(Vuex);
const store = new Vuex.Store({
    state: {
        user:null,
        auth:false,
        isUserLoggedIn: false
    },
    mutations: {
        SET_USER(state,user){
            state.user = user
            state.auth = Boolean(user)
            state.isUserLoggedIn = Boolean(user)
        }
    },
    actions:{
        async login({dispatch},credentials){
            await axios.post('/login', credentials);
            return dispatch("getUser");
        },
        async logout({ dispatch }) {
            await axios.post('/logout');
            return dispatch("getUser");
        },
        getUser({commit}){
            axios.get('/api/user').then(res => {
                console.log(res.data);
                commit("SET_USER",res.data);

            }).catch(() => {
                commit("SET_USER", null);


            });
        }

    },
    modules:{}
})
Vue.use(VCalendar, {
    componentPrefix: 'vc',
});
Vue.component('input-tag', InputTag);
store.dispatch('getUser')

const router = new VueRouter({
    mode: 'history',
    routes: routes
});
/* router.beforeEach((to, from, next) => {
    if (to.name !== 'login' && !store.state.isUserLoggedIn) next({ name: 'login' })
    else next()
}) */
const app = new Vue({
    el: '#app',
    router: router,
    store:store,
    vuetify,
    render: h => h(App),
});


