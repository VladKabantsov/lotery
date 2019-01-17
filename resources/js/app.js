import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuetify from 'vuetify';
import store from './store/index';
import 'vuetify/dist/vuetify.min.css'
import '../style/app.styl';

Vue.use(Vuetify);
Vue.use(VueRouter);

import App from './pages/App';
import Home from './pages/Home';
import Cabinet from './pages/Cabinet';
import Room from './pages/Room';
import AddMoney from './pages/AddMoney';
import SendMoney from './pages/SendMoney';
import SignIn from './pages/SignIn';
import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');
window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
});

const ifNotAuthenticated = (to, from, next) => {
    if (localStorage.getItem('user-info') == null) {
        next()
        return;
    }
    next('/')
}

const ifAuthenticated = (to, from, next) => {
    if (localStorage.getItem('user-info') !== null) {
        next()
        return;
    }
    next('/cabinet')
}
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/cabinet',
            name: 'cabinet',
            component: Cabinet,
            // beforeEnter: ifAuthenticated,
        },
        {
            path: '/room',
            name: 'room',
            component: Room,
            // beforeEnter: ifAuthenticated,
        },
        {
            path: '/payment',
            name: 'balance',
            component: AddMoney
        },
        {
            path: '/received-of-funds',
            name: 'room',
            component: SendMoney
        },
        {
            path: '/signin',
            name: 'signin',
            component: SignIn
        },
        {
            path: '*',
            name: 'any',
            redirect: to => {
                if (to.path === '/login/vk/user' || to.path === '/login/ok/user') {
                    return 'cabinet';
                } else {
                    return 'home';
                }
            }
        }
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store
});
