<template>
  <div class="container">
    <div class="row py-5  mb-5">
      <b-card class="col-md-8 offset-md-2" title="Settings">
        <b-tabs pills card vertical nav-wrapper-class="w-50">
          <b-tab title="Your Account" active
            ><b-card-text> <account-settings></account-settings> </b-card-text
          ></b-tab>
          <b-tab v-if="false" title="Security and account access"
            ><b-card-text>Security and account access</b-card-text></b-tab
          >
          <b-tab title="Privacy and Safety"
            ><b-card-text
              ><b-list-group flush v-if="!option">
                <b-list-group-item
                  v-for="option in availableOptions"
                  v-bind:key="option.link"
                  class="options"
                  @click="optionSelected(option)"
                  ><i class="fa " :class="option.icon"></i> {{ option.name }}
                </b-list-group-item>
              </b-list-group></b-card-text
            ></b-tab
          >
        </b-tabs>
      </b-card>
    </div>
  </div>
</template>

<script>
  import AccountSettings from './settings/AccountSettings.vue';
  export default {
    components: {
      AccountSettings,
    },
    data() {
      return {
        option: null,
        options: [
          {
            name: 'Privacy Policy',
            link: 'privacy-policy',
            icon: 'fa-lock',
            enabled: true,
          },
          {
            name: 'Terms and Conditions',
            link: 'terms',
            icon: 'fa-gavel',
            enabled: true,
          },
        ],
      };
    },
    computed: {
      availableOptions() {
        return this.options.filter(option => option.enabled === true);
      },
    },
    methods: {
      optionSelected(option) {
        this.$router.push({ name: option.link });
        this.option = option;
      },
    },
  };
</script>
