<template>
  <div>
    <b-alert
      v-model="message.show"
      class="position-fixed fixed-bottom m-0 rounded-0"
      style="z-index: 2000"
      :variant="message.variant"
      dismissible
      >{{ message.text }}</b-alert
    >
    <b-navbar toggleable="lg" type="dark" variant="success" class="row">
      <b-navbar-brand href="/">
        AppName
      </b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav style="padding: 0 1em">
        <b-navbar-nav>
          <b-nav-item
            v-if="isWelcome"
            href="#"
            @click="$router.push({ name: 'home' })"
            :active="$route.name === 'home'"
            >Home</b-nav-item
          >
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <b-nav-item-dropdown right>
            <!-- Using 'button-content' slot -->
            <template #button-content>
              <em>{{ longName }}</em>
            </template>
            <b-dropdown-item href="#" v-if="user" @click="$router.push({ name: 'profile' })"
              >My Profile</b-dropdown-item
            >
            <b-dropdown-item href="#" v-if="admin" @click="$router.push({ name: 'admin' })"
              >Admin Panel</b-dropdown-item
            >
            <b-dropdown-item href="#" @click="logout" v-if="user">Log Out</b-dropdown-item>
            <b-dropdown-item href="/login" v-if="!user">Login</b-dropdown-item>
            <b-dropdown-item href="/register" v-if="!user">Register</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        keyword: null,
        message: {
          show: false,
          text: null,
          variant: 'danger',
        },
      };
    },
    computed: {
      user() {
        return this.$store.getters.user;
      },
      longName() {
        if (!this.user) {
          return 'Account';
        }
        let names = this.user.name.split(' ');
        let longN = null;
        names.forEach(name => {
          if (!longN || name.length > longN.length || name.length === longN.length) {
            longN = name;
          }
        });
        return longN;
      },
      isWelcome() {
        return this.$router.currentRoute.name !== 'welcome';
      },
      home() {
        return this.$route.name === 'home';
      },
      admin() {
        return this.user && this.user.admin;
      },
    },
    created() {
      this.$root.$on('sendMessage', (message, variant) => {
        this.sendMessage(message, variant);
      });
    },
    methods: {
      logout() {
        localStorage.clear();
        window.location = '/logout';
      },

      search(e) {
        e.preventDefault();
        this.$emit('search', this.keyword);
        this.$router.push(`/search/${this.keyword}`);
      },
      sendMessage(text, variant = 'danger') {
        this.message.text = text;
        this.message.variant = variant;
        this.message.show = true;
      },
    },
  };
</script>
