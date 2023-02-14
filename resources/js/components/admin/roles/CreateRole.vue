<template>
  <div>
    <nav-root></nav-root>
    <div class="mb-5 pb-5 row">
      <div class="col-md-10 offset-md-1">
        <h4>
          Create Role
        </h4>
        <role-form :errors="errors" @submit="createRole"></role-form>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  import RoleForm from './RoleForm';
  export default {
    components: { RoleForm },
    props: [],
    data() {
      return {
        team: null,
        errors: [],
      };
    },
    computed: {},
    methods: {
      createRole(form) {
        axios
          .post('/api/v1/admin/roles', form)
          .then(results => {
            this.$root.$emit('sendMessage', 'Role created', 'success');

            this.$router.push({
              name: 'role-single',
              params: {
                role_id: results.data.id,
              },
            });
          })
          .catch(({ response }) => {
            console.log(response.data);
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to create role!');
          });
      },
    },
  };
</script>
