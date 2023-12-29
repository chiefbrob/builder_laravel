<template>
  <div>
    <multiselect
      :close-on-select="false"
      :searchable="true"
      :multiple="true"
      v-model="selectedUsers"
      track-by="id"
      :options="userOptions"
      :custom-label="name"
      @input="updated"
      :allow-empty="true"
      style="padding: 0;"
      id="team-user-selector"
      placeholder="Select assignee"
    ></multiselect>
  </div>
</template>

<script>
  export default {
    props: {
      multiple: {
        type: Boolean,
        default: true,
      },
      team: {
        required: true,
      },
    },
    data() {
      return {
        selectedUsers: [window.User],
      };
    },
    computed: {
      userOptions() {
        return this.team.team_users.map(team_user => {
          return team_user.user;
        });
      },
    },
    created() {},
    methods: {
      name(data) {
        return data.name;
      },
      updated(data) {
        this.$emit('updated', this.selectedUsers);
      },
    },
  };
</script>
