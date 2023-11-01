<template>
  <div class="container">
    <div class="row pt-2">
      <div class="col-md-6 offset-md-3">
        <h5><i class="fa fa-check-circle" style="color: green"></i> Checkout</h5>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex';

  export default {
    computed: {
      ...mapState({
        shop: state => state.shop,
      }),
    },
  };
</script>
