module.exports = {
  computed: {},
  methods: {
    //route: window.route,

    $get(...args) {
      return _.get(...args);
    },
    $has(...args) {
      return _.has(...args);
    },
    $featureIsEnabled(name) {
      return _.get(window.feature_flags, name, false) === true;
    },

    $dateFormat(date) {
      return moment(date).format('YYYY-MM-DD, H:mm');
    },
    $validEmail(email) {
      var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
    $dollarStrToNum(string) {
      return Number(string.replace(/[^0-9.-]+/g, ''));
    },
    $slugify(string) {
      var slugify = require('slugify');
      return slugify(string, {
        replacement: '-', // replace spaces with replacement character, defaults to `-`
        remove: undefined, // remove characters that match regex, defaults to `undefined`
        lower: true, // convert to lower case, defaults to `false`
        strict: true, // strip special characters except replacement, defaults to `false`
        locale: 'en', // language code of the locale to use
        trim: true, // trim leading and trailing replacement chars, defaults to `true`
      });
    },
  },
};
