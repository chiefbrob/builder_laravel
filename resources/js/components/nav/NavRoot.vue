<template>
  <div class="">
    <b-alert
      v-model="message.show"
      class="position-fixed fixed-bottom m-0 rounded-0"
      style="z-index: 2000"
      :variant="message.variant"
      dismissible
    >
      {{ message.text }}
    </b-alert>

    <b-navbar toggleable="lg" type="dark" variant="info" class="row">
      <b-navbar-brand
        class="pl-2 pointer"
        @click="$router.push({ name: 'welcome' })"
        v-text="$root.$store.state.config.name"
      ></b-navbar-brand>

      <span>
        <b-nav-item-dropdown right style="list-style-type: none;">
          <template #button-content>
            <em>
              <avatar style="display: inline; width: 2.5em"></avatar>
            </em>
          </template>

          <b-dropdown-item href="#" v-if="user" @click="$router.push({ name: 'profile' })">
            @{{ user.username }}
          </b-dropdown-item>

          <b-dropdown-item href="#" v-if="user" @click="$router.push({ name: 'settings' })">
            Settings
          </b-dropdown-item>

          <b-dropdown-item href="#" @click="logout" v-if="user">Log Out</b-dropdown-item>

          <b-dropdown-item to="/login" v-if="!user">Login</b-dropdown-item>

          <b-dropdown-item to="/register" v-if="!user">Register</b-dropdown-item>
        </b-nav-item-dropdown>
      </span>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav class="pl-4">
        <b-navbar-nav>
          <b-nav-item
            href="#"
            @click="$router.push({ name: 'home' })"
            :active="$route.name === 'home'"
          >
            <i class="fa fa-tachometer"></i>
            Home
          </b-nav-item>

          <b-nav-item-dropdown v-if="admin" :active="false">
            <template #text><i class="fa fa-lock"></i> Admin</template>

            <b-dropdown-item class="option" @click="$router.push({ name: 'admin.users' })">
              <i class="fa fa-users"></i> Users</b-dropdown-item
            >

            <b-dropdown-item href="#" @click="$router.push({ name: 'style' })">
              <i class="fa fa-star"></i> Style
            </b-dropdown-item>

            <b-dropdown-item href="#" @click="$router.push({ name: 'roles' })">
              <i class="fa fa-tasks"></i> Roles
            </b-dropdown-item>

            <b-dropdown-item href="/admin/feature_flags">
              <i class="fa fa-key"></i> Feature Flags
            </b-dropdown-item>
          </b-nav-item-dropdown>

          <b-nav-item
            href="#"
            @click="$router.push({ name: 'blog' })"
            :active="$route.name === 'blog'"
          >
            <i class="fa fa-book"></i>
            Blog
          </b-nav-item>

          <b-nav-item
            href="#"
            v-if="$root.$featureIsEnabled('teams')"
            @click="$router.push({ name: 'teams' })"
            :active="teamsActive"
          >
            <i class="fa fa-users"></i>
            Teams
          </b-nav-item>

          <b-nav-item
            href="#"
            v-if="$root.$featureIsEnabled('shop')"
            @click="$router.push({ name: 'shop' })"
            :active="$route.name.includes('shop') || $route.name.includes('product')"
          >
            <i class="fa fa-shop"></i>
            Shop
          </b-nav-item>
        </b-navbar-nav>

        <b-navbar-nav>
          <b-nav-item
            href="#"
            @click="$router.push({ name: 'contact' })"
            :active="$route.name === 'contact'"
          >
            <i class="fa fa-phone"></i>
            Contact
          </b-nav-item>
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

            <b-button size="sm" variant="dark" class="my-2 my-sm-0" type="submit">Search</b-button>
          </b-nav-form>

          <b-nav-item-dropdown v-if="$root.$featureIsEnabled('languages')" right>
            <template #button-content>
              <b-button size="" variant="info" class="text-white"
                ><i class="fa fa-language"></i> {{ language }}</b-button
              >
            </template>

            <b-dropdown-item
              v-for="lang in languages"
              v-bind:key="lang.short"
              :active="lang.short === language"
              href="#"
              @click="setLocale(lang.short)"
            >
              {{ lang.name }}
            </b-dropdown-item>
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
        languages: [
          {
            name: 'English',
            short: 'en',
          },
          {
            name: 'French',
            short: 'fr',
          },
          {
            name: 'Swahili',
            short: 'sw',
          },
        ],
        language: window.locale,
      };
    },
    computed: {
      teamsActive() {
        let name = this.$route.name;
        return name.includes('team') || name.includes('task');
      },
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
      this.$root.$on('loadUser', (message, variant) => {
        this.loadUser();
      });
    },
    methods: {
      setLocale(lang) {
        axios
          .post(`/language/${lang}`)
          .then(results => {
            this.sendMessage('Language switched. Reloading...', 'success');
            setTimeout(() => {
              window.location.reload();
            }, 1200);
          })
          .catch(error => {
            this.sendMessage('Language switch Failed!', 'danger');
          });
      },
      formSubmitted() {
        if (!this.formComplete) {
          return;
        }
        this.$router.push('/search?query=' + this.form.query);

        if (this.$route.name === 'search') {
          return this.$root.$emit('search', this.form.query);
        }
        return;
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
      loadUser() {
        axios
          .get('/api/v1/user')
          .then(results => {
            this.$store.commit('user', results.data);
            window.User = results.data;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed Load User');
          });
      },
    },
  };
</script>
