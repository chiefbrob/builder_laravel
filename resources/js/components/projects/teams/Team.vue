<template>
  <div>
    <b-card>
      <b-card-title class="pointer">
        <span @click="showTeam">
          <span v-if="full">
            <span v-if="team.shortcode">[{{ team.shortcode }}]</span>
            {{ team.name }}
          </span>
          <span v-else>{{ team.name | shortform }}</span>
        </span>

        <b-button
          size="sm"
          variant="success"
          v-b-popover.hover.top="'Change team name details'"
          title="Edit Team"
          v-if="manager && full"
          @click="
            $router.push({
              name: 'team-edit',
              params: {
                team_id: team.id,
              },
            })
          "
          class="text-white float-right"
          ><i class="fa fa-pen"></i
        ></b-button>
        <b-button
          v-b-popover.hover.top="'Create a New Task in Team ' + team.name"
          title="Add Task"
          @click="
            $router.push({
              name: 'new-task',
              params: {
                team_id: team.id,
              },
            })
          "
          class="float-right text-white"
          size="sm"
          variant="info"
          ><i class="fa fa-plus"></i
        ></b-button>
      </b-card-title>
      <b-card-sub-title v-if="full"> {{ team.created_at | relative }} </b-card-sub-title>
      <b-card-text v-if="full">
        {{ team.description }}
      </b-card-text>
      <b-card-text v-if="full">
        <p>
          <b-button variant="link" size="sm" @click="showTeamMembers = !showTeamMembers">
            {{ showTeamMembers ? 'Hide Team Members' : 'Show Team Members' }}
          </b-button>

          <b-button variant="link" size="sm" @click="showTasks">Tasks</b-button>

          <b-button variant="link" size="sm" @click="showWorkflows">Workflows</b-button>
        </p>
        <div v-if="addingUser && showTeamMembers">
          <p class="my-4">
            <b-form-group title="Select user">
              <b-form-select v-model="newuser" :options="users"></b-form-select>
              <field-error :solid="false" :errors="errors" field="user_id"></field-error>
            </b-form-group>
          </p>
          <p>
            <b-button size="sm" v-if="!loading" @click="addTeamMember" :disabled="!newuser"
              >Add</b-button
            >

            <span v-else><i class="fa fa-spinner"></i> Loading...</span>
            <b-button size="sm" variant="danger" @click="addingUser = false">Cancel</b-button>
          </p>
        </div>
        <div v-else-if="showTeamMembers" class="row">
          <div class="col-md-4">
            <b-button variant="link" @click="addingUser = true" v-if="users.length > 0"
              >New Team Member</b-button
            >
          </div>
          <div v-for="(teamUser, index) in team.team_users" class="col-md-4" v-bind:key="index">
            <div>
              <p>
                <profile-image
                  style="width: 2em; float: left"
                  :user="teamUser.user"
                ></profile-image>
                <span class="ml-2 "
                  >{{ teamUser.user.name }}
                  <b v-if="team.user_id === teamUser.user.id">(manager)</b>
                </span>
              </p>
            </div>
          </div>
        </div>
      </b-card-text>
      <b-card-text v-if="full">
        <task-list v-if="team" :team="team"></task-list>
      </b-card-text>
      <b-card-text v-if="!full">
        <b-button variant="dark" size="sm" @click="showTasks"
          ><i class="fa fa-tasks"></i> Tasks</b-button
        >
        <b-button
          variant="dark"
          size="sm"
          :to="{
            name: 'workflows',
            params: {
              shortcode: team.shortcode,
            },
          }"
          ><i class="fa-solid fa-chart-gantt"></i> Workflows</b-button
        >
      </b-card-text>
    </b-card>
  </div>
</template>

<script>
  import ProfileImage from '../../home/ProfileImage';
  import TaskList from '../tasks/TaskList';
  export default {
    components: { ProfileImage, TaskList },
    props: ['team', 'full'],
    data() {
      return {
        addingUser: false,
        users: [],
        newuser: null,
        loading: false,
        errors: [],
        showTeamMembers: false,
      };
    },
    computed: {
      user() {
        return this.$store.getters.user;
      },
      manager() {
        return this.user.rolesList.includes('manager');
      },
    },
    methods: {
      showTeam() {
        if (!this.full) {
          this.$router.push({
            name: 'team-single',
            params: {
              team_id: this.team.id,
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
      showWorkflows() {
        this.$router.push({
          name: 'workflows',
          params: {
            shortcode: this.team.shortcode,
          },
        });
      },
      getUsers() {
        if (this.manager) {
          this.loading = true;
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
      addTeamMember() {
        this.loading = true;
        axios
          .post(`/api/v1/teams/${this.team.id}/users`, {
            user_id: this.newuser,
          })
          .then(results => {
            this.$root.$emit('sendMessage', 'User added to Team', 'success');
            window.location.reload();
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
