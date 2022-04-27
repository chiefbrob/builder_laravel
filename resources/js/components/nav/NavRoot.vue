<template>
  <div class="">
    <b-alert
      v-model="message.show"
      class="position-fixed fixed-bottom m-0 rounded-0"
      style="z-index: 2000"
      :variant="message.variant"
      dismissible
      >{{ message.text }}</b-alert
    >
    <b-navbar toggleable="lg" type="dark" variant="info" class=" row">
      <b-navbar-brand
        @click="$router.push({ name: 'welcome' })"
        v-text="$root.$store.state.config.name"
      ></b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item
            v-if="!isWelcome"
            href="#"
            @click="$router.push({ name: 'home' })"
            :active="$route.name === 'home'"
            ><i class="fa fa-tachometer"></i> Home</b-nav-item
          >
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <b-nav-form @submit.prevent="formSubmitted">
            <b-form-input
              size="sm"
              class="mr-sm-2"
              v-model="form.query"
              placeholder="Search"
            ></b-form-input>
            <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
          </b-nav-form>

          <b-nav-item-dropdown text="Lang" right v-if="false">
            <b-dropdown-item href="#">EN</b-dropdown-item>
            <b-dropdown-item href="#">SW</b-dropdown-item>
            <b-dropdown-item href="#">FR</b-dropdown-item>
            <b-dropdown-item href="#">AR</b-dropdown-item>
          </b-nav-item-dropdown>

          <b-nav-item-dropdown right>
            <template #button-content>
              <em> <avatar style="display:inline; width: 2.5em"></avatar> </em>
            </template>
            <b-dropdown-item href="#" v-if="user" @click="$router.push({ name: 'profile' })"
              >My Profile</b-dropdown-item
            >
            <b-dropdown-item href="#" v-if="user" @click="$router.push({ name: 'settings' })"
              >Settings</b-dropdown-item
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
        form: {
          query: null,
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
        return this.$router.currentRoute.name === 'welcome';
      },
      home() {
        return this.$route.name === 'home';
      },
      admin() {
        return this.user && this.user.admin;
      },
      formComplete() {
        return this.form.query !== null;
      },
    },
    created() {
      this.$root.$on('sendMessage', (message, variant) => {
        this.sendMessage(message, variant);
      });
    },
    methods: {
      formSubmitted() {
        if (!this.formComplete) {
          return;
        }
        axios
          .post(`/api/v1/search/`, this.form)
          .then(results => {
            this.sendMessage('Profile updated', 'success');
          })
          .catch(error => {
            console.log(error);
            this.sendMessage('Search Failed!', 'danger');
          });
      },
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
