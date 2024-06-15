import URI from 'urijs';
window.URI = URI;
import _ from 'lodash';
window._ = _;
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import moment from 'moment';
window.moment = moment;

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.moment.locale('en');

window.axios.interceptors.response.use(
  function(response) {
    return response;
  },
  function(error) {
    switch (error?.response?.status) {
      case 401:
        window.axios.get('/logout');
        $('#modal-session-expired').modal('show');
        break;
    }

    return Promise.reject(error);
  },
);
