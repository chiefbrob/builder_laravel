<template>
  <div>
    <div class="mb-5 pb-5 row">
      <div class="col-md-6 offset-md-3">
        <h4 class="py-3">
          Create Product
        </h4>
        <product-form url="/api/v1/products"></product-form>
      </div>
    </div>
  </div>
</template>

<script>
  import ProductForm from './ProductForm.vue';
  export default {
    components: { ProductForm },
    props: [],
    data() {
      return {};
    },
    computed: {},
    methods: {
      createProduct(form) {
        //
      },
    },
    created() {},
  };
</script>
