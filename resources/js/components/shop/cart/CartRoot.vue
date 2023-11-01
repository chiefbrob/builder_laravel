<template>
  <div>
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <h4 class="pt-2">
          Shopping Cart

          <b-button
            v-if="cartItems && cartItems.length > 0"
            size="sm"
            variant="info"
            @click="checkout"
            class="float-right text-white "
            ><i class="fa fa-check-circle"></i> Checkout</b-button
          >
          <b-button
            v-if="cartItems && cartItems.length > 0"
            class="float-right mr-2"
            size="sm"
            variant="danger"
            @click="emptyCart"
            >Empty <i class="fa fa-trash-can"></i
          ></b-button>
        </h4>
        <div class="row">
          <div class="col-md-4" v-for="cartItem in cartItems" :key="cartItem.id">
            <cart-item :item="cartItem"></cart-item>
          </div>
          <div v-if="cartItems === null" class="col-md-6">
            <p><i class="fa fa-spinner"></i> Loading...</p>
          </div>

          <div v-if="cartItems && cartItems.length === 0" class="col-md-6">
            <p>Shopping Cart is Empty</p>
            <p>
              <b-button
                size="sm"
                variant="info"
                class="text-white"
                @click="$router.push({ name: 'shop' })"
                ><i class="fa fa-shopping-cart"></i> Start Shopping</b-button
              >
            </p>
          </div>
          <div v-if="cartItems && cartItems.length > 0" class="mt-3" :class="cardSummaryClass">
            <b-card>
              <b-card-title>
                Cart Summary
              </b-card-title>
              <b-card-body>
                <p class="mb-0">Products: {{ cartItems.length }}</p>
                <p class="pt-0 mt-0" v-if="cartItems.length > 1">Items: {{ totalItems }}</p>
                <h4 class="mt-4">
                  Totals: <u>{{ totals | kes }}</u>
                </h4>
                <p>
                  <b-button @click="checkout" size="sm" variant="info" class=" text-white mr-2"
                    ><i class="fa fa-check-circle"></i> Proceed to Checkout</b-button
                  >
                  or
                  <router-link :to="{ name: 'shop' }">
                    <i class="fa fa-shopping-cart"></i> Continue Shopping</router-link
                  >
                </p>
              </b-card-body>
            </b-card>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import CartItem from './CartItem';
  import store from '../../../store';
  export default {
    components: { CartItem },
    props: [],
    data() {
      return {};
    },
    computed: {
      cartItems() {
        return store.state.shop.form.cart;
      },
      totals() {
        if (this.cartItems && this.cartItems.length > 0) {
          let total = 0;
          this.cartItems.forEach(item => {
            total += item.quantity * item.product.price;
          });
          return total;
        }
        return 0;
      },
      totalItems() {
        if (this.cartItems && this.cartItems.length > 0) {
          let total = 0;
          this.cartItems.forEach(item => {
            total += item.quantity;
          });
          return total;
        }
        return 0;
      },
      cardSummaryClass() {
        if (this.cartItems.length % 3 === 0) {
          return 'col-md-12';
        }
        if (this.cartItems.length % 2 === 0) {
          return 'col-md-4';
        }
        return 'col-md-8';
      },
    },
    methods: {
      emptyCart() {
        axios
          .delete(`/api/v1/cart/empty`)
          .then(results => {
            this.$root.$emit('sendMessage', 'Cart Empty', 'success');
            this.$store.commit('shop/updateCart', []);
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to Empty Cart');
          });
      },
      checkout() {
        this.$router.push({ name: 'checkout' });
      },
    },
    mounted() {},
  };
</script>
