<template>
  <div>
    <div class="row">
      <task
        class="col-md-3"
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
  export default {
    props: ['team'],
    data() {
      return {
        items: [],
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
      loadTasks() {
        axios
          .get(`/api/v1/tasks/?team_id=${this.team.id}&page=${this.meta.currentPage}`)
          .then(results => {
            this.items = results.data.data;
            this.meta.currentPage = results.data.current_page;
            this.meta.total = results.data.total;
            this.meta.perPage = results.data.per_page;
            this.meta.lastPage = results.data.last_page;
          })
          .catch(error => {
            console.log(error);
            this.$root.$emit('sendMessage', 'Failed to tasks');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
