<template>
  <b-breadcrumb>
    <b-breadcrumb-item href="#" @click="$router.push({ name: 'home' })">
      <b-icon icon="house-fill" scale="1.25" shift-v="1.25" aria-hidden="true"></b-icon>
      Home
    </b-breadcrumb-item>
    <b-breadcrumb-item
      @click="$router.push({ name: 'shop' })"
      :active="!product && !variant"
      href="#"
      >Shop</b-breadcrumb-item
    >
    <b-breadcrumb-item
      :active="!!product && !variant && page === 'product'"
      href="#"
      @click="viewProduct"
      >{{ product.name }}</b-breadcrumb-item
    >
    <b-breadcrumb-item
      v-if="product.product_variants.length > 1 && (!variant || page === 'variant')"
      href="#"
      :active="!variant && page !== 'product'"
      @click="showVariants"
      >Variants</b-breadcrumb-item
    >
    <b-breadcrumb-item :active="!!variant" v-if="variant">{{ variant.name }}</b-breadcrumb-item>
  </b-breadcrumb>
</template>

<script>
  import { mapState } from 'vuex';

  export default {
    props: {
      product: {
        required: false,
      },
      variant: {
        required: false,
      },
      page: {
        default: 'product',
      },
    },
    computed: {
      ...mapState({
        shop: state => state.shop,
      }),
    },
    methods: {
      showVariants() {
        if (!this.product) {
          return;
        }
        this.$router.push({ name: 'view-product-variants', params: { slug: this.product.slug } });
      },
      viewProduct() {
        if (!this.full) {
          this.$store.commit('shop/updateProduct', this.product);
          this.$router.push({ name: 'view-product', params: { slug: this.product.slug } });
        }
      },
    },
  };
</script>
