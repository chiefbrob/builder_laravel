<template>
  <div>
    <b-form @submit.prevent="submitForm">
      <b-form-group id="input-group-1" label="Name: *" label-for="variant-name">
        <b-form-input id="variant-name" v-model="form.name" type="text" required></b-form-input>
      </b-form-group>
      <field-error :solid="false" :errors="errors" field="name"></field-error>

      <b-form-group id="input-group-2" label="Quantity: *" label-for="quantity">
        <b-form-input
          id="variant-quantity"
          v-model="form.quantity"
          type="number"
          step="0"
          required
        ></b-form-input>
      </b-form-group>
      <field-error :solid="false" :errors="errors" field="quantity"></field-error>

      <b-form-group label="Photo:" label-cols-sm="2">
        <b-form-file @change="imageUpdated" size="sm" accept=".jpg, .jpeg, .png"></b-form-file>
      </b-form-group>

      <field-error :solid="false" :errors="errors" field="photo"></field-error>

      <text-editor :contents="variant ? variant.description : ''"></text-editor>

      <input type="submit" class="btn btn-sm btn-success mt-2" />
    </b-form>
  </div>
</template>

<script>
  import TextEditor from '../../shared/TextEditor';
  export default {
    components: { TextEditor },
    props: {
      variant: {
        required: false,
        default: null,
      },
      errors: {
        required: false,
      },
    },
    data() {
      return {
        form: {
          name: null,
          description: null,
          quantity: 1,
          photo: null,
        },
      };
    },
    methods: {
      submitForm() {
        this.$emit('submitted', this.form);
      },
      imageUpdated(img) {
        this.form.photo = img.target.files[0];
      },
    },
  };
</script>
