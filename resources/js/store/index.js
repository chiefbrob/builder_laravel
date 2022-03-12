import Vue from 'vue';
import Vuex from 'vuex';
// import getAQuote from './get-a-quote/quote-store.js';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
  modules: {
    // getAQuote,
  },
  strict: debug,
  state: {
    user: null,
    loading: false,
    config: {
      name: 'Template',
      url: process.env.APP_URL,
    },
  },
  getters: {
    user: state => {
      return state.user;
    },
    loading: state => {
      return state.loading;
    },
    config: state => {
      return state.config;
    },
  },
  mutations: {
    loading(state, loading) {
      state.loading = loading;
    },
    user(state, user) {
      state.user = user;
    },
    config(state, config) {
      state.user = {
        ...state.user,
        ...config,
      };
    },
  },
});
