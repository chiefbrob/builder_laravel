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
        <p>IDS: {{ productIds }}</p>
      </div>
    </div>
  </div>
</template>

<script>
  import store from '../../../store';
  export default {
    props: [],
    data() {
      return {};
    },
    computed: {
      productIds() {
        return store.state.shop.form.cart;
      },
    },
    methods: {},
  };
</script>
