<template>
  <div>
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
            <div class="mb-3">
              <label for="name" class="form-label">Full Name: *</label>
              <input
                type="text"
                v-model="form.name"
                class="form-control"
                id="name"
                aria-describedby="basic-addon3"
              />
              <div class="form-text">e.g. Walter Mongare</div>
            </div>

            <field-error :solid="false" :errors="errors" field="name"></field-error>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input
                type="email"
                v-model="form.email"
                class="form-control"
                id="email"
                aria-describedby="basic-addon3"
              />
              <div class="form-text">e.g. someone@somewhere.something</div>
            </div>

            <field-error :solid="false" :errors="errors" field="email"></field-error>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input
                type="password"
                class="form-control"
                v-model="form.password"
                id="password"
                aria-describedby="basic-addon3"
              />
              <div class="form-text">at least 6 characters</div>
            </div>

            <field-error :solid="false" :errors="errors" field="password"></field-error>

            <p class="py-3">
              <button class="btn btn-sm btn-success" id="submit" @click="submitForm">
                Create Account
              </button>
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
  import FieldError from '../shared/FieldError';
  export default {
    components: { FieldError },
    props: [],
    data() {
      return {
        form: {
          name: null,
          email: null,
          password: null,
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
          .then((results) => {
            this.loaded = true;
            this.$root.$emit('loadUser');
            // this.$root.$emit('sendMessage', 'User Created', 'success');
            // setTimeout(() => {
            //   this.$router.push({ name: 'home' });
            // }, 5000);
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            // this.$root.$emit('sendMessage', 'Failed to create user!');
          })
          .finally(() => {
            this.loading = false;
          });
      },
    },
    created() {},
  };
</script>
