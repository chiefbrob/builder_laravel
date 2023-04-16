<template>
  <div>
    <div class="mb-5 pb-5 row">
      <div class="col-md-8 offset-md-2 pt-4">
        <h4>
          <b-button variant="dark" @click="$router.push({ name: 'blog' })"
            ><i class="fa fa-arrow-left"></i
          ></b-button>
          New Blog
        </h4>
        <blog-form url="/api/v1/blog"></blog-form>
      </div>
    </div>
  </div>
</template>

<script>
  import BlogForm from './BlogForm';
  export default {
    components: { BlogForm },
    data() {
      return {};
    },
  };
</script>
