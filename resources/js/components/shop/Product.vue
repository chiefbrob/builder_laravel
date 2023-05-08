<template>
  <div>
    <b-card
      :overlay="true"
      :img-src="`/storage/images/products/${product.photo}`"
      border-variant="light"
      text-variant="light"
      bg-variant="info"
    >
      <b-card-title>
        <span :class="full ? '' : 'pointer'" class="black-bkg" @click="viewProduct">{{
          product.name
        }}</span>
      </b-card-title>
      <b-card-sub-title v-if="admin">
        <b-button
          variant="info"
          @click="$router.push({ name: 'edit-product', params: { slug: product.slug } })"
          size="sm"
          ><i class="fa fa-pen text-white"></i
        ></b-button>
        <b-button size="sm" variant="danger" @click="deleteProduct"
          ><i class="fa fa-trash"></i
        ></b-button>
      </b-card-sub-title>
      <b-card-text class="py-2 black-bkg">
        <p class="px-2">
          <b-button
            v-if="product.product_variants.length === 1"
            href="#"
            size="sm"
            variant="light"
            @click="addToCart"
            ><i class="fa fa-shopping-cart"></i> Add to Cart</b-button
          >
          <span class=" float-right"> {{ product.price | kes }} </span>
        </p>
      </b-card-text>

      <b-card-text v-if="full">
        <p>
          <span class="black-bkg">{{ product.description }}</span>
        </p>
      </b-card-text>
    </b-card>
    <div v-if="product.product_variants.length > 1">
      <div v-for="variant in product.product_variants" v-bind:key="variant.id">
        {{ variant }}
      </div>
    </div>
    <div v-if="full" class="text-justify">
      <h5>Description</h5>
      {{ product.long_description }}
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  export default {
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
