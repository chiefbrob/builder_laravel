<template>
  <div class="container">
    <div class="mb-5 py-5 row">
      <div class="col-md-6 offset-md-3">
        <div v-if="loading"><i class="fa fa-spinner"></i> Loading</div>
        <div v-else>
          <blog :blog="blog" :full="true"></blog>
        </div>
      </div>
    </div>
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
