<template>
  <div>
    <form class="py-3 row" enctype="multipart/form-data" @submit.prevent="submitForm" method="POST">
      <div class="col-md-12">
        <b-form-group id="input-group-1" label="Name: *" label-for="name">
          <b-form-input id="name" v-model="form.name" type="text" required></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="name"></field-error>

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
      role: {
        required: false,
      },
      errors: {
        required: true,
      },
    },
    data() {
      return {
        form: {
          name: null,
          description: null,
        },
      };
    },
    created() {
      this.setDefaults();
    },
    methods: {
      setDefaults() {
        if (this.role) {
          this.form.name = this.role.name;
          this.form.description = this.role.description;
        }
      },

      submitForm() {
        this.$emit('submit', this.form);
      },
    },
  };
</script>
