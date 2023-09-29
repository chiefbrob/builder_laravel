<template>
  <div>
    <b-card tag="article" class="col-md-4 offset-md-4 py-5 ">
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
            <b-form-group id="input-group-1" label="Name: *" label-for="name">
              <b-form-input id="name" v-model="form.name" type="text" required></b-form-input>
            </b-form-group>
            <field-error :solid="false" :errors="errors" field="name"></field-error>

            <b-form-group id="input-group-3" label="username: *" label-for="username">
              <b-form-input id="username" v-model="form.username" type="text"></b-form-input>
            </b-form-group>
            <field-error :solid="false" :errors="errors" field="username"></field-error>

            <b-form-group
              id="input-group-2"
              label="Phone Number: *"
              label-for="phone_number"
              style="width: 100%"
            >
              <phone-number @updated="newPhoneNumber" :number="user.phone_number"></phone-number>
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

            <b-form-group label="Active Team" v-if="$root.$featureIsEnabled('teams') && user">
              <b-form-select :options="teamOptions" v-model="form.team_id"></b-form-select>
            </b-form-group>

            <p class="py-3">
              <input
                type="submit"
                class="btn btn-success btn-sm"
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
          team_id: null,
          username: null,
        },
        teams: [],
        errors: [],
      };
    },
    computed: {
      user() {
        return this.$store.state.user;
      },
      teamOptions() {
        return this.teams.map(team => {
          return {
            value: team.id,
            text: team.name,
          };
        });
      },
    },
    created() {
      this.loadTeams();
    },
    mounted() {
      this.form.name = this.user.name;
      this.form.phone_number = this.user.phone_number;
      this.form.team_id = this.user.team_id;
      this.form.username = this.user.username;
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
        if (this.form.team_id) {
          form.append('team_id', this.form.team_id);
        }

        form.append('username', this.form.username);

        this.errors = [];

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
      newPhoneNumber(number) {
        this.form.phone_number = number.countryCallingCode + number.nationalNumber;
      },
      loadTeams() {
        axios
          .get(`/api/v1/teams/?page=1`)
          .then(results => {
            this.teams = results.data.data;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to teams');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
