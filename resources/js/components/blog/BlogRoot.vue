<template>
  <div>
    <div class="mb-5 pb-5 row">
      <div class="col-md-10 offset-md-1 pt-4">
        <div class="row">
          <div class="col-md-12">
            <h4>
              <span> Blog </span>
              <b-button
                v-if="admin"
                class="float-right text-white"
                variant="info"
                size="sm"
                @click="$router.push({ name: 'blog-new' })"
                ><i class="fa fa-plus"></i>
              </b-button>
            </h4>
          </div>
          <div class="col-md-4 " v-for="item in items" v-bind:key="item.id">
            <blog-item :blog="item"></blog-item>
          </div>
          <div class="col-md-12" v-if="items.length === 0">
            <p v-if="!loading">No items to display</p>
            <p v-else><i class="fa fa-spinner"></i> Loading...</p>
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
    </div>
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
        loading: true,
        meta: {
          currentPage: 1,
        },
      };
    },
    created() {
      this.loadBlogs();
    },
    computed: {
      admin() {
        return this.$store.getters.user?.admin;
      },
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
            this.$root.$emit('sendMessage', 'Failed to blogs');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
