<template>
  <div>
    <b-card @click="showTask">
      <b-card-title class="pointer">{{ task.title }}</b-card-title>
      <b-card-sub-title> {{ task.status }} </b-card-sub-title>
      <b-card-text v-if="full"> Created: {{ task.created_at | relative }} </b-card-text>
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
