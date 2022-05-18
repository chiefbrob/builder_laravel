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
  },
};
