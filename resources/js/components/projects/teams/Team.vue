<template>
  <div>
    <b-card @click="showTeam" :title="team.name" :sub-title="team.created_at | relative">
      <b-card-text>
        {{ team.description }}
      </b-card-text>
      <b-card-text v-if="full">
        <p>Team Members <b-button variant="link">New</b-button></p>
        <div>
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
    },
  };
</script>
