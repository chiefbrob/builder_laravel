<template>
  <div class="container">
    <div class="mb-5 pb-5 mt-2 row">
      <div class="col-md-10 offset-md-1">
        <b-breadcrumb :items="items"></b-breadcrumb>
        <task v-if="task" @taskUpdated="taskUpdated" class="" :full="true" :task="task"></task>
        <div v-else>
          <span v-if="loading"><i class="fa fa-spinner"></i> Loading</span>
          <span v-else>Failed to load Task</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Task from './Task.vue';
  export default {
    components: { Task },
    props: [],
    data() {
      return {
        team_id: null,
        task_id: null,
        loading: true,
        task: null,
        parentTask: null,
      };
    },
    computed: {
      items() {
        let links = [
          {
            text: 'Home',
            to: '/home',
          },
          {
            text: 'Teams',
            to: '/teams',
          },
        ];

        if (this.task) {
          links.push({
            text: this.task.team.name,
            to: `/teams/${this.task.team_id}/tasks`,
          });

          if (this.parentTask) {
            let code = this.$root.$slugify(this.parentTask.title);
            links.push({
              text: this.parentTask.title,
              to: `/teams/${this.task.team_id}/tasks/${this.parentTask.id}/${code}`,
            });
          }

          links.push({
            text: this.task.title,
            active: true,
          });
        } else {
          links.push({
            text: 'Loading ...',
            active: true,
          });
        }
        return links;
      },
    },
    methods: {
      loadParentTask() {
        if (!this.task || !this.task.task_id) {
          return;
        }

        axios
          .get(`/api/v1/tasks/?task_id=${this.task.task_id}&team_id=${this.team_id}`)
          .then(results => {
            this.parentTask = results.data;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to load parent task');
          })
          .finally(f => {});
      },
      loadTask() {
        this.team_id = this.$route.params.team_id;
        this.task_id = this.$route.params.task_id;
        axios
          .get(`/api/v1/tasks/?task_id=${this.task_id}&team_id=${this.team_id}`)
          .then(results => {
            this.task = results.data;
            this.loadParentTask();
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to load task');
          })
          .finally(f => {
            this.loading = false;
          });
      },
      taskUpdated(task) {
        this.task = task;
      },
    },
    created() {
      this.loadTask();
    },
  };
</script>
