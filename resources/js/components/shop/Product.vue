<template>
  <div>
    <b-card style="padding: 0;" border-variant="light" text-variant="light" bg-variant="info">
      <b-card-title>
        <span :class="full ? '' : 'pointer'" class="p-2" @click="viewProduct">{{
          product.name
        }}</span>
      </b-card-title>
      <b-card-text @click="viewProduct">
        <product-slideshow :product="product" :full="full"></product-slideshow>
      </b-card-text>
      <b-card-text class="py-2">
        <p class="px-2">
          <b-button href="#" size="sm" variant="light" @click="addToCart"
            ><i class="fa fa-shopping-cart"></i> Add to Cart</b-button
          >
          <span v-if="admin">
            <b-button
              variant="dark"
              @click="$router.push({ name: 'edit-product', params: { slug: product.slug } })"
              size="sm"
              ><i class="fa fa-pen text-white"></i
            ></b-button>
            <b-button size="sm" variant="danger" @click="deleteProduct"
              ><i class="fa fa-trash"></i
            ></b-button>
          </span>
          <span class=" float-right"> {{ product.price | kes }} </span>
        </p>
      </b-card-text>
    </b-card>
    <div v-if="product.product_variants.length > 1 && full">
      <h5>Variants</h5>
      <b-list-group>
        <b-list-group-item v-for="(variant, i) in product.product_variants" :key="i">
          <product-variant :variant="variant" :product="product"></product-variant>
        </b-list-group-item>
      </b-list-group>
    </div>
    <div v-if="full" class="text-justify" v-html="product.long_description"></div>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  import ProductVariant from './products/ProductVariant';
  import ProductSlideshow from './products/ProductSlideshow';
  export default {
    components: { ProductSlideshow, ProductVariant },
    props: {
      product: {
        required: true,
      },
      full: {
        default: true,
        required: false,
      },
    },
    computed: {
      ...mapState({
        shop: state => state.shop,
      }),
      user() {
        return this.$store.getters.user;
      },
      admin() {
        return this.user && this.user.admin;
      },
      price() {
        return this.product.price;
      },
      variant() {
        return this.product.product_variants[0];
      },
    },
    methods: {
      viewProduct() {
        if (!this.full) {
          this.$store.commit('shop/updateProduct', this.product);
          this.$router.push({ name: 'view-product', params: { slug: this.product.slug } });
        }
      },
      deleteProduct() {
        axios
          .delete(`/api/v1/products/${this.product.id}`)
          .then(results => {
            this.$root.$emit('sendMessage', 'Product Deleted', 'success');
            setTimeout(() => {
              this.$router.push({ name: 'shop' });
            }, 3000);
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to delete product');
          });
      },
      addToCart() {
        this.addToOfflineCart(1);
        axios
          .post(`/api/v1/cart`, {
            product_variant_id: this.variant.id,
            quantity: 1,
          })
          .then(results => {
            this.$root.$emit('sendMessage', 'Product Added to Cart', 'success');
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to add product to cart');
          });
      },
      addToOfflineCart(quantity) {
        let offlineCart = JSON.parse(localStorage.getItem('cart'));

        if (offlineCart) {
          let newOfflineCart = [];
          for (let index = 0; index < offlineCart.length; index++) {
            const offlineCartItem = offlineCart[index];

            if (offlineCartItem.id === this.variant.id) {
              let newTotal = offlineCartItem.quantity + quantity;
              if (newTotal <= this.variant.quantity) {
                offlineCartItem.quantity = newTotal;
                return;
              }
            }
            newOfflineCart.push(offlineCartItem);
          }
          localStorage.setItem('cart', JSON.stringify(newOfflineCart));
        } else {
          let cart = {
            id: this.variant.id,
            quantity: quantity,
          };
          localStorage.setItem('cart', JSON.stringify(cart));
        }
      },
    },
  };
</script>

<style scoped>
  .card-body {
    padding: 0;
  }
</style>
