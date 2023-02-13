<template>
  <div>
    <nav-root></nav-root>
    <div class="mb-5 pb-5 row">
      <div class="col-md-10 offset-md-1">
        <task v-if="task" class="" :full="true" :task="task"></task>
        <div v-else>
          <span v-if="loading"><i class="fa fa-spinner"></i> Loading</span>
          <span v-else>Failed to load Task</span>
        </div>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  import Task from './Task';
  export default {
    components: { Task },
    props: [],
    data() {
      return {
        team_id: null,
        task_id: null,
        loading: true,
        task: null,
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
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to load task');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
    created() {
      this.loadTask();
    },
  };
</script>
