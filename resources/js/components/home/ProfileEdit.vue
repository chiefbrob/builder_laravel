<template>
  <div>
    <nav-root></nav-root>
    <b-card title="Edit Profile" tag="article" class="col-md-4 offset-md-4 py-5 ">
      <b-card-text>
        <b-form class="py-3 row">
          <div class="col-md-12">
            <b-form-group
              id="input-group-1"
              label="Name:"
              label-for="name"
              description="Your full name."
            >
              <b-form-input
                id="name"
                v-model="form.name"
                type="text"
                required
                :placeholder="`Enter your name i.e. ${user.name}`"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              id="input-group-2"
              label="Phone Number:"
              label-for="phone_number"
              description="Your active phone number"
            >
              <b-form-input
                id="phone_number"
                v-model="form.phone_number"
                type="number"
                required
                :placeholder="`Enter your phone i.e. ${user.phone_number}`"
              ></b-form-input>
            </b-form-group>

            <p>
              Image update on
              <a href="https://en.gravatar.com/profiles/edit#about-you" target="_blank">Gravatar</a>
            </p>

            <p>
              <b-button variant="danger" @click="$router.push({ name: 'profile' })"
                >Cancel Edit</b-button
              >
              <b-button
                variant="success"
                :disabled="form.name === null || form.name.length < 3"
                @click="updateName"
                >Update Profile</b-button
              >
            </p>
          </div>
        </b-form>
      </b-card-text>
    </b-card>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        form: {
          name: null,
          phone_number: null,
        },
      };
    },
    computed: {
      user() {
        return this.$store.state.user;
      },
    },
    mounted() {
      this.form = this.user;
    },
    methods: {
      updateName() {
        axios
          .patch(`/api/v1/users/${this.user.id}`, this.form)
          .then(results => {
            this.$root.$emit('sendMessage', 'Profile updated', 'success');
            this.$root.$emit('loadUser');
          })
          .catch(error => {
            console.log(error);
            this.$root.$emit('sendMessage', 'Profile update failed!');
          });
      },
    },
  };
</script>
