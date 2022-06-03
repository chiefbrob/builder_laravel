<template>
  <div>
    <nav-root></nav-root>
    <div class="mb-5 pb-5 row">
      <div class="col-md-10 offset-md-1">
        <div class="row py-4">
          <product class="col-md-8 offset-md-2" v-if="product" :product="product"></product>
        </div>
        <p v-if="loading"><i class="fa fa-spinner"></i> Loading</p>
        <p v-if="!loading && !product"></p>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  import Product from './Product';
  import { mapState } from 'vuex';
  export default {
    props: [],
    components: { Product },
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
            console.log(error);
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
