import storeActions from '../actions';
import axios from 'axios';
import {findIndex} from "lodash";

const state = {
    current: null,
    items: [],
    loading: false,

    getters: {
        getById: (id) => {
            return state.items.find(item => item.id === id)
        },

        getRegionById: (themeId, id) => {
            let theme = state.items.find(item => item.id === themeId);

            if(theme){
                return theme.regions.find(item => item.id === id)
            }

            return null;
        }
    }
};

const mutations = {
    [storeActions.theme.INDEX] (state, themes) {
        state.items = themes
    },

    [storeActions.theme.GET] (state, theme) {
        state.current = theme
    },

    [storeActions.theme.PUT] (state, theme) {
        if(state.items) {
            const index = findIndex(state.items, {id: theme.id});

            if (index !== -1) {
                state.items.splice(index, 1, theme);
            }
        }
    },

    [storeActions.theme.LOADING] (state, loading) {
        state.loading = loading
    },
};

const actions = {
    [storeActions.theme.INDEX] ({commit}) {
        commit(storeActions.theme.LOADING, true);

        return new Promise((resolve, reject) => {
            axios.get(route('laracraft.api.theme.index')).then((response) => {
                commit(storeActions.theme.LOADING, false);
                commit(storeActions.theme.INDEX, response.data);
                resolve(response);
            }, (response) => {
                reject(response);
            });
        });
    },

    [storeActions.theme.GET] ({commit}, id) {
        return new Promise((resolve, reject) => {
            axios.get(route('laracraft.api.theme.get', {theme: id})).then((response) => {
                commit(storeActions.theme.GET, response.data);
                commit(storeActions.theme.PUT, response.data);
                resolve(response);
            }, (response) => {
                reject(response);
            });
        });
    },

    [storeActions.theme.CONFIGURE] ({commit}, theme) {
        return new Promise((resolve, reject) => {
            axios.post(route('laracraft.api.theme.configure', {theme: theme.id}), theme).then((response) => {
                commit(storeActions.theme.PUT, response.data);
                resolve(response);
            }, (response) => {
                reject(response);
            });
        });
    }
};

export default {
    state,
    mutations,
    actions
}
