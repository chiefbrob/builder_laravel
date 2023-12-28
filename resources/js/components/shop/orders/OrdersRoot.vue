<template>
  <div class="container">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <h5 class="py-2">
          <i class="fa fa-inbox"></i> Orders
          <router-link :to="{ name: 'shop' }" class="float-right text-white btn btn-sm btn-info"
            ><i class="fa fa-shopping-cart"></i> Shop</router-link
          >
        </h5>
        <div class="row">
          <order class="col-md-4" v-for="order in orders" :key="order.id" :order="order"></order>
          <div class="col-md-12" v-if="orders.length === 0">
            <i class="fa fa-check-circle"></i> No orders
            <p>Items you purchase would appear here</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Order from './Order.vue';
  export default {
    components: { Order },
    data() {
      return {
        orders: [],
      };
    },
    created() {
      this.loadOrders();
    },
    methods: {
      loadOrders() {
        axios
          .get('/api/v1/invoices')
          .then(results => {
            this.orders = results.data.data;
          })
          .catch(e => {
            this.$root.$emit('Failed to load orders');
          });
      },
    },
  };
</script>
