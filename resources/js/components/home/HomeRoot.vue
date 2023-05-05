<template>
  <div>
    <div class="pb-5 pt-2 row">
      <task-list
        :full="true"
        v-if="$root.$featureIsEnabled('teams') && team"
        class="col-md-10 offset-md-1"
        :team="team"
      ></task-list>
      <b-card class="col-md-10 offset-md-1" v-else>
        <b-card-title>
          Home
        </b-card-title>
        <b-card-text>
          <p v-if="loading"><i class="fa fa-spinner"></i> Loading...</p>
          <p v-else>
            No content to display
          </p>
        </b-card-text>
      </b-card>
    </div>
  </div>
</template>

<script>
  import TaskList from '../projects/tasks/TaskList';
  export default {
    components: { TaskList },
    data() {
      return {
        loading: true,
        team: null,
      };
    },
    created() {
      this.loadTeam();
    },
    methods: {
      loadTeam() {
        if (window.User.team_id) {
          let team_id = window.User.team_id;
          axios
            .get(`/api/v1/teams/?team_id=${team_id}`)
            .then(results => {
              this.team = results.data;
            })
            .catch(error => {
              this.$root.$emit('sendMessage', 'Failed to load team');
            })
            .finally(f => {
              this.loading = false;
            });
        }
      },
    },
  };
</script>
