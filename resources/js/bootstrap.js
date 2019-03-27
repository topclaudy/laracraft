import Vue from 'vue';
import Router from 'vue-router';
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en';
import axios from 'axios'
import VueAxios from 'vue-axios'
import vuejsStorage from 'vuejs-storage'
import VueBus from 'vue-bus';
import PortalVue from 'portal-vue';
import UI from './plugins/UI'


/**
 * Axios setup
 */

let csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

axios.interceptors.request.use(function(config){
    config.headers['X-CSRF-TOKEN'] = csrfToken;
    config.headers['Accept'] = 'application/json';
    config.headers['Content-Type'] = 'application/json';
    config.headers['X-Requested-With'] = 'XMLHttpRequest';

    return config;
});


/**
 * Attach Vue plugins
 */
Vue.use(Router);
Vue.use(PortalVue);
Vue.use(vuejsStorage);
Vue.use(ElementUI, {locale});
Vue.use(VueAxios, axios);
Vue.use(VueBus);
Vue.use(UI);


