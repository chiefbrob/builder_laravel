<template>
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <div class="row">
        <order
          class="col-md-6 offset-md-3"
          :full="true"
          @updated="loadOrder"
          :order="order"
          v-if="order"
        ></order>
        <div v-else>
          <p><i class="fa fa-spinner"></i> Loading...</p>
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
        order: null,
        reference: this.$route.params.reference,
      };
    },
    created() {
      this.loadOrder();
    },
    methods: {
      loadOrder() {
        axios
          .get('/api/v1/invoices/' + this.reference)
          .then(results => {
            this.order = results.data;
          })
          .catch(e => {
            this.$root.$emit('Failed to load order');
          });
      },
    },
  };
</script>
