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
          <b-button
            href="#"
            size="sm"
            variant="light"
            @click="addToCart"
            v-b-modal="
              product.product_variants.length > 1 ? `cart-select-product-variant-${product.id}` : ''
            "
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

    <div>
      <b-modal
        hide-footer
        no-close-on-backdrop
        :ref="`cart-select-product-variant-${product.id}`"
        :id="`cart-select-product-variant-${product.id}`"
        title="Add to Cart"
      >
        <p class="my-4">
          {{ product.name }}
          <span class="float-right">{{ product.price | kes }}</span>
        </p>

        <multiselect
          :close-on-select="true"
          track-by="id"
          :searchable="true"
          :multiple="false"
          v-model="selectedVariant"
          @input="variantSelected"
          :options="product.product_variants"
          placeholder="Select Product Variant"
          :custom-label="variantName"
          :allow-empty="false"
        ></multiselect>

        <b-form-group label="Quantity">
          <multiselect
            :close-on-select="true"
            :searchable="true"
            :disabled="!selectedVariant"
            :multiple="false"
            v-model="selectedQuantity"
            :options="availableQuantity"
            :allow-empty="false"
          ></multiselect>
        </b-form-group>

        <p class="mt-3">
          <b-button :disabled="!selectedVariant" size="sm" variant="dark" @click="addVariantToCart"
            ><i class="fa fa-shopping-cart"></i> Add to Cart</b-button
          >
        </p>
      </b-modal>
    </div>
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
    data() {
      return {
        selectedVariant: null,
        selectedQuantity: null,
        availableQuantity: [],
      };
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
        if (this.product.product_variants.length > 1) {
          return;
        }
        this.addToCartFn(this.variant.id, 1);
      },
      addVariantToCart() {
        this.addToCartFn(this.selectedVariant.id, this.selectedQuantity);
      },
      addToCartFn(variant_id, quantity = 1) {
        axios
          .post(`/api/v1/cart`, {
            product_variant_id: variant_id,
            quantity: quantity,
          })
          .then(results => {
            this.$root.$emit('sendMessage', 'Product Added to Cart', 'success');
            this.$refs[`cart-select-product-variant-${this.product.id}`].hide();
            this.$store.commit('shop/updateCart', results.data.cart);
          })
          .catch(error => {
            let dm = 'Failed to add to Cart';
            this.$root.$emit('sendMessage', dm);
          });
      },
      variantName(variant) {
        return variant.name;
      },
      variantSelected(variant) {
        let arr = [];
        for (let index = 1; index < variant.quantity; index++) {
          arr[arr.length] = index;
        }
        this.availableQuantity = arr;
      },
    },
  };
</script>

<style scoped>
  .card-body {
    padding: 0;
  }
</style>
