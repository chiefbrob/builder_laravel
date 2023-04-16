<template>
  <div>
    <div class="mb-5 pb-5 row">
      <div class="col-md-8 offset-md-2 pt-4">
        <h4>
          <b-button
            variant="dark"
            @click="$router.push({ name: 'blog-single', params: { id: blog.id } })"
            ><i class="fa fa-arrow-left"></i
          ></b-button>
          Edit Blog
        </h4>
        <blog-form v-if="blog" :url="`/api/v1/blog/${blog_id}`" :blog="blog"></blog-form>
        <h4 v-if="loading"><i class="fa fa-spinner"></i> Loading</h4>
      </div>
    </div>
  </div>
</template>

<script>
  import BlogForm from './BlogForm';
  export default {
    components: { BlogForm },
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
