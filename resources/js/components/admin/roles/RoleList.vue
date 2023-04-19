<template>
  <div>
    <div class="row">
      <role
        class="col-md-3"
        v-for="(role, index) in items"
        :role="role"
        :full="false"
        v-bind:key="index"
        @roleUpdated="loadRoles"
      >
      </role>
    </div>
    <div v-if="items.length === 0">
      <span v-if="loading"> <i class="fa fa-spinner"></i> Loading </span>
      <span v-else>
        No Roles available
      </span>
    </div>
  </div>
</template>

<script>
  import Role from './Role';
  export default {
    components: { Role },
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
      this.loadRoles();
    },
    methods: {
      loadRoles() {
        axios
          .get(`/api/v1/admin/roles/?page=${this.meta.currentPage}`)
          .then(results => {
            this.items = results.data.data;
            this.meta.currentPage = results.data.current_page;
            this.meta.total = results.data.total;
            this.meta.perPage = results.data.per_page;
            this.meta.lastPage = results.data.last_page;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to roles');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
