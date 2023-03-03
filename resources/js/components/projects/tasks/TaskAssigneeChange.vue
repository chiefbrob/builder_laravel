<template>
  <b-form-select v-model="assignee" :options="users" @input="assigneeChanged"></b-form-select>
</template>

<script>
  export default {
    props: {
      task: {
        required: false,
      },
      members: {
        required: false,
      },
    },
    data() {
      return {
        assignee: this.task?.assigned_to,
      };
    },
    computed: {
      users() {
        let u = this.members.map(teamUser => {
          return {
            value: teamUser.user.id,
            text: teamUser.user.name,
          };
        });
        u.unshift({ value: null, text: 'Select Assignee', disabled: true });
        return u;
      },
    },
    methods: {
      assigneeChanged(data) {
        if (!this.task) {
          return this.$emit('assigneeChanged', data);
        }
        let form = {
          ...this.task,
          assigned_to: data,
        };
        axios
          .put(`/api/v1/tasks/${this.task.id}`, form)
          .then(results => {
            this.$emit('taskUpdated', results.data);
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to assign task!');
          });
      },
    },
  };
</script>
