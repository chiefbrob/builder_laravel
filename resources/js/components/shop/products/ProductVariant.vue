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
      updateProductVariant(submitted) {
        let form = new FormData();
        if (submitted.photo) {
          form.append('photo', submitted.photo);
        }
        form.append('name', submitted.name);
        form.append('quantity', submitted.quantity);
        form.append('description', submitted.description);

        axios
          .post(`/api/v1/products/${this.product.id}/product-variants/${this.variant.id}`, form, {
            headers: { 'Content-Type': 'multipart/form-data' },
          })
          .then(results => {
            this.$root.$emit('sendMessage', 'Product variant updated', 'success');
            this.$emit('updated', results.data);
          })
          .catch(({ response }) => {
            this.variantErrors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to update product variant!');
          });
      },
    },
  };
</script>
