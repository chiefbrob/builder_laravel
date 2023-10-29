<template>
  <div>
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <h4 class="pt-2">
          Shopping Cart

          <b-button
            v-if="cartItems && cartItems.length > 0"
            size="sm"
            variant="info"
            class="float-right text-white mr-2"
            ><i class="fa fa-shopping-cart"></i> Checkout</b-button
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
          <cart-item
            v-for="cartItem in cartItems"
            :key="cartItem.id"
            :item="cartItem"
            class="col-md-4"
          ></cart-item>
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
    },
    methods: {
      emptyCart() {
        axios
          .delete(`/api/v1/cart`)
          .then(results => {
            this.$root.$emit('sendMessage', 'Cart Empty', 'success');
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to Empty Cart');
          });
      },
    },
    mounted() {},
  };
</script>
