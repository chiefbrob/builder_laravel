<template>
  <div>
    <b-card @click="showRole">
      <b-card-title class="pointer">
        {{ role.name }}
      </b-card-title>
      <b-card-sub-title> {{ role.created_at | relative }} </b-card-sub-title>
      <b-card-text v-if="full">
        {{ role.description }}
      </b-card-text>

      <b-card-text v-if="full">
        <b-form-select v-model="form.user" :options="userOptions" @input="addUser"></b-form-select>
        <ol>
          <li v-for="r in role.user_roles">
            <i
              class="fa fa-trash"
              @click="removeRole(r)"
              style="color: red; cursor: pointer"
              title="Remove"
            ></i>
            {{ r.user.name }}
          </li>
        </ol>
      </b-card-text>
    </b-card>
  </div>
</template>

<script>
  export default {
    props: ['role', 'full'],
    data() {
      return {
        loading: false,
        errors: [],
        meta: {
          currentPage: 1,
        },
        form: {
          user: null,
        },
        users: [],
      };
    },
    methods: {
      showRole() {
        if (!this.full) {
          this.$router.push({
            name: 'role-single',
            params: {
              role_id: this.role.id,
            },
          });
        }
      },
      removeRole(user_role) {
        axios
          .delete(`/api/v1/admin/user-roles/`, {
            params: {
              user_role_id: user_role.id,
            },
          })
          .then(results => {
            this.$root.$emit('sendMessage', 'User Role Removed', 'success');
            window.location.reload();
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to remove User Role', 'danger');
          });
      },
      loadUsers() {
        axios
          .get(`/api/v1/admin/users?page=${this.meta.currentPage}`)
          .then(results => {
            this.users = results.data.data;
            this.meta.currentPage = results.data.current_page;
            this.meta.total = results.data.total;
            this.meta.perPage = results.data.per_page;
            this.meta.lastPage = results.data.last_page;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to load Users');
          });
      },
      addUser(user) {
        axios
          .post(`/api/v1/admin/user-roles/`, {
            user_id: user,
            role_id: this.role.id,
          })
          .then(results => {
            this.$root.$emit('sendMessage', 'User Role Added', 'success');
            this.$emit('roleUpdated');
            this.loadUsers();
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to add User Role', 'danger');
          });
      },
    },

    computed: {
      userOptions() {
        return this.users
          .filter(user => {
            return user.rolesList.includes(this.role.name) === false;
          })
          .map(user => {
            return {
              text: user.name,
              value: user.id,
            };
          });
      },
    },
    created() {
      this.loadUsers();
    },
  };
</script>
