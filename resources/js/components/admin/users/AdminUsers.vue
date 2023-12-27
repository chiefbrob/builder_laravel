<template>
  <div>
    <div class="row">
      <b-card
        bg-variant="info"
        border-variant="light"
        text-variant="light"
        class="col-md-3"
        v-for="(user, index) in items"
        v-bind:key="index"
      >
        <b-card-title> {{ user.name }} </b-card-title>
        <b-card-sub-title>{{ user.email }}</b-card-sub-title>

        <b-card-text>
          @{{ user.username }} <br />
          Registered: {{ user.created_at | relative }}
        </b-card-text>

        <b-card-text>
          Verified:
          <b-button size="sm" variant="success" v-if="user.verified_at">{{
            user.verified_at | relative
          }}</b-button>

          <b-button size="sm" v-else variant="warning">-unverified-</b-button>
        </b-card-text>
        <b-card-text v-if="user.id !== currentuser.id">
          <b-button size="sm" variant="danger" href="#" @click="deleteUser(user)">
            <i class="fa fa-trash"></i>
          </b-button>
          <b-button size="sm" variant="dark" @click="loginAs(user)"
            ><i class="fa fa-user"></i> Login</b-button
          >
        </b-card-text>
      </b-card>
    </div>

    <b-pagination
      @input="pageChanged"
      v-model="meta.currentPage"
      v-if="meta.lastPage > 1"
      :total-rows="meta.total"
      :per-page="meta.perPage"
      aria-controls="admin-users"
    ></b-pagination>
    <hr />
  </div>
</template>

<script>
  export default {
    data() {
      return {
        meta: {
          currentPage: 1,
          total: 1,
          perPage: 1,
          lastPage: 1,
        },

        fields: [
          { key: 'id', sortable: true },
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
      currentuser() {
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
            this.$root.$emit('sendMessage', 'Failed Delete User');
          });
      },
      pageChanged(page) {
        this.currentPage = page;
        this.loadUsers();
      },
      loadUsers() {
        axios
          .get(`/api/v1/admin/users?page=${this.meta.currentPage}`)
          .then(results => {
            this.items = results.data.data;
            this.meta.currentPage = results.data.current_page;
            this.meta.total = results.data.total;
            this.meta.perPage = results.data.per_page;
            this.meta.lastPage = results.data.last_page;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to load Admin Users');
          });
      },
      loginAs(user) {
        this.$root.$emit('sendMessage', 'Logging in ...', 'success');

        axios
          .post(`/api/v1/admin/users/loginAs`, {
            user_id: user.id,
          })
          .then(results => {
            this.$root.$emit('sendMessage', `Logged in as ${user.name}. Reloading`, 'info');

            setTimeout(() => {
              window.location = '/';
            }, 500);
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to login as user');
          });
      },
    },
  };
</script>
