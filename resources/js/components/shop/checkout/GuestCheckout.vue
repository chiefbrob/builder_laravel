<template>
  <b-card>
    <b-card-title> <i class="fa fa-user"></i> Details </b-card-title>
    <b-card-body>
      <b-form-group id="input-group-2" label-for="first_name">
        <b-form-input
          id="first_name"
          name="first_name"
          placeholder="Name"
          v-model="form.first_name"
          type="text"
          required
        ></b-form-input>
      </b-form-group>

      <field-error :solid="false" :errors="errors" field="first_name"></field-error>

      <b-form-group id="input-group-3" label-for="email">
        <b-form-input
          placeholder="Email"
          id="email"
          name="email"
          v-model="form.email"
          type="email"
        ></b-form-input>
      </b-form-group>

      <field-error :solid="false" :errors="errors" field="email"></field-error>

      <b-form-group id="input-group-4" label-for="phone_number">
        <phone-number @updated="newPhoneNumber" :number="form.phone_number"></phone-number>
      </b-form-group>

      <field-error :solid="false" :errors="errors" field="phone_number"></field-error>

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

      <b-button size="sm" variant="success" @click="submit"
        ><i class="fa fa-check-circle"></i> Pay Cash on Delivery</b-button
      >
    </b-card-body>
  </b-card>
</template>

<script>
  export default {
    data() {
      return {
        form: {
          first_name: null,
          email: null,
          phone_number: null,
          street_address: null,
          payment_method_id: 3, //cash on delivery
        },
        errors: [],
        loading: false,
      };
    },
    created() {},
    methods: {
      newPhoneNumber(number) {
        this.form.phone_number = number.countryCallingCode + number.nationalNumber;
      },
      submit() {
        this.loading = true;
        this.errors = [];
        axios
          .post('/api/v1/checkout', this.form)
          .then(results => {
            this.$root.$emit('sendMessage', 'Checkout Success', 'success');

            console.log(results);
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to checkout!');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
