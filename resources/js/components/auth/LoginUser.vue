<template>
  <div class="container">
    <div class="mb-5 pb-5 row">
      <div class="col-md-4 offset-md-4">
        <div class="row">
          <div class="col-md-12">
            <h4 class="pt-3">
              Login

              <span class="float-right" v-if="$featureIsEnabled('socialite.google')">
                <a href="/auth/v1/google/redirect" class="btn btn-link">Google</a>
              </span>
            </h4>
          </div>
        </div>

        <form
          class="py-3 row"
          @submit.prevent="submitForm"
          method="POST"
          v-if="!loading && !loaded"
        >
          <div class="col-md-12">
            <b-form-group id="input-group-2" label="Username: *" label-for="username">
              <b-form-input
                id="username"
                name="username"
                v-model="form.username"
                type="text"
                required
              ></b-form-input>
            </b-form-group>

            <field-error :solid="false" :errors="errors" field="username"></field-error>

            <b-form-group id="input-group-3" label="Password: *" label-for="password">
              <b-form-input
                id="password"
                name="password"
                v-model="form.password"
                type="password"
                required
              ></b-form-input>
            </b-form-group>

            <field-error :solid="false" :errors="errors" field="password"></field-error>

            <p class="py-3">
              <b-button
                id="loginbtn"
                size="sm"
                :disabled="loginDisabled"
                @click="submitForm"
                variant="success"
                >Login</b-button
              >
              <b-button
                class="float-right"
                size="sm"
                variant="link"
                v-if="!loading"
                @click="$router.push({ name: 'register' })"
                >Create Account</b-button
              >
              <b-button size="sm" variant="link" v-if="!loading" href="/password/reset"
                >Reset</b-button
              >
              <span v-if="loading"><i class="fa fa-spinner"></i> Loading...</span>
            </p>
          </div>
        </form>

        <div v-if="loading">
          <p>
            <i class="fa fa-spinner"></i>
            Loading...
          </p>
        </div>

        <div v-if="loaded">
          <p>
            Welcome back.
            <br />

            <i class="fa fa-spinner"></i>
            Loading profile
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: [],
    data() {
      return {
        form: {
          username: null,
          password: null,
        },
        errors: [],
        loading: false,
        loaded: false,
      };
    },
    computed: {
      loginDisabled() {
        return !this.form.password || this.form.password.length < 8 || this.loading;
      },
    },
    methods: {
      submitForm() {
        this.loading = true;
        axios
          .post(`/login`, this.form)
          .then(results => {
            this.loaded = true;
            this.$root.$emit('loadUser');
            this.$root.$emit('sendMessage', 'Login Success', 'success');
            setTimeout(() => {
              let originalToPath = localStorage.getItem('original-to-path');
              if (originalToPath) {
                localStorage.removeItem('original-to-path');
                return (window.location = originalToPath);
              }
              window.location = '/home';
            }, 1000);
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to login!');
          })
          .finally(() => {
            this.loading = false;
          });
      },
    },
    created() {},
  };
</script>
