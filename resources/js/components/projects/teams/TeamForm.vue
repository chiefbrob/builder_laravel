<template>
  <div>
    <form class="py-3 row" enctype="multipart/form-data" @submit.prevent="submitForm" method="POST">
      <div class="col-md-12">
        <b-form-group id="input-group-1" label="Name: *" label-for="name">
          <b-form-input id="name" v-model="form.name" type="text" required></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="name"></field-error>

        <b-form-group id="input-group-2" label="Email: *" label-for="email">
          <b-form-input id="email" v-model="form.email" type="email" required></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="email"></field-error>

        <b-form-group label="Description:">
          <b-form-textarea id="textarea" v-model="form.contents" rows="5"></b-form-textarea>
        </b-form-group>

        <field-error :solid="false" :errors="errors" field="contents"></field-error>

        <p class="py-3">
          <input type="submit" class="btn btn-success" text="Submit" />
        </p>
      </div>
    </form>
  </div>
</template>

<script>
  export default {
    props: {
      team: {
        required: false,
      },
      url: {
        required: true,
      },
    },
    data() {
      return {
        errors: [],
        form: {
          name: null,
          email: null,
          description: null,
        },
      };
    },
    created() {
      this.setDefaults();
    },
    methods: {
      setDefaults() {
        if (this.team) {
          this.form.name = this.team.name;
          this.form.email = this.team.email;
          this.form.description = this.team.description;
        } else {
          this.form.email = this.$store.getters.user.email;
        }
      },

      submitForm() {
        axios
          .post(this.url, this.form)
          .then(results => {
            this.$root.$emit('sendMessage', 'Team created', 'success');
            this.$router.push({
              name: 'team-single',
              params: {
                id: results.data.id,
              },
            });
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to create team!');
          });
      },
    },
  };
</script>
