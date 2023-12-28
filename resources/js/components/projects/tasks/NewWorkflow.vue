<template>
  <span>
    <b-button
      v-b-modal="'task-to-template-modal-' + task.id"
      class="float-right"
      v-if="manager"
      size="sm"
      variant="dark"
      ><i class="fa fa-check-circle"></i> New Workflow</b-button
    >

    <b-modal
      ok-only
      :ref="'task-to-template-modal-' + task.id"
      :id="'task-to-template-modal-' + task.id"
      title="New Workflow"
      @ok="createWorkflow"
    >
      <h6>{{ task.title }}</h6>
      <p>A Workflow is a task with its subtasks that can be recreated</p>
      <p>
        <b>Private</b> workflow can only be used within this team. <b>Public</b> workflows can be
        accessed by anyone with manager role
      </p>
      <b-form-group label="Title">
        <b-form-input type="text" v-model="workflowForm.title"></b-form-input>

        <field-error :solid="false" :errors="workflowErrors" field="title"></field-error>
      </b-form-group>
      <b-form-group>
        <b-form-checkbox v-model="publicTemplate">Public</b-form-checkbox>

        <field-error :solid="false" :errors="workflowErrors" field="team_id"></field-error>
      </b-form-group>
      <b-form-group>
        <textarea
          name=""
          placeholder="optional description"
          :id="`task-textarea-` + task.id"
          class="form-control"
          v-model="workflowForm.description"
          rows="4"
        ></textarea>
        <field-error :solid="false" :errors="workflowErrors" field="description"></field-error>
      </b-form-group>
    </b-modal>
  </span>
</template>

<script>
  export default {
    props: ['task'],
    data() {
      return {
        workflowForm: {
          title: this.task.title + ' Workflow',
          description: null,
        },
        workflowErrors: [],
        publicTemplate: false,
      };
    },
    computed: {
      manager() {
        return window.User.rolesList.includes('manager');
      },
    },
    methods: {
      createWorkflow(e) {
        e.preventDefault();
        this.loading = true;
        const form = {
          ...this.workflowForm,
          ...{
            team_id: this.publicTemplate ? null : this.task.team_id,
            task_id: this.task.id,
          },
        };
        axios
          .post('/api/v1/tasks/task-templates/', form)
          .then(response => {
            this.$bvModal.hide('task-to-template-modal-' + task.id);
            this.$root.$emit('sendMessage', 'Workflow Created', 'success');
            this.$router.push({
              name: 'workflows',
              params: { shortcode: this.task.team.shortcode },
            });
          })
          .catch(({ response }) => {
            this.workflowErrors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to Create Workflow');
          })
          .finally(f => {
            this.loading = false;
          });
        console.log();
      },
    },
  };
</script>
