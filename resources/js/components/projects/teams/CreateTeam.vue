<template>
  <div>
    <div class="mb-5 pb-5 row">
      <div class="col-md-10 offset-md-1">
        <h4>Create Team</h4>
        <team-form @submit="submitted" :errors="errors"></team-form>
      </div>
    </div>
  </div>
</template>

<script>
  import TeamForm from './TeamForm';
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
