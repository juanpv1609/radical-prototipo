
import Vue from 'vue';
import Vuex from 'vuex';
import VueAxios from 'vue-axios';
import axios from 'axios';
import createPersistedState from 'vuex-persistedstate';
axios.defaults.withCredentials = true;
//axios.defaults.baseURL = 'http://127.0.0.1:8000';
axios.defaults.baseURL = process.env.MIX_APP_URL;
Vue.use(VueAxios, axios);
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        user:null,
        auth:false,
        isUserLoggedIn: false
    },
    plugins: [createPersistedState()],
    getters:{
        loggedIn: state => !!state.user
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
            await axios.post('/api/login', credentials);
            return dispatch("getUser");
        },
        async logout({ dispatch }) {
            await axios.post('/api/logout');
            return dispatch("getUser");
        },
        getUser({commit}){
            axios.get('/api/user').then(res => {
                //console.log(res.data);
                commit("SET_USER",res.data);

            }).catch(() => {

                commit("SET_USER", null);

            });
        }

    },
    modules:{}
})
store.dispatch('getUser')

export default store
