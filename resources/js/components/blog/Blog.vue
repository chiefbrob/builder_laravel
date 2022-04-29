<template>
  <div style="">
    <b-card :title="blog.title" :sub-title="blog.subtitle" style="">
      <b-card-img :src="imageSrc" :class="full ? 'py-4' : 'py-2'" :alt="blog.title"></b-card-img>
      <b-card-text v-if="full">
        {{ blog.contents }}
      </b-card-text>

      <h4>
        <b-button style="color: white" variant="info" class="mr-4" v-if="!full" @click="showBlog"
          >Read More</b-button
        >{{ blog.blog_category.title }}
      </h4>
    </b-card>
  </div>
</template>

<script>
  export default {
    computed: {
      imageSrc() {
        if (this.blog.photo) {
          return '/storage/images/blog/' + this.blog.photo;
        } else {
          return '/images/blog.png';
        }
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
