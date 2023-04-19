<template>
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
    id="team-user-selector"
    placeholder="Select assignee"
  ></multiselect>
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
        selectedUsers: [],
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
