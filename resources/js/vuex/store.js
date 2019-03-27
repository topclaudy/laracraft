import Vue from 'vue';
import Vuex from 'vuex';

import themeModule from './modules/theme';
import blockModule from './modules/block';
import componentModule from './modules/component';

Vue.use(Vuex);
Vue.config.debug = true;

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    strict: debug,

    modules: {
        themeModule,
        blockModule,
        componentModule
    }
})
