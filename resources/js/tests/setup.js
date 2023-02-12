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

import VuePhoneNumberInput from 'vue-phone-number-input';
//import 'vue-phone-number-input/dist/vue-phone-number-input.css';

Vue.component('vue-phone-number-input', VuePhoneNumberInput);

window.details = {
  name: 'BuilderLaravel',
  description: 'A foo app',
};
