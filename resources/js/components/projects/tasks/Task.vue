<template>
  <div>
    <b-card class="bg-gradient-primary">
      <b-card-title>
        <span @click="showTask" class="pointer">{{ task.title }}</span>

        <b-badge :variant="taskStatusVariant(task.status)"> {{ task.status }} </b-badge>

        <b-button
          v-b-popover.hover.top="'this will create a sub-task of ' + task.title"
          title="Add Sub-Task"
          @click="addSubtask"
          class="float-right text-white"
          size="sm"
          variant="info"
        >
          <b-icon icon="plus"></b-icon>
        </b-button>
        <b-button
          size="sm"
          variant="success"
          @click="
            $router.push({
              name: 'task-edit',
              params: {
                team_id: task.team_id,
                task_id: task.id,
              },
            })
          "
          class="text-white float-right"
          ><i class="fa fa-pen"></i
        ></b-button>
      </b-card-title>
      <b-card-sub-title v-if="full" class="row">
        <b-input-group prepend="Assignee" class="col-md-4">
          <b-form-select
            v-model="assignee"
            :options="users"
            @input="assigneeChanged"
          ></b-form-select>
        </b-input-group>
      </b-card-sub-title>
      <b-card-text v-if="full">Created: {{ task.created_at | relative }}</b-card-text>
      <b-card-text v-if="full">{{ task.description }}</b-card-text>
      <b-form-checkbox
        v-if="full && task.openTasks && task.openTasks.length > 0"
        v-model="showSubtasks"
        class="ml-3 my-2"
        switch
        >Show subtasks</b-form-checkbox
      >
      <div class="container py-2" v-if="full && showSubtasks && task.openTasks">
        <div class="row">
          <b-card class="col-md-3" v-for="(subtask, i) in task.openTasks" v-bind:key="i">
            <b-card-title class="pointer" @click="showSubTask(subtask)"
              >{{ subtask.title }}

              <b-button
                v-b-popover.hover.top="'this will create a sub-task of ' + subtask.title"
                title="Add Sub-Task"
                @click="addSubtask(subtask)"
                class="float-right text-white"
                size="sm"
                variant="info"
              >
                <b-icon icon="plus"></b-icon>
              </b-button>
            </b-card-title>
            <b-card-sub-title>Created: {{ subtask.created_at | relative }}</b-card-sub-title>
            <b-card-text>{{ subtask.status }}</b-card-text>
          </b-card>
        </div>
      </div>
      <div class=" py-2" v-if="!full && !showSubtasks && task.openTasks">
        <p>
          Subtasks:
          <span v-for="(t, i) in task.openTasks" v-bind:key="i">
            <a :href="`/teams/${task.team_id}/tasks/${t.id}`" v-if="i < 3">
              {{ t.title }}
            </a>
            <a v-if="i === 3" :href="`/teams/${task.team_id}/tasks/${task.id}`">...</a>
          </span>
        </p>
      </div>
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
        assignee: this.task.assigned_to,
        showSubtasks: this.full,
      };
    },
    computed: {
      users() {
        let u = this.task.team?.team_users.map(teamUser => {
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
      taskStatusVariant(status) {
        switch (status) {
          case 'open':
            return 'danger';
            break;

          case 'ready':
            return 'light';
            break;

          case 'doing':
            return 'primary';
            break;

          case 'reviewing':
            return 'info';
            break;

          case 'done':
            return 'success';
            break;

          case 'cancelled':
            return 'secondary';
            break;

          default:
            return 'danger';
            break;
        }
      },
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
      addSubtask(task = null) {
        let focusTask = this.task;
        if (task) {
          focusTask = task;
        }
        this.$router.push({
          name: 'new-subtask',
          params: { team_id: this.task.team_id, task_id: focusTask.id },
        });
      },
      assigneeChanged(data) {
        let form = {
          ...this.task,
          assigned_to: data,
        };
        axios
          .put(`/api/v1/tasks/${this.task.id}`, form)
          .then(results => {
            this.$root.$emit('sendMessage', 'Task Assigned', 'success');
            window.location.reload();
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to assign task!');
          });
      },
      showSubTask(subtask) {
        return (window.location = `/teams/${subtask.team_id}/tasks/${subtask.id}`);
      },
    },
  };
</script>
