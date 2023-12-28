<template>
  <b-card>
    <b-card-title> <i class="fa fa-chart-gantt"></i> {{ workflow.title }} </b-card-title>
    <b-card-sub-title>
      <div v-if="workflow.team_id">
        <b-button
          size="sm"
          variant="link"
          :to="{
            name: 'team-single',
            params: {
              team_id: workflow.team_id,
            },
          }"
          >{{ teamName }}</b-button
        >
        | {{ workflow.created_at | relative }}
      </div>
      <div v-else>Public | {{ workflow.created_at | relative }}</div>
    </b-card-sub-title>
    <b-card-text v-if="workflow.description">
      <div v-html="workflow.description"></div>
    </b-card-text>
    <b-card-footer>
      <b-button
        v-b-modal="'use-workflow-' + workflow.id"
        size="sm"
        variant="info"
        class="text-white"
        >Use
      </b-button>
      <b-modal
        ok-only
        :ok-disabled="!workflow.team_id && !form.team_id"
        :ref="'use-workflow-' + workflow.id"
        :id="'use-workflow-' + workflow.id"
        title="Use Workflow"
        @ok="useWorkflow"
      >
        <template #modal-title> <i class="fa fa-chart-gantt"></i> {{ workflow.title }} </template>
        <p>Creates a new task</p>
        <b-form-group v-if="!workflow.team_id" label="Select Team">
          <b-form-select :options="teamOptions" v-model="form.team_id"></b-form-select>
        </b-form-group>
      </b-modal>
      <b-button v-if="false" size="sm" variant="danger" class="text-white"
        ><i class="fa fa-trash"></i>
      </b-button>
    </b-card-footer>
  </b-card>
</template>

<script>
  export default {
    props: ['workflow', 'teams'],
    data() {
      return {
        loading: false,
        errors: [],
        form: {
          team_id: this.workflow.team_id,
          task_template_id: this.workflow.id,
        },
      };
    },
    computed: {
      teamName() {
        if (!this.workflow.team_id) {
          return 'Public';
        }
        let team = this.teams.filter(t => t.id === this.workflow.team_id);
        return team.length === 0 ? 'loading team' : team[0]?.name;
      },
      teamOptions() {
        return this.teams.map(t => {
          return {
            value: t.id,
            text: t.name,
          };
        });
      },
    },
    methods: {
      useWorkflow() {
        this.loading = true;
        axios
          .post(`/api/v1/tasks/task-templates/${this.workflow.id}/create`, this.form)
          .then(results => {
            const task = results.data;
            this.$router.push({
              name: 'task-edit',
              params: {
                task_id: task.id,
                team_id: task.team_id,
                task_slug: this.$root.$slugify(task.title),
              },
            });
          })
          .catch(e => {
            this.$root.$emit('sendMessage', 'Failed to use workflow');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
