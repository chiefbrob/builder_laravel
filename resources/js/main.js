import Vue from 'vue';
import VueRouter from 'vue-router';
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';
import '../sass/main.scss';

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
import routes from './router/routes';
import store from './store';
import './spark-bootstrap.js';
import VueClipboard from 'vue-clipboard2';
VueClipboard.config.autoSetContainer = true;
Vue.use(VueClipboard);

Vue.use(VueRouter);

require('./filters');

Vue.mixin(require('./mixin'));

require('./components');

import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';

Vue.component('vue-phone-number-input', VuePhoneNumberInput);

const originalPush = VueRouter.prototype.push;
VueRouter.prototype.push = function push(location) {
  return originalPush.call(this, location).catch(err => {
    if (err.name === 'NavigationDuplicated') {
    } else {
      console.log(err.includes('navigation guard'));
      throw err;
    }
  });
};

let router = new VueRouter(routes);

router.beforeEach((to, from, next) => {
  const auth = to.matched[0].meta;
  if (auth?.requiresAdmin === true) {
    if (window.User) {
      if (window.User.admin) {
        next();
      } else {
        next({ name: 'welcome' });
      }
    } else {
      next({ name: 'login' });
    }
  } else if (auth?.requiresAuth !== true) {
    next();
  } else {
    if (window.User) {
      next();
    } else {
      next({ name: 'login' });
    }
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

window.Vue = app;
window.Bus = new Vue();
