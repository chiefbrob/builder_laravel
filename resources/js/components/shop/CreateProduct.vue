<template>
  <div>
    <nav-root></nav-root>
    <div class="mb-5 pb-5 row">
      <div class="col-md-10 offset-md-1">
        <h4 class="py-3">
          <i class="fa fa-arrow-left" @click="$router.push({ name: 'shop' })"></i> Create Product
        </h4>
        <product-form url="/api/v1/products"></product-form>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  import ProductForm from './ProductForm';
  export default {
    components: { ProductForm },
    props: [],
    data() {
      return {};
    },
    computed: {},
    methods: {
      createProduct(form) {
        console.log('creating product', form);
      },
    },
    created() {},
  };
</script>
