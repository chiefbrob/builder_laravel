<template>
  <div>
    <b-card header-bg-variant="primary">
      <template #header>
        <h4 v-if="!option" class="mb-0" style="color: white">Account</h4>
        <h4 v-else @click="option = null" style="color: white">
          <i class="fa fa-arrow-left"></i> {{ option.name }}
        </h4>
      </template>

      <b-list-group flush v-if="!option">
        <b-list-group-item
          v-for="option in availableOptions"
          v-bind:key="option.link"
          class="options"
          @click="optionSelected(option)"
          ><i class="fa " :class="option.icon"></i> {{ option.name }}
        </b-list-group-item>
      </b-list-group>
      <b-card-text body-bg-variant="light">
        <div v-if="option && option.link === 'account'">
          <p>Name: {{ $store.state.user.name }}</p>
          <p>
            Email: {{ $store.state.user.email }}
            <b-badge v-if="!$store.state.user.email_verified_at" variant="danger"
              >unverified</b-badge
            >
          </p>

          <p>
            Phone: {{ $store.state.user.phone_number }}
            <b-badge v-if="!$store.state.user.phone_number_verified_at" variant="danger"
              >unverified</b-badge
            >
          </p>
          <p>Account creation: {{ $store.state.user.created_at | relative }}</p>
        </div>
        <div v-if="option && option.link === 'deactivate'" style="text-align: left">
          <h5>
            <avatar style="width: 2.5em; display: inline"></avatar> {{ $store.state.user.name }}
          </h5>
          <h6>This will deactivate your account!</h6>
          <p>
            <br /><i>
              You’re about to start the process of deactivating your
              {{ $store.state.config.name }} account. Your display name, and public profile will no
              longer be viewable on the platforrm.</i
            >
          </p>
          <h6>
            What else you should know
          </h6>
          <p>
            You can restore your {{ $store.state.config.name }} account if it was accidentally or
            wrongfully deactivated
          </p>
          <p class="text-center">
            <b-button variant="danger" @click="deactivate">
              <i class="fa fa-heart-broken"></i> Deactivate</b-button
            >
          </p>
        </div>
      </b-card-text>
    </b-card>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        option: null,
        options: [
          {
            name: 'Account Information',
            link: 'account',
            icon: 'fa-user',
            enabled: true,
          },
          {
            name: 'Change your Password',
            link: 'password',
            icon: 'fa-key',
            enabled: false,
          },
          {
            name: 'Deactivate your Account',
            link: 'deactivate',
            icon: 'fa-heart-broken',
            enabled: true,
          },
        ],
      };
    },
    methods: {
      optionSelected(option) {
        this.option = option;
      },
      deactivate() {
        axios
          .delete(`/api/v1/users/${this.$store.state.user.id}`)
          .then(results => {
            this.$root.$emit('sendMessage', 'Profile Deactivated', 'success');
            setTimeout(() => {
              window.location = '/logout';
            }, 2000);
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to deactivate account', 'danger');
          });
      },
    },
    computed: {
      availableOptions() {
        return this.options.filter(option => option.enabled === true);
      },
    },
  };
</script>

<style>
  .options {
    cursor: pointer;
  }
  .options:hover {
    font-size: 105%;
    text-decoration: underline;
  }
</style>
