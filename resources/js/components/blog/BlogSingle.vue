<template>
  <div>
    <nav-root></nav-root>
    <div class="mb-5 py-5 row">
      <div class="col-md-10 offset-md-1">
        <div v-if="loading"><i class="fa fa-spinner"></i> Loading</div>
        <div v-else>
          <blog :blog="blog" :full="true"></blog>
        </div>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  import Blog from './Blog';
  export default {
    components: {
      Blog,
    },
    data() {
      return {
        blog_id: null,
        blog: null,
        loading: true,
      };
    },
    created() {
      this.loadBlog();
    },
    methods: {
      loadBlog() {
        this.blog_id = this.$router.currentRoute.params.id;
        axios
          .get(`/api/v1/blog/?id=${this.blog_id}`)
          .then(results => {
            this.blog = results.data;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to load blog');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
