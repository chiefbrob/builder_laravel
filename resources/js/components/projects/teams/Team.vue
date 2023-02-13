<template>
  <div>
    <b-card>
      <b-card-title v-text="team.name" class="pointer" @click="showTeam"></b-card-title>
      <b-card-sub-title v-if="full"> {{ team.created_at | relative }} </b-card-sub-title>
      <b-card-text>
        {{ team.description }}
      </b-card-text>
      <b-card-text v-if="full">
        <p>
          Team Members <b-button variant="link" @click="addingUser = true">New</b-button>
          <b-button variant="link" @click="showTasks">Tasks</b-button>
        </p>
        <div v-if="addingUser">
          <p class="my-4">
            <b-form-group title="Select user">
              <b-form-select v-model="newuser" :options="users"></b-form-select>
              <field-error :solid="false" :errors="errors" field="user_id"></field-error>
            </b-form-group>
          </p>
          <p>
            <b-button v-if="!loading" @click="addUser" :disabled="!newuser">Add</b-button>
            <span v-else><i class="fa fa-spinner"></i> Loading...</span>
          </p>
        </div>
        <div v-else>
          <div v-for="(teamUser, index) in team.team_users" v-bind:key="index">
            <p>
              <profile-image style="width: 2em; float: left" :user="teamUser.user"></profile-image>
              <span class="ml-2 "
                >{{ teamUser.user.name }}
                <b v-if="team.user_id === teamUser.user.id">(admin)</b>
              </span>
            </p>
          </div>
        </div>
      </b-card-text>
    </b-card>
  </div>
</template>

<script>
  import ProfileImage from '../../home/ProfileImage';
  export default {
    components: { ProfileImage },
    props: ['team', 'full'],
    data() {
      return {
        addingUser: false,
        users: [],
        newuser: null,
        loading: false,
        errors: [],
      };
    },
    computed: {
      user() {
        return this.$store.getters.user;
      },
    },
    methods: {
      showTeam() {
        if (!this.full) {
          this.$router.push({
            name: 'team-single',
            params: {
              id: this.team.id,
            },
          });
        }
      },
      showTasks() {
        this.$router.push({
          name: 'tasks',
          params: {
            team_id: this.team.id,
          },
        });
      },

      getUsers() {
        this.loading = true;
        if (this.user.rolesList.includes('manager') || this.user.admin) {
          axios
            .get(`/api/v1/users`, {
              params: {
                team_id: this.team.id,
              },
            })
            .then(results => {
              this.users = results.data.data.map(user => {
                return {
                  text: user.name + ' ' + user.email,
                  value: user.id,
                };
              });
            })
            .catch(error => {
              this.$root.$emit('sendMessage', 'Failed to get users');
            })
            .finally(f => {
              this.loading = false;
            });
        }
      },
      addUser() {
        this.loading = true;
        axios
          .post(`/api/v1/admin/teams/${this.team.id}/users`, {
            user_id: this.newuser,
          })
          .then(results => {
            this.$root.$emit('sendMessage', 'User added to Team', 'success');
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to add user to Team');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
    created() {
      this.getUsers();
    },
  };
</script>
