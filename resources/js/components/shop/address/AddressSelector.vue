<template>
  <b-form-select
    v-model="form.address"
    :options="addressOptions"
    @input="addressSelected"
  ></b-form-select>
</template>

<script>
  export default {
    data() {
      return {
        addresses: [],
        errors: [],
        form: {
          address: null,
        },
        loading: true,
      };
    },
    computed: {
      addressOptions() {
        return this.addresses.map(address => {
          return { value: address.id, text: address.street_address };
        });
      },
    },
    created() {
      this.loadAddresses();
      if (window.User.default_address_id) {
        this.form.address = window.User.default_address_id;
        this.addressSelected(this.form.address);
      }
    },
    methods: {
      addressSelected(address) {
        this.$emit('updated', address);
      },
      loadAddresses() {
        this.loading = true;
        axios
          .get('/api/v1/addresses')
          .then(results => {
            this.addresses = results.data.data;
          })
          .catch(e => {
            this.$root.$emit('sendMessage', 'Failed to load addresses');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
