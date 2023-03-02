<template>
  <div>
    <div class="row py-1" v-if="full">
      <task-state-selector @updated="statusUpdated" class="col-md-3"></task-state-selector>
    </div>
    <div class="row">
      <task
        class="col-md-4"
        v-for="(task, index) in items"
        :task="task"
        :full="false"
        v-bind:key="index"
      >
      </task>
    </div>

    <div v-if="items.length === 0">
      <span v-if="loading"> <i class="fa fa-spinner"></i> Loading </span>
      <span v-else>
        No Tasks available
      </span>
    </div>
  </div>
</template>

<script>
  import TaskStateSelector from './TaskStateSelector';
  export default {
    components: { TaskStateSelector },
    props: {
      team: {
        type: Object,
        required: true,
      },
      full: {
        type: Boolean,
        default: false,
      },
    },
    data() {
      return {
        items: [],
        form: {
          status: ['OPEN'],
          team_id: this.team.id,
        },
        loading: true,
        meta: {
          currentPage: 1,
        },
      };
    },
    created() {
      this.loadTasks();
    },
    methods: {
      statusUpdated(data) {
        this.form.status = data;
        this.loadTasks();
      },
      loadTasks() {
        this.loading = true;
        this.form.page = this.meta.currentPage;
        axios
          .get(`/api/v1/tasks/`, { params: this.form })
          .then(results => {
            this.items = results.data.data;
            this.meta.currentPage = results.data.current_page;
            this.meta.total = results.data.total;
            this.meta.perPage = results.data.per_page;
            this.meta.lastPage = results.data.last_page;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to tasks');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
