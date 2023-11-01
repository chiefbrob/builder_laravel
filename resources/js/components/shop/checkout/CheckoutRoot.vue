<template>
  <div class="">
    <div class="row pt-2">
      <div class="col-md-10 offset-md-1">
        <h5><i class="fa fa-check-circle" style="color: green"></i> Checkout</h5>
        <div class="row" v-if="cart">
          <cart-summary class="col-md-6" :full="false" :cart="cart"></cart-summary>
          <guest-checkout class="col-md-6" v-if="!user"></guest-checkout>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  import CartSummary from '../cart/CartSummary.vue';
  import GuestCheckout from './GuestCheckout.vue';
  export default {
    components: { CartSummary, GuestCheckout },
    computed: {
      ...mapState({
        shop: state => state.shop,
      }),
      cart() {
        return this.shop.form.cart;
      },
      user() {
        return this.$store.getters.user;
      },
    },
  };
</script>
