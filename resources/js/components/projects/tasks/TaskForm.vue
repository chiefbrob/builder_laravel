<template>
  <div>
    <form class="py-3 row" enctype="multipart/form-data" @submit.prevent="submitForm" method="POST">
      <div class="col-md-12">
        <b-form-group id="input-group-1" label="Title: *" label-for="title">
          <b-form-input id="title" v-model="form.title" type="text" required></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="title"></field-error>

        <b-form-group label="Description:">
          <b-form-textarea id="textarea" v-model="form.description" rows="5"></b-form-textarea>
        </b-form-group>

        <field-error :solid="false" :errors="errors" field="description"></field-error>

        <b-form-group label="Assignee:">
          <task-assignee-change
            :members="team.team_users"
            :task="task"
            @assigneeChanged="assigneeChanged"
          ></task-assignee-change>
        </b-form-group>

        <b-form-group label="Status:">
          <task-status-change :task="task" @statusChange="statusChanged"></task-status-change>
        </b-form-group>

        <p>
          <b-form-checkbox
            v-if="!task"
            class="float: right"
            id="checkbox-1"
            v-model="form.another"
            name="another"
            value="accepted"
            unchecked-value="not_accepted"
          >
            Create and Create another
          </b-form-checkbox>
        </p>

        <p class="py-3">
          <input type="submit" class="btn btn-success" text="Submit" />
        </p>
      </div>
    </form>
  </div>
</template>

<script>
  import TaskAssigneeChange from './TaskAssigneeChange';
  import TaskStatusChange from './TaskStatusChange';
  export default {
    components: { TaskAssigneeChange, TaskStatusChange },
    props: {
      task: {
        required: false,
      },
      errors: {
        required: true,
      },
      team: {
        required: true,
      },
    },
    data() {
      return {
        form: {
          title: null,
          description: null,
          team_id: this.team.id,
          another: 'not_accepted',
        },
      };
    },
    created() {
      this.setDefaults();
    },
    methods: {
      setDefaults() {
        if (this.task) {
          this.form.title = this.task.title;
          this.form.description = this.task.description;
        }
      },
      reset() {
        this.form.title = null;
        this.form.description = null;
      },
      taskUpdated(task) {
        this.$emit('taskUpdated', task);
      },
      assigneeChanged(assignee) {
        this.form.assigned_to = assignee;
      },
      statusChanged(status) {
        this.form.status = status;
      },

      submitForm() {
        let task_id = this.$router.currentRoute.params.task_id;
        if (task_id) {
          this.form.task_id = task_id;
        }
        this.$emit('submit', this.form);
        this.reset();
      },
    },
  };
</script>
