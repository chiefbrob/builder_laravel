<template>
  <div class="row">
    <div class="col-md-12">
      <h5>
        Delivery Address
        <b-button :to="{ name: 'profile' }" size="sm" variant="info" class="text-white float-right "
          ><i class="fa fa-cogs"></i> Manage your addresses</b-button
        >
      </h5>
      <address-selector @updated="addressUpdated"></address-selector>
    </div>
    <div class="col-md-12 py-3">
      <p>
        <b>Free Delivery within Nairobi CBD</b> <br />
        Cash or M-Pesa on Delivery for Nairobi CBD
      </p>
      <p>
        <span style="font-weight: bold; color: red">NOTE:</span>
        Orders shipping out of Nairobi would incur additional delivery charges and are paid for
        <u>before shipping</u>.
      </p>
      <p>Returns accepted for selected products</p>
    </div>
    <div class="col-md-12">
      <b-button
        @click="submitOrder"
        size="sm"
        variant="success"
        :disabled="!formComplete || loading"
        ><i class="fa fa-check-circle"></i> Confirm Order</b-button
      >
      <span v-if="loading"><i class="fa fa-spinner"></i> Loading...</span>
    </div>
  </div>
</template>

<script>
  import AddressSelector from '../address/AddressSelector.vue';
  export default {
    components: { AddressSelector },
    data() {
      return {
        form: {
          address_id: null,
          payment_method_id: 3,
        },
        loading: false,
      };
    },
    computed: {
      formComplete() {
        return this.form.address_id !== null;
      },
    },
    methods: {
      addressUpdated(address) {
        this.form.address_id = address;
      },
      submitOrder() {
        this.loading = true;
        axios
          .post('/api/v1/checkout', this.form)
          .then(results => {
            this.$root.$emit('sendMessage', 'Order Created', 'success');
            setTimeout(() => {
              this.$router.push({ name: 'orders' });
            }, 500);
          })
          .catch(e => {
            this.$root.$emit('sendMessage', 'Failed to create order');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
