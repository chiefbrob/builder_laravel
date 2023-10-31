<template>
  <div>
    <div class="mb-5 pb-5 row">
      <div class="col-md-10 offset-md-1">
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
