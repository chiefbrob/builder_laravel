<template>
  <div>
    <div class="row">
      <product
        class="col-md-3"
        v-for="product in products"
        v-bind:key="product.id"
        :full="false"
        :product="product"
      ></product>
    </div>
    <p v-if="loading"><i class="fa fa-spinner"></i> Loading</p>
    <p v-if="!loading && products.length === 0">No items to display</p>
  </div>
</template>

<script>
  import Product from './Product';
  export default {
    components: { Product },
    data() {
      return {
        products: [],
        loading: true,
        meta: {
          currentPage: 1,
          total: 0,
          perPage: 15,
          lastPage: 1,
        },
      };
    },
    created() {
      this.loadProducts();
    },
    methods: {
      loadProducts() {
        axios
          .get(`/api/v1/products/?page=${this.meta.currentPage}`)
          .then(results => {
            this.products = results.data.data;
            this.meta.currentPage = results.data.current_page;
            this.meta.total = results.data.total;
            this.meta.perPage = results.data.per_page;
            this.meta.lastPage = results.data.last_page;
          })
          .catch(error => {
            console.log(error);
            this.$root.$emit('sendMessage', 'Failed to products');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
