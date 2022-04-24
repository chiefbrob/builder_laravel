<template>
  <div :class="solid ? 'alert alert-danger' : 'text-danger'" v-if="hasErrorsForField">
    <span v-for="(error, repo) in errors" :key="repo">
      <span v-if="repo == field">
        <ul>
          <li v-for="(item, index) in error" :key="index">
            {{ item }}
          </li>
        </ul>
      </span>
    </span>
  </div>
</template>

<script>
  export default {
    props: {
      errors: { type: Array | Object },
      field: { type: String },
      solid: { default: true, type: Boolean },
    },
    computed: {
      hasErrorsForField() {
        return !_.isEmpty(this.errors) && this.errors[this.field] !== undefined;
      },
    },
  };
</script>

<style></style>
