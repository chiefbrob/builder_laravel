<template>
  <div>
    <nav-root></nav-root>

    <div class="mb-5 pb-5 row">
      <div class="col-md-8 offset-md-2 pt-4 row">
        <div class="col-md-12">
          <h4>
            <span> Blog </span>
            <b-button
              class="float-right text-white"
              variant="info"
              @click="$router.push({ name: 'blog-new' })"
              ><i class="fa fa-pen"></i> New</b-button
            >
          </h4>
        </div>
        <div class="col-md-4 " v-for="item in items" v-bind:key="item.id">
          <blog-item :blog="item"></blog-item>
        </div>
        <div class="col-md-10 offset-md-1">
          <b-pagination
            @input="pageChanged"
            v-model="meta.currentPage"
            v-if="meta.lastPage > 1"
            :total-rows="meta.total"
            :per-page="meta.perPage"
            aria-controls="admin-users"
          ></b-pagination>
        </div>
      </div>
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
      pageChanged(page) {
        this.currentPage = page;
        this.loadBlogs();
      },
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
