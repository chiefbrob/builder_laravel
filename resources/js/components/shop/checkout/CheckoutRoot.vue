<template>
  <div class="">
    <div class="row pt-2">
      <div class="col-md-10 offset-md-1">
        <h5><i class="fa fa-check-circle" style="color: green"></i> Checkout</h5>
        <div class="row" v-if="cart">
          <cart-summary
            :class="user ? 'col-md-4' : 'col-md-6'"
            :full="false"
            :cart="cart"
          ></cart-summary>
          <guest-checkout :class="user ? 'col-md-4' : 'col-md-6'" v-if="!user"></guest-checkout>
          <user-checkout v-if="user" class="col-md-8"></user-checkout>
          <div class="col-md-6 offset-md-3 text-center" v-if="user">
            <b-button size="sm" variant="success">Confirm Order</b-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  import CartSummary from '../cart/CartSummary.vue';
  import GuestCheckout from './GuestCheckout.vue';
  import UserCheckout from './UserCheckout.vue';
  export default {
    components: { CartSummary, GuestCheckout, UserCheckout },
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
