import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';
import axios from 'axios'
import {SERVER_URI} from './constants'
import '@mdi/font/css/materialdesignicons.css'
require('./assets/flash-message.css');
import Vuelidate from 'vuelidate'
import VueFlashMessage from 'vue-flash-message';
import money from 'v-money'
import VueMask from 'v-mask'
import '@fortawesome/fontawesome-free/css/all.css'

import VueClipboard from 'vue-clipboard2'

VueClipboard.config.autoSetContainer = true;

Vue.use(VueClipboard);
Vue.use(VueMask);
Vue.use(money);
Vue.use(VueFlashMessage);
Vue.use(Vuelidate);


Vue.config.productionTip = false;
Vue.prototype.$http = axios;
Vue.prototype.$url = SERVER_URI;

axios.interceptors.request.use(
    config => {
        store.commit('setRequest', true);
        let token = localStorage.getItem("token");
        if(token){
            config.headers.authorization = "Bearer " + token;
        }
        return config;
    },
    error => {
        store.commit('setRequest', false);
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    config => {
        store.commit('setRequest', false);
        return config;
    },
    function(error) {
        store.commit('setRequest', false);
        return Promise.reject(error);
    }
);

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app');
// Vue.use(vuetify);
