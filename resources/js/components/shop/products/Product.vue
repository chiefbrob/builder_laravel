<template>
  <div>
    <b-card style="padding: 0;" border-variant="light" text-variant="light" bg-variant="info">
      <b-card-title>
        <span :class="full ? '' : 'pointer'" class="p-2" @click="viewProduct">{{
          productName
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
            v-if="!product.deleted_at"
            variant="light"
            @click="addToCart"
            v-b-modal="
              product.product_variants.length > 1 ? `cart-select-product-variant-${product.id}` : ''
            "
            ><i class="fa fa-shopping-cart"></i>
          </b-button>
          <b-button
            v-if="product.product_variants.length > 1"
            size="sm"
            variant="success"
            @click="showVariants"
            ><i class="fa fa-list"></i> {{ product.product_variants.length }}</b-button
          >
          <span v-if="admin">
            <b-button
              variant="dark"
              @click="$router.push({ name: 'edit-product', params: { slug: product.slug } })"
              size="sm"
              ><i class="fa fa-pen text-white"></i
            ></b-button>
            <b-button size="sm" variant="danger" v-if="!product.deleted_at" @click="deleteProduct"
              ><i class="fa fa-trash"></i
            ></b-button>
            <b-button size="sm" variant="success" v-if="product.deleted_at" @click="restoreProduct"
              ><i class="fa fa-recycle"></i
            ></b-button>
          </span>
          <span class=" float-right"> {{ product.price | kes }} </span>
        </p>
      </b-card-text>
    </b-card>
    <div v-if="full" class="text-justify" v-html="product.long_description"></div>

    <div>
      <b-modal
        hide-footer
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
          :options="availableVariants"
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
            ><i class="fa fa-shopping-cart"></i
          ></b-button>
        </p>
      </b-modal>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  import ProductVariant from './ProductVariant.vue';
  import ProductSlideshow from './ProductSlideshow.vue';
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
      availableVariants() {
        return this.product.product_variants.filter(variant => {
          let addedToCart = false;
          let cartCount = 0;
          let fromCart = this.shop.form.cart.filter(item => {
            return item.id === variant.id;
          });
          if (fromCart.length > 0) {
            addedToCart = true;
            cartCount = fromCart[0].quantity;
          }
          if (addedToCart && cartCount === variant.quantity) {
            return false;
          }
          if (variant.quantity === 0) {
            return false;
          }
          return true;
        });
      },
      productName() {
        if (this.full || this.product.name.length < 15) {
          return this.product.name;
        } else {
          return this.product.name.substring(0, 15) + '...';
        }
      },
    },
    methods: {
      showVariants() {
        this.$router.push({ name: 'view-product-variants', params: { slug: this.product.slug } });
      },
      viewProduct() {
        if (!this.full) {
          this.$store.commit('shop/updateProduct', this.product);
          this.$router.push({ name: 'view-product', params: { slug: this.product.slug } });
        }
      },
      restoreProduct() {
        axios
          .patch(`/api/v1/products/${this.product.id}`)
          .then(results => {
            this.$root.$emit('sendMessage', 'Product Restored', 'success');
            this.$emit('updated');
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to restore product');
          });
      },
      deleteProduct() {
        axios
          .delete(`/api/v1/products/${this.product.id}`)
          .then(results => {
            this.$root.$emit('sendMessage', 'Product Deleted', 'success');
            setTimeout(() => {
              this.$router.push({ name: 'shop' });
            }, 3000);
            this.$emit('updated');
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
            this.$root.$emit('sendMessage', 'Added to Cart', 'success');
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
        let quantity = variant.quantity;

        let fromCart = this.shop.form.cart.filter(item => {
          return item.id === variant.id;
        });

        if (fromCart.length > 0) {
          quantity -= fromCart[0].quantity;
        }

        for (let index = 1; index <= quantity; index++) {
          arr[arr.length] = index;
        }
        this.availableQuantity = arr;
        if (this.availableQuantity.length === 1) {
          this.selectedQuantity = this.availableQuantity[0];
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
