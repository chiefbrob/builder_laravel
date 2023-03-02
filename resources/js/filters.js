import Vue from 'vue';
import kebabCase from 'lodash/kebabCase';
import capitalize from 'lodash/capitalize';

var numeral = require('numeral');
/**
 * Format the given date.
 */
Vue.filter('date', value => {
  return moment
    .utc(value)
    .local()
    .format('MMMM Do, YYYY');
});

Vue.filter('badgeName', value => {
  return kebabCase(value)
    .split('-')
    .join(' ');
});

/**
 * Format the given date as a timestamp.
 */
Vue.filter('datetime', value => {
  return moment
    .utc(value)
    .local()
    .format('MMMM Do, YYYY h:mm A');
});

Vue.filter('shortform', value => {
  let len = 14;
  if (value.length > len) {
    return value.substr(0, len) + '...';
  }
  return value;
});

/**
 * Format the given date into a relative time.
 */
Vue.filter('relative', (value, format = 'en-short') => {
  return value
    ? moment
        .utc(value)
        .local()
        .locale(format)
        .fromNow()
    : value;
});

Vue.filter('readableDate', date => {
  return date ? moment(date).fromNow() : '';
});
/**
 * Convert the first character to upper case.
 *
 * Source: https://github.com/vuejs/vue/blob/1.0/src/filters/index.js#L37
 */
Vue.filter('capitalize', capitalize);

Vue.filter('capitalizeAll', value => {
  if (!value && value !== 0) {
    return '';
  }

  return value.replace(/\b\w/g, function(l) {
    return l.toUpperCase();
  });
});

Vue.filter('line_breaks', value => {
  if (value == undefined) {
    return '';
  }
  return value.replace('\n', '<br>');
});

/**
 * Format the given money value.
 *
 * Source: https://github.com/vuejs/vue/blob/1.0/src/filters/index.js#L70
 */
Vue.filter('currency', (value, float = true) => {
  let format = '$0,0.00';
  if (!float) {
    format = '$0,0';
  }
  return numeral(value).format(format);
});

Vue.filter('formatDate', function(value, args = 'MM-DD-YYYY') {
  if (value) {
    return moment(String(value)).format(args);
  }
});

Vue.filter('capitalize', function(value) {
  if (!value) {
    return '';
  }
  value = value.toString();
  return value.charAt(0).toUpperCase() + value.slice(1);
});

Vue.filter('failed', function(value) {
  let results = 'Still Running';

  if (value == 1) {
    results = 'Failed';
  } else if (value == 0) {
    results = 'Passed';
  }

  return results;
});

Vue.filter('dotNegative', function(value) {
  if (value) {
    return value == 1 || value == true ? 'dot red' : 'dot';
  }
  return 'dot';
});

Vue.filter('running', function(value) {
  if (value == 'success') {
    return 'dot';
  } else if (value == 'running') {
    return 'dot orange';
  } else {
    return 'dot red';
  }
});

Vue.filter('dotPositive', function(value) {
  if (value) {
    return value == 1 || value == true ? 'dot' : 'dot red';
  }
  return 'dot red';
});

Vue.filter('language_icon', function(value) {
  if (value === 'js') {
    return '<i class="devicon-javascript-plain"></i>';
  }

  return '<i class="devicon-' + value + '-plain"></i>';
});

Vue.filter('yesNo', function(value) {
  if (value) {
    return value == 1 ? 'Yes' : 'No';
  }
  return 'No';
});

Vue.filter('truncate', function(text, stop, clamp) {
  if (typeof stop == 'undefined') {
    stop = 30;
  }
  return text.slice(0, stop) + (stop < text.length ? clamp || '...' : '');
  //return text.slice(0, 30) + '....'
});

Vue.filter('strLimit', (value, length = 25, end = '...') => {
  if (String(value).length <= length) {
    return value;
  }
  return `${String(value).substr(0, length)} ${end}`;
});

Vue.filter('integer', function(value) {
  return Number.parseInt(value);
});

Vue.filter('formatNumber', function(value) {
  return numeral(value).format('0,0');
});

Vue.filter('formatDateTime', (date, defaultValue = null) => {
  if (!date) {
    return defaultValue;
  }
  return moment(date).format('YYYY-MM-DD, h:mm:ss a');
});
