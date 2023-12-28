<template>
  <div class="container">
    <div class=" row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6 offset-md-3" v-if="product">
            <shop-bread-crumb
              class="p-1 mt-1"
              :product="product"
              :variant="variant"
              v-if="product && variant"
              page="variant"
            ></shop-bread-crumb>
            <product-variant
              @updated="loadProduct"
              :variant="variant"
              :product="product"
            ></product-variant>
          </div>
        </div>
        <div class="col-md-6 offset-md-3" v-if="loading">
          <p><i class="fa fa-spinner"></i> Loading</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import ProductVariant from './ProductVariant';
  import ShopBreadCrumb from '../nav/ShopBreadCrumb.vue';
  import { mapState } from 'vuex';
  export default {
    props: [],
    components: { ProductVariant, ShopBreadCrumb },
    data() {
      return {
        loading: true,
        product: null,
        variant_id: this.$route.params.variant_id,
      };
    },
    computed: {
      ...mapState({
        shop: state => state.shop,
      }),
      variant() {
        return this.product.product_variants.filter(variant => {
          return variant.id === parseInt(this.variant_id);
        })[0];
      },
    },
    methods: {
      loadProduct() {
        const slug = this.$router.currentRoute.params.slug;
        axios
          .get(`/api/v1/products/?slug=${slug}`)
          .then(results => {
            this.product = results.data;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to product');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
    created() {
      if (this.shop.product) {
        this.product = this.shop.product;
        this.loading = false;
      } else {
        this.loadProduct();
      }
    },
  };
</script>
