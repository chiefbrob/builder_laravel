<template>
  <div class="container">
    <div class="mb-5 mt-2 pb-5 row">
      <div class="col-md-10 offset-md-1">
        <team v-if="team" :full="true" :team="team"></team>
        <div v-else>
          <span v-if="loading"><i class="fa fa-spinner"></i> Loading</span>
          <span v-else>Failed to load Team</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Team from './Team.vue';
  export default {
    components: { Team },
    props: [],
    data() {
      return {
        team_id: null,
        loading: true,
        team: null,
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
    },
    created() {
      this.loadTeam();
    },
  };
</script>
