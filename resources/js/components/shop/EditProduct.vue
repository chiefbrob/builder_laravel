<template>
  <div>
    <nav-root></nav-root>
    <div class="mb-5 pb-5 row">
      <div class="col-md-10 offset-md-1">
        <b-card v-if="product" :title="product.name">
          <product-form :url="`/api/v1/products/${product.id}`" :product="product"></product-form>
        </b-card>
        <p v-if="loading"><i class="fa fa-spinner"></i> Loading</p>
        <p v-if="!loading && !product">Nothing to display</p>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  import ProductForm from './ProductForm';
  import { mapState } from 'vuex';
  export default {
    components: { ProductForm },
    props: [],
    data() {
      return {
        product: null,
        loading: true,
      };
    },
    computed: {
      ...mapState({
        shop: state => state.shop,
      }),
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
