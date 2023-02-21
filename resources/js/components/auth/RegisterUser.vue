<template>
  <div>
    <nav-root></nav-root>

    <div class="mb-5 pb-5 row">
      <div class="col-md-8 offset-md-2">
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
              <b-form-input
                id="name"
                v-model="form.name"
                type="text"
                required
                :placeholder="`e.g. Walter Mongare`"
              ></b-form-input>
            </b-form-group>

            <field-error :solid="false" :errors="errors" field="name"></field-error>

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

            <b-form-group
              id="input-group-3"
              label="Password: *"
              label-for="password"
              description="at least 6 characters"
            >
              <b-form-input
                id="password"
                v-model="form.password"
                type="password"
                required
              ></b-form-input>
            </b-form-group>

            <field-error :solid="false" :errors="errors" field="password"></field-error>

            <b-form-group
              id="input-group-4"
              label="Repeat Password: *"
              label-for="password_confirmation"
              description="same as above"
            >
              <b-form-input
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                required
              ></b-form-input>
            </b-form-group>

            <field-error
              :solid="false"
              :errors="errors"
              field="password_confirmation"
            ></field-error>

            <p class="py-3">
              <b-button id="submit" @click="submitForm" variant="success">Create Account</b-button>
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
          .post(`/register`, this.form)
          .then(results => {
            this.loaded = true;
            this.$root.$emit('loadUser');
            this.$root.$emit('sendMessage', 'User Created', 'success');
            setTimeout(() => {
              let originalToPath = localStorage.getItem('original-to-path');
              if (originalToPath) {
                localStorage.removeItem('original-to-path');
                return (window.location = originalToPath);
              }
              this.$router.push({ name: 'home' });
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
