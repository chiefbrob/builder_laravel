<template>
  <div>
    <b-card tag="article" class="col-md-4 offset-md-4 py-5 ">
      <b-card-title>
        <b-button
          variant="dark"
          class="fa fa-arrow-left"
          @click="$router.push({ name: 'profile' })"
        ></b-button>
        Edit Profile
      </b-card-title>
      <b-card-text>
        <form
          class="py-3 row"
          enctype="multipart/form-data"
          @submit.prevent="updateName"
          method="POST"
        >
          <input type="hidden" name="_token" :value="csrf" />
          <div style="width: 80%; margin-left: 10%;">
            <avatar></avatar>
          </div>
          <div class="col-md-12">
            <b-form-group
              id="input-group-1"
              label="Name: *"
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
            <field-error :solid="false" :errors="errors" field="name"></field-error>

            <b-form-group
              id="input-group-2"
              label="Phone Number: *"
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
            <field-error :solid="false" :errors="errors" field="phone_number"></field-error>

            <b-form-group label="Photo:" label-cols-sm="2">
              <b-form-file
                @change="imageUpdated"
                id="profile-image"
                size="sm"
                accept=".jpg, .jpeg"
                ref="photoInput"
              ></b-form-file>
            </b-form-group>

            <field-error :solid="false" :errors="errors" field="image"></field-error>

            <p class="py-3">
              <input
                type="submit"
                class="btn btn-success"
                text="Update Profile"
                :disabled="form.name === null || form.name.length < 3"
              />
            </p>
          </div>
        </form>
      </b-card-text>
    </b-card>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        csrf: window.csrf_token,
        form: {
          name: null,
          phone_number: null,
          photo: null,
        },
        errors: [],
      };
    },
    computed: {
      user() {
        return this.$store.state.user;
      },
    },
    mounted() {
      this.form.name = this.user.name;
      this.form.phone_number = this.user.phone_number;
    },
    methods: {
      imageUpdated(img) {
        this.form.photo = img.target.files[0];
      },
      updateName() {
        let form = new FormData();
        if (this.form.photo) {
          form.append('photo', this.form.photo);
        }
        form.append('phone_number', this.form.phone_number);
        form.append('name', this.form.name);

        axios
          .post(`/api/v1/users/${this.user.id}`, form, {
            headers: { 'Content-Type': 'multipart/form-data' },
          })
          .then(results => {
            this.$root.$emit('sendMessage', 'Profile updated', 'success');
            this.$root.$emit('loadUser');
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Profile update failed!');
          });
      },
    },
  };
</script>
