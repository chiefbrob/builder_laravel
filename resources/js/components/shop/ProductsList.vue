<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <b-form-checkbox
          id="checkbox-1"
          v-model="deleted"
          class="float-right mr-2"
          name="checkbox-1"
          value="accepted"
          @input="loadProducts"
          v-if="admin"
          unchecked-value="not_accepted"
        >
          <i class="fa fa-trash-can"></i>
        </b-form-checkbox>
      </div>
      <product
        class="col-md-4"
        v-for="product in products"
        v-bind:key="product.id"
        :full="false"
        :product="product"
        @updated="loadProducts"
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
        deleted: 'not_accepted',
      };
    },
    created() {
      this.loadProducts();
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
      loadProducts() {
        let url = `/api/v1/products/?page=${this.meta.currentPage}`;
        if (this.admin) {
          url = `/api/v1/shop/products/?page=${this.meta.currentPage}`;
          if (this.deleted !== 'not_accepted') {
            url += `&deleted=true`;
          }
        }
        axios
          .get(url)
          .then(results => {
            this.products = results.data.data;
            this.meta.currentPage = results.data.current_page;
            this.meta.total = results.data.total;
            this.meta.perPage = results.data.per_page;
            this.meta.lastPage = results.data.last_page;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to products');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
