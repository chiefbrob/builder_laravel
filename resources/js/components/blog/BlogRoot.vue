<template>
  <div>
    <nav-root></nav-root>

    <div class="mb-5 pb-5 row">
      <blog-item
        class="col-md-4 col-lg-3"
        v-for="item in items"
        v-bind:key="item.id"
        :blog="item"
      ></blog-item>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  import BlogItem from './Blog';
  export default {
    components: {
      BlogItem,
    },
    data() {
      return {
        items: [],
        meta: {
          currentPage: 1,
        },
      };
    },
    created() {
      this.loadBlogs();
    },
    methods: {
      loadBlogs() {
        axios
          .get(`/api/v1/blog/?page=${this.meta.currentPage}`)
          .then(results => {
            this.items = results.data.data;
            this.meta.currentPage = results.data.current_page;
            this.meta.total = results.data.total;
            this.meta.perPage = results.data.per_page;
            this.meta.lastPage = results.data.last_page;
          })
          .catch(error => {
            console.log(error);
            this.$root.$emit('sendMessage', 'Failed to blogs');
          });
      },
    },
  };
</script>
