<template>
  <div>
    <div class="mb-5 mt-2 pb-5 row">
      <div class="col-md-10 offset-md-1">
        <b-card title="Workflows">
          <b-card-sub-title>
            Workflows automate creation, assigning of tasks
          </b-card-sub-title>
          <b-card-text v-if="loading">
            <p><i class="fa fa-spinner"></i> Loading...</p>
          </b-card-text>

          <b-card-text v-else-if="workflows.length > 0">
            <div v-for="workflow in workflows" :key="workflow.id" class="mb-2">
              {{ workflow }}
            </div>
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
  export default {
    data() {
      return {
        workflows: [],
        loading: true,
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
          })
          .catch(e => {
            this.$root.$emit('sendMessage', 'Failed to load Workflows');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
