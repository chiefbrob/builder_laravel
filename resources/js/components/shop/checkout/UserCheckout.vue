<template>
  <div class="row">
    <address-manager class="col-md-12"></address-manager>
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
  </div>
</template>

<script>
  import AddressManager from '../address/AddressManager.vue';
  export default {
    components: { AddressManager },
  };
</script>
