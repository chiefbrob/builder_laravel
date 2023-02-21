<template>
  <div>
    <nav-root></nav-root>
    <div class="mb-5 pb-5 mt-2 row">
      <div class="col-md-10 offset-md-1">
        <h4>
          <span v-if="team">{{ team.name }}</span> Tasks
          <b-button
            @click="$router.push({ name: 'new-task', params: { team_id: team.id } })"
            class="float-right text-white"
            size="sm"
            v-b-popover.hover.top="'this will create a new task in  ' + teamName"
            title="Add Task"
            variant="info"
            ><i class="fa fa-plus"></i
          ></b-button>
        </h4>
        <task-list
          :full="true"
          v-if="$root.$featureIsEnabled('teams') && team"
          :team="team"
        ></task-list>
        <div v-else>Teams Not Enabled</div>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  import TaskList from './TaskList';
  export default {
    components: {
      TaskList,
    },
    props: [],
    data() {
      return {
        team: null,
      };
    },
    computed: {
      user() {
        return this.$store.getters.user;
      },
      teamName() {
        if (this.team) {
          return this.team.name;
        }
        return ' the Team';
      },
    },
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
    },
    created() {
      this.loadTeam();
    },
  };
</script>
