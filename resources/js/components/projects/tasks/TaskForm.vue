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

        <p class="py-3">
          <input type="submit" class="btn btn-success" text="Submit" />
        </p>
      </div>
    </form>
  </div>
</template>

<script>
  export default {
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
        },
      };
    },
    created() {
      this.setDefaults();
    },
    methods: {
      setDefaults() {
        if (this.task) {
          this.form.title = this.teak.title;
          this.form.description = this.task.description;
        }
      },

      submitForm() {
        this.$emit('submit', this.form);
      },
    },
  };
</script>
