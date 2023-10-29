<template>
  <div>
    <div class="mb-5 pb-5 row">
      <div class="col-md-10 offset-md-1">
        <h4 class="pt-1">
          Shop
          <b-button
            v-if="admin"
            variant="success"
            @click="$router.push({ name: 'create-product' })"
            size="sm"
            class="float-right"
            ><i class="fa fa-plus"></i> Add Item</b-button
          >
        </h4>
        <products-list></products-list>
      </div>
    </div>
  </div>
</template>

<script>
  import ProductsList from './ProductsList';
  export default {
    components: { ProductsList },
    props: [],
    data() {
      return {
        deleted: 'not_accepted',
      };
    },
    computed: {
      user() {
        return this.$store.getters.user;
      },
      admin() {
        return this.user && this.user.admin;
      },
    },
    methods: {},
    created() {},
  };
</script>
