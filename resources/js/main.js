import Vue from 'vue';
import VueRouter from 'vue-router';
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';
import '../sass/main.scss';
import Multiselect from 'vue-multiselect';
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
import routes from './router/routes';
import store from './store';
import './spark-bootstrap.js';
import VueClipboard from 'vue-clipboard2';
VueClipboard.config.autoSetContainer = true;
Vue.use(VueClipboard);

Vue.component('clipboard', require('./components/shared/ClipBoard').default);

Vue.component('multiselect', Multiselect);

Vue.component('nav-root', require('./components/nav/NavRoot').default);

Vue.component('file-uploader', require('./components/shared/FileUploader').default);

Vue.component('field-error', require('./components/shared/FieldError').default);

Vue.component('avatar', require('./components/home/ProfileImage').default);

Vue.component('page-footer', require('./components/shared/Footer').default);

Vue.use(VueRouter);

require('./filters');

Vue.mixin(require('./mixin'));

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
      window.location = '/login';
    }
  } else if (auth?.requiresAuth !== true) {
    next();
  } else {
    if (window.User) {
      next();
    } else {
      window.location = '/login';
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
