<template>
  <div>
    <nav-root></nav-root>
    <div class="mb-5 pb-5 mt-2 row">
      <div class="col-md-10 offset-md-1">
        <h4>
          <span v-if="team">{{ team.name }}</span> Create Task
        </h4>
        <task-form v-if="team" :errors="errors" :team="team" @submit="createTask"></task-form>
        <div v-else><i class="fa fa-spinner"></i> Loading</div>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  import TaskForm from './TaskForm';
  export default {
    components: { TaskForm },
    props: [],
    data() {
      return {
        team: null,
        errors: [],
      };
    },
    computed: {},
    methods: {
      loadTeam() {
        this.team_id = this.$router.currentRoute.params.team_id;

        axios
          .get(`/api/v1/teams/?team_id=${this.team_id}`)
          .then(results => {
            this.team = results.data;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to load team');
          })
          .finally(f => {
            this.loading = false;
          });
      },
      createTask(form) {
        axios
          .post('/api/v1/tasks', form)
          .then(results => {
            this.$root.$emit('sendMessage', 'Task created', 'success');
            this.$router.push({
              name: 'task-single',
              params: {
                task_id: results.data.data.id,
                team_id: this.team.id,
              },
            });
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to create task!');
          });
      },
    },
    created() {
      this.loadTeam();
    },
  };
</script>
