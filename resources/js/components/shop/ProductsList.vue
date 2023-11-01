<template>
  <div>
    <div class="row mt-1">
      <div class="col-md-12">
        <input
          v-if="$featureIsEnabled('search-shop')"
          type="text"
          class="form-control"
          name="search-shop"
          placeholder="Search shop"
        />
        <span class="ml-2">Shop</span>

        <router-link
          v-if="shop.form.cart && shop.form.cart.length > 0"
          class="float-right py-0 btn btn-sm btn-info text-white"
          :to="{ name: 'cart' }"
        >
          {{ shop.form.cart.length }}
          <i class="fa fa-shopping-cart"></i>
        </router-link>

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
        <b-button
          v-if="admin"
          variant="success"
          @click="$router.push({ name: 'create-product' })"
          size="sm"
          class="py-0 float-right mr-2"
          ><i class="fa fa-plus"></i> Add Item</b-button
        >
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
  import { mapState } from 'vuex';

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
      ...mapState({
        shop: state => state.shop,
      }),
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
