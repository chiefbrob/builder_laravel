import { createStore as _createStore } from 'vuex';
// import actions from './actions'
// import mutations from './mutations'
// import getters from './getters'

export function createStore(router) {
  return _createStore({
    state: {
      get route() {
        return router.currentRoute.value;
      },
      activeType: null,
      itemsPerPage: 20,
      items: {
        /* [id: number]: Item */
      },
      users: {
        /* [id: string]: User */
      },
      lists: {
        top: [
          /* number */
        ],
        new: [],
        show: [],
        ask: [],
        job: [],
      },
    },
    // actions,
    // mutations,
    // getters
  });
}

// import Vue from 'vue';
// import Vuex from 'vuex';
// import shop from './shop/shop-store.js';

// Vue.use(Vuex);

// const debug = process.env.NODE_ENV !== 'production';

// export default new Vuex.Store({
//   modules: {
//     shop,
//   },
//   strict: debug,
//   state: {
//     user: null,
//     loading: false,
//     config: {
//       name: 'BuilderLaravel',
//       url: process.env.APP_URL,
//     },
//   },
//   getters: {
//     user: (state) => {
//       return state.user;
//     },
//     loading: (state) => {
//       return state.loading;
//     },
//     config: (state) => {
//       return state.config;
//     },
//     avatarUrl: (state) => {
//       return state.user?.photo
//         ? '/storage/images/profile/' + state.user.photo
//         : '/images/avatar.png';
//     },
//   },
//   mutations: {
//     loading(state, loading) {
//       state.loading = loading;
//     },
//     user(state, user) {
//       state.user = user;
//     },
//     config(state, config) {
//       state.config = {
//         ...state.state,
//         ...config,
//       };
//     },
//   },
// });
