<template>
  <div>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h4 class="pt-2">
          Cart
          <b-button class="float-right" size="sm" variant="danger"
            >Empty <i class="fa fa-trash-can"></i
          ></b-button>
          <b-button size="sm" variant="info" class="float-right text-white mr-2"
            ><i class="fa fa-shopping-cart"></i> Checkout</b-button
          >
        </h4>
        <div class="row">
          <b-card class="col-md-6" v-for="cartItem in cartItems" :key="cartItem.id">
            <b-card-text>
              {{ cartItem.product_variant.name.substr(0, 15)
              }}{{ cartItem.product_variant.name.length > 15 ? '...' : '' }}
              <b-button class="float-right" variant="danger" size="sm">x</b-button>
            </b-card-text>
            <b-card-img
              :src="
                cartItem.product_variant.photo
                  ? `/storage/images/product-variants/${cartItem.product_variant.photo}`
                  : `/storage/images/products/${cartItem.product.photo}`
              "
            ></b-card-img>
            <b-card-text> Quantity {{ cartItem.quantity }} </b-card-text>
          </b-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import store from '../../../store';
  export default {
    props: [],
    data() {
      return {};
    },
    computed: {
      cartItems() {
        return store.state.shop.form.cart;
      },
    },
    methods: {},
    mounted() {},
  };
</script>
