<template>
  <div>
    <b-table :fields="fields" :items="items">
      <template #cell(actions)="data">
        <b-button
          variant="danger"
          v-if="data.item.id !== user.id"
          href="#"
          @click="deleteUser(data.item)"
        >
          Delete
        </b-button>
        <span v-else>No Delete</span>
      </template>

      <template #cell(created_at)="data">
        <span> {{ data.item.created_at | relative }}</span>
      </template>

      <template #cell(verified_at)="data">
        <span> {{ data.item.verified_at | relative }}</span>
      </template>
    </b-table>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        fields: [
          { key: 'name', sortable: true },
          { key: 'email', sortable: true },
          { key: 'verified_at', sortable: true },
          { key: 'created_at', sortable: true },
          { key: 'Actions', sortable: true },
        ],
        items: [],
      };
    },
    created() {
      this.loadUsers();
    },
    computed: {
      user() {
        return this.$store.getters.user;
      },
    },
    methods: {
      deleteUser(user) {
        axios
          .delete(`/api/v1/admin/users`, {
            data: { user_id: user.id },
          })
          .then(results => {
            this.$root.$emit('sendMessage', 'User deleted', 'success');
            this.loadUsers();
          })
          .catch(error => {
            console.log(error);
            this.$root.$emit('sendMessage', 'Failed Delete User');
          });
      },
      loadUsers() {
        axios
          .get('/api/v1/admin/users')
          .then(results => {
            this.items = results.data.data;
          })
          .catch(error => {
            console.log(error);
            this.$root.$emit('sendMessage', 'Failed to load Admin Users');
          });
      },
    },
  };
</script>
