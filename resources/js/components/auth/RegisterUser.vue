<template>
  <div class="container">
    <div class="mb-5 pb-5 row">
      <div class="col-md-4 offset-md-4">
        <h4 class="pt-3">Create new account</h4>

        <form
          class="py-3 row"
          enctype="multipart/form-data"
          @submit.prevent="submitForm"
          method="POST"
          v-if="!loading && !loaded"
        >
          <div class="col-md-12">
            <b-form-group id="input-group-1" label="Full Name: *" label-for="name">
              <b-form-input id="name" v-model="form.name" type="text" required></b-form-input>
            </b-form-group>

            <field-error :solid="false" :errors="errors" field="name"></field-error>

            <b-form-group id="input-group-2" label="Email address: *" label-for="email">
              <b-form-input id="email" v-model="form.email" type="email" required></b-form-input>
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
              <b-button id="submit" size="sm" @click="submitForm" variant="success"
                >Create Account</b-button
              >
              <b-button to="/login" size="sm" variant="link" class="float-right">Login</b-button>
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
            Welcome
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
        this.form.password_confirmation = this.form.password;
        axios
          .post(`/register`, this.form)
          .then(results => {
            this.loaded = true;
            this.$root.$emit('sendMessage', 'User Created', 'success');
            setTimeout(() => {
              let originalToPath = localStorage.getItem('original-to-path');
              if (originalToPath) {
                localStorage.removeItem('original-to-path');
                return (window.location = originalToPath);
              }
              window.location = '/home';
              //this.$router.push({ name: 'home' });
            }, 5000);
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to create user!');
          })
          .finally(() => {
            this.loading = false;
          });
      },
    },
    created() {},
  };
</script>
