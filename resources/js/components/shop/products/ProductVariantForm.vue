<template>
  <div>
    <b-form @submit.prevent="submitForm">
      <b-form-group id="input-group-1" label="Name: *" label-for="variant-name">
        <b-form-input id="variant-name" v-model="form.name" type="text" required></b-form-input>
      </b-form-group>
      <field-error :solid="false" :errors="errors" field="name"></field-error>

      <b-form-group id="input-group-2" label="Quantity: *" label-for="variant-quantity">
        <b-form-input
          id="variant-quantity"
          v-model="form.quantity"
          type="number"
          step="0"
          required
        ></b-form-input>
      </b-form-group>
      <field-error :solid="false" :errors="errors" field="quantity"></field-error>

      <div>
        <p v-if="variant && variant.photo" style="text-align: center;">
          <img
            style="max-width: 7em;"
            :src="`/storage/images/product-variants/${variant.photo}`"
            alt=""
          />
          <b-form-checkbox
            id="checkbox-1"
            v-model="replacePhoto"
            name="checkbox-1"
            value="accepted"
            unchecked-value="not_accepted"
          >
            Replace variant's photo
          </b-form-checkbox>
        </p>
        <b-form-group label="Photo:" label-cols-sm="2" v-if="showAttachPhoto">
          <b-form-file @change="imageUpdated" size="sm" accept=".jpg, .jpeg, .png"></b-form-file>
        </b-form-group>
      </div>
      <field-error :solid="false" :errors="errors" field="photo"></field-error>

      <text-editor
        :contents="variant ? variant.description : ''"
        @contentsUpdated="descriptionUpdated"
      ></text-editor>

      <input type="submit" class="btn btn-sm btn-success mt-2" />
    </b-form>
  </div>
</template>

<script>
  import TextEditor from '../../shared/TextEditor.vue';
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
          description: '',
          quantity: 1,
          photo: null,
        },
        replacePhoto: 'not_accepted',
      };
    },
    computed: {
      showAttachPhoto() {
        return (
          this.replacePhoto === 'accepted' || !this.variant || (this.variant && !this.variant.photo)
        );
      },
    },
    created() {
      this.loadDefaults();
    },
    methods: {
      submitForm() {
        this.$emit('submitted', this.form);
      },
      imageUpdated(img) {
        this.form.photo = img.target.files[0];
      },
      loadDefaults() {
        if (this.variant) {
          this.form.name = this.variant.name;
          this.form.description = this.variant.description;
          this.form.quantity = this.variant.quantity;
        }
      },
      descriptionUpdated(text) {
        this.form.description = text;
      },
    },
  };
</script>
