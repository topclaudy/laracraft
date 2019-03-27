import storeActions from '../actions';
import axios from 'axios';

const state = {
    current: null,
    items: [],
    loading: false,
};

const mutations = {
    [storeActions.component.INDEX] (state, components) {
        state.items = components
    },

    [storeActions.component.GET] (state, component) {
        state.current = component
    },

    [storeActions.component.LOADING] (state, loading) {
        state.loading = loading
    },
};

const actions = {
    [storeActions.component.INDEX] ({commit}) {
        commit(storeActions.component.LOADING, true);

        return new Promise((resolve, reject) => {
            axios.get(route('laracraft.api.component.index')).then((response) => {
                commit(storeActions.component.LOADING, false);
                commit(storeActions.component.INDEX, response.data);
                resolve(response);
            }, (response) => {
                reject(response);
            });
        });
    },

    [storeActions.component.GET] ({commit}, id) {
        return new Promise((resolve, reject) => {
            axios.get(route('laracraft.api.component.get'), {component: id}).then((response) => {
                commit(storeActions.component.GET, response.data);
                commit(storeActions.component.PUT, response.data);
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
