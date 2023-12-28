<template>
  <div class="container">
    <div class="mb-5 mt-2 pb-5 row">
      <div class="col-md-10 offset-md-1">
        <b-card>
          <b-card-title> <i class="fa-solid fa-chart-gantt"></i> Workflows </b-card-title>
          <b-card-sub-title class="mb-3">
            Workflows automate creation, assigning of tasks
          </b-card-sub-title>
          <b-card-text v-if="loading">
            <p><i class="fa fa-spinner"></i> Loading...</p>
          </b-card-text>

          <b-card-text v-else-if="workflows.length > 0" class="row">
            <workflow
              :workflow="workflow"
              v-for="workflow in workflows"
              :key="workflow.id"
              class="col-md-6"
              :teams="teams"
            ></workflow>
          </b-card-text>

          <b-card-text v-else>
            <p>
              No workflows found. To create a workflow, ask your manager to convert a task to
              workflow
            </p>
          </b-card-text>
        </b-card>
      </div>
    </div>
  </div>
</template>

<script>
  import Workflow from './Workflow.vue';
  export default {
    components: { Workflow },
    data() {
      return {
        workflows: [],
        loading: true,
        teams: [],
      };
    },
    created() {
      this.loadWorkflows();
    },
    methods: {
      loadWorkflows() {
        this.loading = true;
        axios
          .get('/api/v1/tasks/task-templates')
          .then(response => {
            this.workflows = response.data.data;
            this.loadTeams();
          })
          .catch(e => {
            this.$root.$emit('sendMessage', 'Failed to load Workflows');
          })
          .finally(f => {
            this.loading = false;
          });
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
