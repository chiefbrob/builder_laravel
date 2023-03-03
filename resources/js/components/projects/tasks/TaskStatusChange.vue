<template>
  <b-form-select v-model="status" :options="statuses" @input="statusChanged"></b-form-select>
</template>

<script>
  export default {
    props: {
      task: {
        required: false,
      },
    },
    data() {
      return {
        status: this.task ? this.task.status : 'open',
      };
    },
    computed: {
      statuses() {
        let s = ['open', 'ready', 'doing', 'reviewing', 'done', 'cancelled'];
        return s.map(value => {
          return {
            text: value,
            value: value,
          };
        });
      },
    },
    methods: {
      statusChanged(data) {
        if (!this.task) {
          return this.$emit('statusChange', data);
        }
        let form = {
          ...this.task,
          status: data,
        };
        axios
          .put(`/api/v1/tasks/${this.task.id}`, form)
          .then(results => {
            this.$emit('taskUpdated', results.data);
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to update task status!');
          });
      },
    },
  };
</script>
