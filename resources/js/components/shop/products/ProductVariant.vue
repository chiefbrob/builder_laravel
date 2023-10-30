<template>
  <b-card class="p-0">
    <b-card-text class="p-0 m-0 pointer" @click="showVariant">{{ variant.name }}</b-card-text>
    <b-card-body class="p-0 m-0">
      <b-button
        v-b-modal="`edit-product-variant-${variant.id}`"
        v-if="admin"
        class="float-right text-white"
        size="sm"
        variant="info"
        ><i class="fa fa-pen"></i
      ></b-button>
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
    </b-card-body>
    <b-card-img
      v-if="variant.photo"
      :src="`/storage/images/product-variants/${variant.photo}`"
    ></b-card-img>
  </b-card>
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
      showVariant() {
        this.$router.push({
          name: 'view-product-variant',
          params: {
            slug: this.product.slug,
            variant_id: this.variant.id,
          },
        });
      },
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
