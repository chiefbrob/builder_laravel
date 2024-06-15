<template>
  <div class="container">
    <div class="mb-5 pb-5 row py-2">
      <div class="col-md-4 offset-md-4">
        <h4>Create Team</h4>
        <team-form @submit="submitted" :errors="errors"></team-form>
        <p>
          <i
            >You need <b-button size="sm" variant="link" to="/roles">manager</b-button> role to
            create a team
          </i>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
  import TeamForm from './TeamForm.vue';
  export default {
    components: { TeamForm },
    props: [],
    data() {
      return {
        errors: [],
      };
    },
    computed: {},
    methods: {
      submitted(form) {
        axios
          .post('/api/v1/teams', form)
          .then(results => {
            this.$root.$emit('sendMessage', 'Team created', 'success');
            this.$router.push({
              name: 'team-single',
              params: {
                team_id: results.data.id,
              },
            });
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to create team!');
          });
      },
    },
    created() {},
  };
</script>
