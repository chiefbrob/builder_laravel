import Vue from 'vue';
import VueRouter from 'vue-router';
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';
import '../sass/main.scss';
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
import routes from './router/routes';
import store from './store';

window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.moment = require('moment');

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.component('nav-root', require('./components/nav/NavRoot').default);

Vue.use(VueRouter);

require('./filters');

const originalPush = VueRouter.prototype.push;
VueRouter.prototype.push = function push(location) {
  return originalPush.call(this, location).catch(err => {
    if (err.name !== 'NavigationDuplicated') throw err;
  });
};

let router = new VueRouter(routes);

router.beforeEach((to, from, next) => {
  let beforeLoginRequest = localStorage.getItem('to');
  if (beforeLoginRequest) {
    localStorage.removeItem('to');
    next(JSON.parse(beforeLoginRequest));
  }
  const auth = to.matched[0].meta;
  if (auth?.requiresAuth === true) {
    if (!window.User) {
      localStorage.setItem('to', JSON.stringify(to));
      window.location = '/login';
      next();
    } else {
      next();
    }
  } else {
    next();
  }
});

const app = new Vue({
  el: '#app',
  router: router,
  store,
  created() {
    if (window.User) {
      this.$store.commit('user', window.User);
    }
  },
});
