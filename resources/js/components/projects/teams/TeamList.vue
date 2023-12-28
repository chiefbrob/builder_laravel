<template>
  <div>
    <div class="row">
      <team
        :class="items.length === 1 ? 'col-md-10 offset-md-1' : 'col-md-4'"
        v-for="(team, index) in items"
        :team="team"
        :full="false"
        v-bind:key="index"
      >
      </team>
    </div>
    <div v-if="items.length === 0">
      <span v-if="loading"> <i class="fa fa-spinner"></i> Loading </span>
      <span v-else>
        You are not a member of any team
      </span>
    </div>
  </div>
</template>

<script>
  import Team from './Team';
  export default {
    components: { Team },
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
      this.loadTeams();
    },
    computed: {
      user() {
        return this.$store.getters.user;
      },
    },
    methods: {
      loadTeams() {
        axios
          .get(`/api/v1/teams/?page=${this.meta.currentPage}`)
          .then(results => {
            this.items = results.data.data;
            this.meta.currentPage = results.data.current_page;
            this.meta.total = results.data.total;
            this.meta.perPage = results.data.per_page;
            this.meta.lastPage = results.data.last_page;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to teams');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
