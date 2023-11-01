<template>
  <div class="mt-3">
    <b-card>
      <b-card-title>
        Cart Summary
      </b-card-title>
      <b-card-body>
        <p class="mb-0">Products: {{ cart.length }}</p>
        <p class="pt-0 mt-0" v-if="cart.length > 1">Items: {{ totalItems }}</p>
        <h4 class="mt-4">
          Totals: <u>{{ totals | kes }}</u>
        </h4>
        <p v-if="full">
          <b-button
            @click="$router.push({ name: 'checkout' })"
            size="sm"
            variant="info"
            class=" text-white mr-2"
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
</template>

<script>
  export default {
    props: {
      cart: {
        required: true,
      },
      full: {
        required: false,
        default: true,
      },
    },
    computed: {
      totals() {
        if (this.cart && this.cart.length > 0) {
          let total = 0;
          this.cart.forEach(item => {
            total += item.quantity * item.product.price;
          });
          return total;
        }
        return 0;
      },
      totalItems() {
        if (this.cart && this.cart.length > 0) {
          let total = 0;
          this.cart.forEach(item => {
            total += item.quantity;
          });
          return total;
        }
        return 0;
      },
    },
  };
</script>
