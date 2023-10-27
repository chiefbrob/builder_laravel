<template>
  <div>
    {{ variant.name }}
    <b-button
      v-b-modal="`edit-product-variant-${variant.id}`"
      v-if="admin"
      class="float-right text-white"
      size="sm"
      variant="info"
      ><i class="fa fa-pen"></i
    ></b-button>
    <br />
    <img
      :src="`/storage/images/product-variants/${variant.photo}`"
      v-if="variant.photo"
      style="max-width: 7em;"
      :alt="variant.name"
    />

    <b-modal
      no-close-on-backdrop
      no-close-on-esc
      hide-footer
      :id="`edit-product-variant-${variant.id}`"
      title="Edit Variant"
      v-if="product && admin"
    >
      <product-variant-form
        :product="product"
        :variant="variant"
        :errors="variantErrors"
        @submitted="updateProductVariant"
      ></product-variant-form>
    </b-modal>
  </div>
</template>

<script>
  import ProductVariantForm from './ProductVariantForm';
  export default {
    components: { ProductVariantForm },
    props: {
      variant: {
        required: true,
      },
      product: {
        required: true,
      },
    },
    data() {
      return {
        variantErrors: [],
      };
    },
    computed: {
      user() {
        return this.$store.getters.user;
      },
      admin() {
        return this.user && this.user.admin;
      },
    },
    methods: {
      updateProductVariant() {},
    },
  };
</script>
