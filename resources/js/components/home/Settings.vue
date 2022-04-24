<template>
  <div>
    <nav-root></nav-root>

    <div class="row py-4">
      <b-card class="col-md-8 offset-md-2" title="Settings">
        <b-tabs pills card vertical nav-wrapper-class="w-50">
          <b-tab title="Your Account" active
            ><b-card-text> <account-settings></account-settings> </b-card-text
          ></b-tab>
          <b-tab v-if="false" title="Security and account access"
            ><b-card-text>Security and account access</b-card-text></b-tab
          >
          <b-tab disabled title="Privacy and Safety"
            ><b-card-text>Privacy and Safety</b-card-text></b-tab
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
  };
</script>
