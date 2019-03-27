import './bootstrap';
import Vue from 'vue';
import VueRouter from "vue-router";
import Routes from './routes';
import store from './vuex/store'
import storeActions from './vuex/actions'
import {mapActions} from "vuex";

//const files = require.context('./components', true, /\.vue$/i);
//files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)));

const router = new VueRouter({
    mode: 'history',
    base: '/' + window.Laracraft.path + '/',
    routes: Routes
});

if(document.getElementById('laracraft')){
    new Vue({
        el: '#laracraft',
        router,
        store,

        created(){
            this.loadThemes();
            this.loadBlocks();
            this.loadComponents();
        },

        computed: {

        },

        methods: {
            ...mapActions({
                loadThemes: storeActions.theme.INDEX,
                loadBlocks: storeActions.block.INDEX,
                loadComponents: storeActions.component.INDEX
            })
        },
    })
}