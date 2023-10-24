<template>
  <div>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h4 class="pt-2">
          Cart
          <b-button class="float-right" size="sm" variant="danger"
            ><i class="fa fa-trash-can"></i
          ></b-button>
        </h4>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: [],
    data() {
      return {};
    },
    computed: {
      productIds() {
        console.log(this.$root.cart);
        const p = this.$root.cart.map(cart => {
          return product.id;
        });
        console.log(p);
        return p;
      },
    },
    methods: {},
    created() {
      console.log(this.productIds);
    },
  };
</script>
