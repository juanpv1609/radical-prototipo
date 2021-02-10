
import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
Vue.use(VueAxios, axios);
Vue.use(Vuex);

export const store = new Vuex.Store
({
    state: {
        user: null,
        auth: false
    },
    mutations: {
        SET_USER(state, user) {
            state.user = user
            state.auth = Boolean(user);
        }
    },
    actions: {
        async login({ dispatch }, credentials) {
            await axios.post('/login', credentials);
            return dispatch("getUser");
        },
        getUser({ commit }) {
            axios.get('/api/user').then(res => {
                commit("SET_USER", res.data);
            }).catch(() => {
                commit("SET_USER", null);

            });
        }

    },
    modules: {}
})
