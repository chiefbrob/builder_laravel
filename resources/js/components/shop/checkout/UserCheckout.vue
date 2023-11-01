<template>
  <b-tabs content-class="mt-3">
    <b-tab title="Address" active>
      <address-manager></address-manager>
    </b-tab>
    <b-tab title="Payment Method">
      <div>
        <p>Cash or M-Pesa on Delivery for Nairobi CBD</p>
        <p>
          <b>Free Delivery within Nairobi CBD</b> <br />
          <span style="font-weight: bold; color: red">NOTE:</span>
          Orders shipping out of Nairobi would incur additional delivery charges and are paid for
          <u>before shipping</u>.
        </p>
        <p>Returns accepted for selected products</p>
      </div>
    </b-tab>
  </b-tabs>
</template>

<script>
  import AddressManager from '../address/AddressManager.vue';
  export default {
    components: { AddressManager },
  };
</script>
