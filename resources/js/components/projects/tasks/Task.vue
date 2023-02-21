<template>
  <div>
    <b-card>
      <b-card-title>
        <span @click="showTask" class="pointer"> {{ task.title }} </span>

        <b-button
          v-b-popover.hover.top="'this will create a sub-task of ' + task.title"
          title="Add Sub-Task"
          @click="addSubtask"
          class="float-right text-white"
          size="sm"
          variant="info"
          ><i class="fa fa-plus"></i
        ></b-button>
      </b-card-title>
      <b-card-sub-title>ID: {{ task.id }} Status: {{ task.status }} </b-card-sub-title>
      <b-card-text v-if="full"> Created: {{ task.created_at | relative }} </b-card-text>
      <b-card-text v-if="full">
        {{ task.description }}
      </b-card-text>
    </b-card>
    <div class="row" v-if="full">
      <task class="col-md-3" v-for="(t, i) in task.openTasks" v-bind:key="i" :task="t"></task>
    </div>
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
              team_id: this.task.team_id,
            },
          });
        }
      },
      addSubtask() {
        this.$router.push({
          name: 'new-subtask',
          params: { team_id: this.task.team_id, task_id: this.task.id },
        });
      },
    },
  };
</script>
