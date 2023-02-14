<template>
  <div>
    <nav-root></nav-root>

    <div class="mb-5 pb-5 row">
      <div class="col-md-6 offset-md-3">
        <h4 class="pt-3">Login</h4>

        <form
          class="py-3 row"
          @submit.prevent="submitForm"
          method="POST"
          v-if="!loading && !loaded"
        >
          <div class="col-md-12">
            <b-form-group id="input-group-2" label="Email address: *" label-for="email">
              <b-form-input
                id="email"
                v-model="form.email"
                type="email"
                required
                placeholder="e.g. someone@somewhere.something"
              ></b-form-input>
            </b-form-group>

            <field-error :solid="false" :errors="errors" field="email"></field-error>

            <b-form-group id="input-group-3" label="Password: *" label-for="password">
              <b-form-input
                id="password"
                v-model="form.password"
                type="password"
                required
              ></b-form-input>
            </b-form-group>

            <field-error :solid="false" :errors="errors" field="password"></field-error>

            <p class="py-3">
              <input type="submit" class="btn btn-success" text="Login" />
              <a class="float-right" href="/password/reset">Reset Password</a>
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

    <page-footer></page-footer>
  </div>
</template>

<script>
  export default {
    props: [],
    data() {
      return {
        form: {
          name: null,
          email: null,
          password: null,
          password_confirmation: null,
        },
        errors: [],
        loading: false,
        loaded: false,
      };
    },
    computed: {},
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
