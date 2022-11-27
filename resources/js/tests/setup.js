import Vue from 'vue';
import lodash from 'lodash';
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';
import VueClipboard from 'vue-clipboard2';

Vue.use(VueClipboard);
global._ = lodash;

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
Vue.mixin(require('@/mixin'));
require('@/components');
