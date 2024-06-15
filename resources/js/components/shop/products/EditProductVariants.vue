<template>
  <b-list-group>
    <b-list-group-item v-for="(variant, i) in product.product_variants" :key="i">
      <product-variant :variant="variant" :product="product"></product-variant>
    </b-list-group-item>
  </b-list-group>
</template>

<script>
  import ProductVariant from './ProductVariant.vue';
  export default {
    components: {
      ProductVariant,
    },
    props: {
      product: {
        required: true,
      },
    },
  };
</script>
