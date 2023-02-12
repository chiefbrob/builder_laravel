<template>
  <div>
    <nav-root></nav-root>
    <div class="mb-5 pb-5 row">
      <team v-if="team" class="col-md-10 offset-md-1" :full="true" :team="team"></team>
      <div v-else>
        <span v-if="loading"><i class="fa fa-spinner"></i> Loading</span>
        <span v-else>Failed to load Team</span>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  import Team from './Team';
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
        this.team_id = this.$router.currentRoute.params.id;
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
