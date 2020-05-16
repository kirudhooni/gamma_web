/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap.js');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import VueRouter from 'vue-router'
import store from './store';
import axios from 'axios';
import Login from './views/Login'
import Home from './views/Home.vue'
import DetailedData from './views/DetailedData.vue'
import App from './views/App.vue'
import {initialize} from './helpers/general';
import LineChart from "./components/LineChart";

Vue.use(VueRouter)

axios.defaults.withCredentials = true;

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'loginpage',
            component: Login
        },
        {
            path: '/home',
            name: 'home',
            component: Home,
            meta:{
                requiresAuth: true
            }
        },
        {
            path: '/detailed-data/:filename',
            name: 'detailed-data',
            component: DetailedData,
            meta:{
                requiresAuth: true
            }
        }

    ],
});

initialize(store,router);

const app = new Vue({
    el: '#app',
    store,
    components: { 
        App,
        LineChart,
    },
    router,
});
