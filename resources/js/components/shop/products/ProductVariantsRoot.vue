<template>
  <div class="container">
    <div class=" row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6 offset-md-3">
            <shop-bread-crumb
              class="p-1 mt-1"
              :product="product"
              v-if="product"
              page="variants"
            ></shop-bread-crumb>
          </div>
          <div class="col-md-6 offset-md-3" v-if="product">
            <div class="row">
              <product-variant
                class="col-md-6"
                v-for="(variant, i) in variants"
                @updated="loadProduct"
                :key="i"
                :variant="variant"
                :product="product"
                :full="false"
              ></product-variant>
            </div>
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
  import ShopBreadCrumb from '../nav/ShopBreadCrumb.vue';
  import ProductVariant from './ProductVariant';
  import { mapState } from 'vuex';
  export default {
    props: [],
    components: { ProductVariant, ShopBreadCrumb },
    data() {
      return {
        loading: true,
        product: null,
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
      variants() {
        if (this.admin) {
          return this.product.product_variants;
        }
        return this.product.product_variants.filter(variant => {
          return variant.quantity > 0;
        });
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
