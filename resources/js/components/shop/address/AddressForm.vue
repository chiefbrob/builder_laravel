<template>
  <div>
    <b-form-group id="input-group-1" label-for="first_name">
      <b-form-input
        id="first_name"
        name="first_name"
        v-model="form.first_name"
        placeholder="First name"
        type="text"
        required
      ></b-form-input>
    </b-form-group>

    <field-error :solid="false" :errors="errors" field="first_name"></field-error>

    <b-form-group id="input-group-1" label-for="last_name">
      <b-form-input
        id="last_name"
        name="last_name"
        v-model="form.last_name"
        placeholder="Last name"
        type="text"
        required
      ></b-form-input>
    </b-form-group>

    <field-error :solid="false" :errors="errors" field="last_name"></field-error>

    <b-form-group id="input-group-5" label="Instructions">
      <textarea
        name="street_address"
        id="street_address"
        class="form-control"
        v-model="form.street_address"
        placeholder="e.g. town, street, building, floor and room number as relevant"
        rows="2"
        maxlength="255"
      ></textarea>
    </b-form-group>

    <field-error :solid="false" :errors="errors" field="street_address"></field-error>

    <phone-number @updated="newPhoneNumber"></phone-number>

    <field-error :solid="false" :errors="errors" field="phone_number"></field-error>

    <p class="pt-4">
      <b-button @click="submit" variant="info" class="text-white" size="sm">Save Address</b-button>
    </p>
  </div>
</template>

<script>
  export default {
    props: {
      address: {
        required: false,
      },
      errors: {
        required: true,
      },
    },
    data() {
      return {
        form: {
          first_name: null,
          last_name: null,
          street_address: null,
          phone_number: null,
        },
      };
    },
    methods: {
      submit() {
        this.$emit('submitted', this.form);
      },
      newPhoneNumber(number) {
        this.form.phone_number = number.countryCallingCode + number.nationalNumber;
      },
    },
  };
</script>
