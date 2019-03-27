import storeActions from '../actions';
import axios from 'axios';
import {findIndex} from 'lodash'

const state = {
    current: null,
    items: [],
    loading: false,

    getters: {
        getById: (id) => {
            return state.items.find(item => item.id === id)
        }
    }
};

const mutations = {
    [storeActions.block.INDEX] (state, blocks) {
        state.items = blocks
    },

    [storeActions.block.GET] (state, block) {
        state.current = block
    },

    [storeActions.block.POST] (state, block) {
        state.items.push(block)
    },

    [storeActions.block.PUT] (state, block) {
        if(state.items) {
            const index = findIndex(state.items, {id: block.id});

            if (index !== -1) {
                state.items.splice(index, 1, block);
            }
        }
    },

    [storeActions.block.DELETE] (state, block) {
        if(state.items) {
            const index = findIndex(state.items, {id: block.id});

            if (index !== -1) {
                state.items.splice(index, 1);
            }
        }
    },

    [storeActions.block.LOADING] (state, loading) {
        state.loading = loading
    },
};

const actions = {
    [storeActions.block.INDEX] ({commit}) {
        commit(storeActions.block.LOADING, true);

        return new Promise((resolve, reject) => {
            axios.get(route('laracraft.api.block.index')).then((response) => {
                commit(storeActions.block.LOADING, false);
                commit(storeActions.block.INDEX, response.data);
                resolve(response);
            }, (response) => {
                reject(response);
            });
        });
    },

    [storeActions.block.GET] ({commit}, id) {
        return new Promise((resolve, reject) => {
            axios.get(route('laracraft.api.block.get', {block: id})).then((response) => {
                commit(storeActions.block.GET, response.data);
                commit(storeActions.block.PUT, response.data);
                resolve(response);
            }, (response) => {
                reject(response);
            });
        });
    },

    [storeActions.block.POST] ({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios.post(route('laracraft.api.block.post'), payload).then((response) => {
                commit(storeActions.block.POST, response.data);
                resolve(response);
            }, (response) => {
                reject(response);
            });
        });
    },

    [storeActions.block.PUT] ({commit}, block) {
        return new Promise((resolve, reject) => {
            axios.put(route('laracraft.api.block.put', {block: block.id}), block).then((response) => {
                commit(storeActions.block.PUT, response.data);
                resolve(response);
            }, (response) => {
                reject(response);
            });
        });
    },

    [storeActions.block.DELETE] ({commit}, block) {
        return new Promise((resolve, reject) => {
            axios.delete(route('laracraft.api.block.delete', {block: block.id})).then((response) => {
                commit(storeActions.block.DELETE, response.data);
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
