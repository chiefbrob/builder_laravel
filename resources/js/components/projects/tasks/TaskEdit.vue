<template>
  <div class="container">
    <div class="mb-5 pb-5 mt-2 row">
      <div class="col-md-4 offset-md-4">
        <h4>
          <span v-if="task">{{ task.title }}</span>
        </h4>
        <task-form
          :task="task"
          v-if="team"
          :errors="errors"
          :team="team"
          @submit="updateTask"
        ></task-form>
        <div v-else><i class="fa fa-spinner"></i> Loading</div>
      </div>
    </div>
  </div>
</template>

<script>
  import TaskForm from './TaskForm.vue';
  export default {
    components: { TaskForm },
    props: [],
    data() {
      return {
        team: null,
        errors: [],
        task: null,
        loading: true,
      };
    },
    computed: {},
    methods: {
      loadTask() {
        this.team_id = this.$route.params.team_id;
        this.task_id = this.$route.params.task_id;
        axios
          .get(`/api/v1/tasks/?task_id=${this.task_id}&team_id=${this.team_id}`)
          .then(results => {
            this.task = results.data;
            this.team = results.data.team;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to load task');
          })
          .finally(f => {
            this.loading = false;
          });
      },
      updateTask(form) {
        form.team_id = this.team.id;
        axios
          .put(`/api/v1/tasks/${this.task.id}`, form)
          .then(results => {
            this.$root.$emit('sendMessage', 'Task updated', 'success');
            this.$router.push({
              name: 'task-single',
              params: {
                task_id: results.data.id,
                team_id: this.team.id,
                task_slug: this.$root.$slugify(results.data.title),
              },
            });
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to update task!');
          });
      },
    },
    created() {
      this.loadTask();
    },
  };
</script>
