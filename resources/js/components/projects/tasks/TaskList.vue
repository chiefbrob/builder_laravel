<template>
  <div>
    <div class="row mb-2" v-if="full">
      <task-state-selector class="col-md-4" @updated="statusUpdated"></task-state-selector>
      <team-user-selector
        class="col-md-4"
        :team="team"
        @updated="usersUpdated"
      ></team-user-selector>
      <task-period-selector
        class="col-md-4"
        @periodUpdated="setPeriod"
        v-if="$featureIsEnabled('task-filter-period')"
      ></task-period-selector>
    </div>
    <div class="row">
      <task
        class="col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-1"
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
  import TeamUserSelector from '../teams/TeamUserSelector.vue';
  import TaskStateSelector from './TaskStateSelector.vue';
  import TaskPeriodSelector from './TaskPeriodSelector.vue';
  export default {
    components: { TaskStateSelector, TeamUserSelector, TaskPeriodSelector },
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
          assigned_to: [window.User.id],
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
      usersUpdated(data) {
        this.form.assigned_to = data.map(user => {
          return user.id;
        });
        this.loadTasks();
      },
      setPeriod(period) {},
    },
  };
</script>
