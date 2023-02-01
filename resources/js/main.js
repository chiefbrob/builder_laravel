import { createApp, configureCompat } from 'vue';
import Multiselect from 'vue-multiselect';
import _ from 'lodash';

import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({
  components,
  directives,
});

// configureCompat({
//   MODE: 3,
// });

import { createRouter } from './router';
const router = createRouter();

import { createStore } from './store';
const store = createStore(router);

// import '../sass/main.scss';

// import store from './store';
// import './spark-bootstrap.js';
import VueClipboard from 'vue3-clipboard';
// VueClipboard.config.autoSetContainer = true;
// Vue.use(VueClipboard);

// require('./filters');

// Vue.mixin(require('./mixin'));

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

const app = createApp({});

// // app.use(store);

app.use(VueClipboard);

// import { shared } from './components/shared/index.js';

// shared.forEach((item) => {
//   app.component(item.name, require('./components/shared/' + item.path).default);
// });

app.component('multiselect', Multiselect);

app.component('nav-root', require('./components/nav/NavRoot').default);

app.component('avatar', require('./components/home/ProfileImage').default);

app.use(router);
app.use(store);
app.use(vuetify);

app.mount('#app');

window.Vue = app;
window.Bus = createApp({});
// window._ = require('lodash');

export default app;
