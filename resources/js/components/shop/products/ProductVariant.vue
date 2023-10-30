<template>
  <b-card class="p-0">
    <b-card-text class="p-0 m-0 pointer" @click="showVariant"
      ><b>{{ variant.name }}</b></b-card-text
    >
    <b-card-body class="p-0 m-0">
      <b-button :disabled="loading" @click="addToCart" variant="link" size="sm"
        ><i class="fa fa-shopping-cart"></i
      ></b-button>
      <b-button
        :disabled="loading"
        v-b-modal="`edit-product-variant-${variant.id}`"
        v-if="admin"
        class=""
        size="sm"
        variant="link"
        ><i class="fa fa-pen"></i
      ></b-button>
      <b-button :disabled="loading" v-if="admin && false" size="sm" variant="link"
        ><i class="fa fa-trash-can"></i
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
    <b-card-footer v-if="full">
      <b>{{ variant.quantity }}</b> available
    </b-card-footer>
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
      full: {
        default: true,
      },
    },
    data() {
      return {
        variantErrors: [],
        quantity: 1,
        loading: false,
      };
    },
    computed: {
      user() {
        return this.$store.getters.user;
      },
      admin() {
        return this.user && this.user.admin;
      },
      url() {
        return window.location;
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
        this.loading = true;
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
          })
          .finally(f => {
            this.loading = false;
          });
      },
      addToCart() {
        this.loading = true;
        axios
          .post(`/api/v1/cart`, {
            product_variant_id: this.variant.id,
            quantity: this.quantity,
          })
          .then(results => {
            this.$root.$emit('sendMessage', 'Variant added to Cart', 'success');
            this.$store.commit('shop/updateCart', results.data.cart);
          })
          .catch(error => {
            let dm = 'Failed to add variant to Cart';
            this.$root.$emit('sendMessage', dm);
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
