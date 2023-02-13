<template>
  <div>
    <b-card @click="showTask" :title="task.title" :sub-title="task.created_at | relative">
      <b-card-text>
        {{ task.description }}
      </b-card-text>
    </b-card>
  </div>
</template>

<script>
  export default {
    props: ['task', 'full'],
    data() {
      return {
        loading: false,
        errors: [],
      };
    },
    methods: {
      showTask() {
        if (!this.full) {
          this.$router.push({
            name: 'task-single',
            params: {
              task_id: this.task.id,
            },
          });
        }
      },
    },
  };
</script>
