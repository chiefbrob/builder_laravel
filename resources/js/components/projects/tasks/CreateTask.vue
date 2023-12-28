<template>
  <div class="container">
    <div class="mb-5 pb-5 mt-2 row">
      <div class="col-md-4 offset-md-4">
        <h4>
          <span v-if="team">{{ team.name }}</span>
          <div v-if="$router.currentRoute.params.task_id">
            Create SubTask to <a href="#">task</a>
          </div>
          <div v-else>Create Task</div>
        </h4>
        <task-form v-if="team" :errors="errors" :team="team" @submit="createTask"></task-form>
        <div v-else><i class="fa fa-spinner"></i> Loading</div>
      </div>
    </div>
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
            let task = results.data.data;
            this.$root.$emit('sendMessage', 'Task ' + task.title + ' created', 'success');

            if (form.another === 'accepted') {
              if (form.task_id) {
                this.$router.push({
                  name: 'new-subtask',
                  params: {
                    task_id: form.task_id,
                    team_id: this.team.id,
                  },
                });
              } else {
                this.$router.push({
                  name: 'new-task',
                  params: {
                    team_id: this.team.id,
                  },
                });
              }
            } else {
              this.$router.push({
                name: 'task-single',
                params: {
                  task_id: task.id,
                  team_id: task.team_id,
                  task_slug: this.$root.$slugify(task.title),
                },
              });
            }
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
