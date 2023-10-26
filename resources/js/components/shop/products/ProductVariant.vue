<template>
  <div>
    {{ variant.name }}
    <b-button v-if="admin" class="float-right text-white" size="sm" variant="info"
      ><i class="fa fa-pen"></i
    ></b-button>

    <b-modal
      no-close-on-backdrop
      no-close-on-esc
      hide-footer
      id="add-product-variant"
      title="Add Variation"
      v-if="product"
    >
      <product-variant-form
        :product="product"
        :errors="variantErrors"
        @submitted="updateProductVariant"
      ></product-variant-form>
    </b-modal>
  </div>
</template>

<script>
  export default {
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
