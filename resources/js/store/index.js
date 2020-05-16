import Vuex from 'vuex';
import Vue from 'vue';
import axios from 'axios';

import auth from './modules/auth';

axios.defaults.baseURL = process.env.APP_URL;

//load Vuex
Vue.use(Vuex);

//create store
export default new Vuex.Store({
    modules: {
        auth
    }

});