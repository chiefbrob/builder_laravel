import Vue from 'vue';
import Multiselect from 'vue-multiselect';

Vue.component('clipboard', require('./components/shared/ClipBoard').default);

Vue.component('multiselect', Multiselect);

Vue.component('nav-root', require('./components/nav/NavRoot').default);

Vue.component('file-uploader', require('./components/shared/FileUploader').default);

Vue.component('field-error', require('./components/shared/FieldError').default);

Vue.component('avatar', require('./components/home/ProfileImage').default);

Vue.component('page-footer', require('./components/shared/Footer').default);

Vue.component('phone-number', require('./components/shared/PhoneNumber').default);
