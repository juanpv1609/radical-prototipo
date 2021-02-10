// import bearer from '@websanova/vue-auth/dist/drivers/auth/bearer'
// import axios from '@websanova/vue-auth/dist/drivers/http/axios.1.x'
// import router from '@websanova/vue-auth/dist/drivers/router/vue-router.2.x'
import Vue from 'vue';
import bearer from '@websanova/vue-auth/dist/drivers/auth/bearer'
import axios from '@websanova/vue-auth/dist/drivers/http/axios.1.x'
import router from '@websanova/vue-auth/dist/drivers/router/vue-router.2.x'
// Auth base configuration some of this options
// can be override in method calls
const config = {
    plugins:{
        http: Vue.axios,
        router: Vue.router,
    },
    drivers:{
        auth: bearer,
        http: axios,
        router: router
    },
    options:{
        tokenDefaultName: 'laravel-vue-spa',
        tokenStore: ['localStorage'],
        rolesVar: 'role',
        registerData: { url: 'auth/register', method: 'POST', redirect: '/login' },
        loginData: { url: 'auth/login', method: 'POST', redirect: '', fetchUser: true },
        logoutData: { url: 'auth/logout', method: 'POST', redirect: '/', makeRequest: true },
        fetchData: { url: 'auth/user', method: 'GET', enabled: true },
        refreshData: { url: 'auth/refresh', method: 'GET', enabled: true, interval: 30 }
    }


}
export default config
