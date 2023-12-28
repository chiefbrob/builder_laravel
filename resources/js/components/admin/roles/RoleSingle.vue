<template>
  <div class="container">
    <div class="mb-5 pb-5 mt-2 row">
      <div class="col-md-10 offset-md-1">
        <role @roleUpdated="loadRole" v-if="role" class="" :full="true" :role="role"></role>
        <div v-else>
          <span v-if="loading"><i class="fa fa-spinner"></i> Loading</span>
          <span v-else>Failed to load Role</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Role from './Role';
  export default {
    components: { Role },
    props: [],
    data() {
      return {
        role: null,
        role_id: null,
        loading: true,
      };
    },
    computed: {},
    methods: {
      loadRole() {
        this.role_id = this.$route.params.role_id;
        axios
          .get(`/api/v1/admin/roles/?role_id=${this.role_id}`)
          .then(results => {
            this.role = results.data;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to load role');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
    created() {
      this.loadRole();
    },
  };
</script>
