<template>
  <div style="">
    <b-card :sub-title="full ? blog.subtitle : null" style="">
      <b-card-title>
        <div>
          {{ blog.title }}
          <span v-if="full && admin" class="float-right ">
            <b-button variant="info"><i class="fa fa-pen text-white"></i></b-button>
            <b-button variant="danger" @click="deleteBlog"><i class="fa fa-trash"></i></b-button>
          </span>
          <br />
          <small v-if="full"> {{ blog.user.name }} - {{ blog.created_at | relative }}</small>
        </div>
      </b-card-title>
      <b-card-img :src="imageSrc" :class="full ? 'py-4' : 'py-2'" :alt="blog.title"></b-card-img>
      <b-card-text v-if="full">
        {{ blog.contents }}
      </b-card-text>

      <p>
        <b-button
          style="color: white"
          variant="info"
          size="sm"
          class="mr-4"
          v-if="!full"
          @click="showBlog"
          >Read More</b-button
        >{{ blog.blog_category.title }}
      </p>
    </b-card>
  </div>
</template>

<script>
  export default {
    computed: {
      imageSrc() {
        if (this.blog.default_image) {
          return '/storage/images/blog/' + this.blog.default_image;
        } else {
          return '/images/blog.png';
        }
      },
      admin() {
        return this.$store.getters.user.admin;
      },
    },
    props: {
      blog: {
        required: true,
      },
      full: {
        default: false,
      },
    },
    methods: {
      deleteBlog() {
        axios
          .delete(`/api/v1/blog/${this.blog.id}`)
          .then(results => {
            this.$root.$emit('sendMessage', 'Blog Deleted');
            setTimeout(() => {
              this.$router.push({ name: 'blog' });
            }, 3000);
          })
          .catch(error => {
            console.log(error);
            this.$root.$emit('sendMessage', 'Failed to delete blog');
          });
      },
      showBlog() {
        if (!this.full) {
          this.$router.push({
            name: 'blog-single',
            params: {
              id: this.blog.id,
              long_title: this.blog.title
                .split(' ')
                .join('-')
                .replace(/[^a-zA-Z0-9- ]/g, '')
                .toLowerCase(),
            },
          });
        }
      },
    },
  };
</script>
