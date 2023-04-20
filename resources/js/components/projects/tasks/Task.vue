<template>
  <div>
    <b-card class="bg-gradient-primary">
      <b-card-title>
        <span @click="showTask" class="pointer">
          <span v-if="full">{{ task.title }}</span>
          <span v-else>{{ task.title | shortform }}</span>
        </span>
        <b-badge class="float-right" :variant="taskStatusVariant(task.status)">
          {{ task.status }}
        </b-badge>
      </b-card-title>

      <b-card-sub-title v-if="full" class="row">
        <div class="col-md-4">
          <task-assignee-change
            :members="task.team.team_users"
            @taskUpdated="taskUpdated"
            :task="task"
          ></task-assignee-change>
        </div>
        <div class="col-md-4">
          <task-status-change @taskUpdated="taskUpdated" :task="task"></task-status-change>
        </div>
      </b-card-sub-title>
      <b-card-text :class="full ? 'py-2' : ''">
        <b-button
          v-b-popover.hover.top="'create a sub-task of ' + task.title"
          title="Add Sub-Task"
          @click="addSubtask(task)"
          class="text-white"
          size="sm"
          variant="info"
        >
          <b-icon icon="plus"></b-icon> Add Subtask
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
                task_slug: $root.$slugify(task.title),
              },
            })
          "
          class="text-white"
          ><i class="fa fa-pen"></i> Edit</b-button
        >
      </b-card-text>
      <b-card-text v-if="full">Created: {{ task.created_at | relative }}</b-card-text>
      <b-card-text v-if="full">{{ task.description }}</b-card-text>
      <b-form-checkbox
        v-if="full && task.subTasks && task.subTasks.length > 0"
        v-model="showSubtasks"
        class="ml-3 my-2"
        switch
        >Show subtasks</b-form-checkbox
      >
      <div class="container py-2" v-if="full && showSubtasks && task.subTasks">
        <div class="row">
          <b-card class="col-md-4" v-for="(subtask, i) in task.subTasks" v-bind:key="i">
            <b-card-title class="pointer" @click="showSubTask(subtask)"
              >{{ subtask.title | shortform }}

              <b-button
                v-b-popover.hover.top="'create a sub-task of ' + subtask.title"
                title="Add Sub-Task"
                @click="addSubtask(subtask)"
                class="float-right text-white"
                size="sm"
                variant="info"
              >
                <b-icon icon="plus"></b-icon>
              </b-button>
            </b-card-title>
            <b-card-text>
              {{ subtask.created_at | relative }}
              <b-badge :variant="taskStatusVariant(subtask.status)">
                {{ subtask.status }}
              </b-badge>
            </b-card-text>
          </b-card>
        </div>
      </div>
      <div class=" py-2" v-if="!full && !showSubtasks && task.openTasks.length > 0">
        <p>
          Subtasks:
          <span v-for="(t, i) in task.openTasks" v-bind:key="i">
            <b-button v-if="i < 3" variant="link" class="p-0 m-0" @click="openTask(t)"
              >{{ t.title | shortform }}
            </b-button>

            <b-button v-if="i === 3" variant="link" class="p-0 m-0" @click="openTask(task)"
              >{{ task.openTasks.length - i }} more
            </b-button>
          </span>
        </p>
      </div>
    </b-card>
  </div>
</template>

<script>
  import TaskAssigneeChange from './TaskAssigneeChange';
  import TaskStatusChange from './TaskStatusChange';
  export default {
    props: ['task', 'full'],
    components: { TaskAssigneeChange, TaskStatusChange },
    data() {
      return {
        loading: false,
        errors: [],
        showSubtasks: this.full,
      };
    },

    computed: {},
    methods: {
      taskStatusVariant(status) {
        switch (status) {
          case 'open':
            return 'light';
            break;

          case 'ready':
            return 'danger';
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
          this.openTask(this.task);
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

      showSubTask(subtask) {
        this.openTask(subtask);
      },
      openTask(task) {
        this.$router.push({
          name: 'task-single',
          params: {
            task_id: task.id,
            team_id: task.team_id,
            task_slug: this.$root.$slugify(task.title),
          },
        });
      },
      taskUpdated(task) {
        this.$emit('taskUpdated', task);
      },
    },
  };
</script>
