<template>
  <div>
    <div class="mb-5 pb-5 row">
      <div class="col-md-8 offset-md-2 pt-4">
        <h4>
          New Blog Article
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
