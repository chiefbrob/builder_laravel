<template>
  <div style="">
    <b-card :sub-title="blog.subtitle" style="" v-if="full">
      <b-card-title>
        <div>
          {{ blog.title }}
          <span v-if="user && user.admin" class="float-right ">
            <b-button variant="info" @click="editBlog"
              ><i class="fa fa-pen text-white"></i
            ></b-button>
            <b-button variant="danger" @click="deleteBlog"><i class="fa fa-trash"></i></b-button>
          </span>
          <br />
          <small> {{ blog.user.name }} - {{ blog.created_at | relative }}</small>
        </div>
      </b-card-title>
      <b-card-img :src="imageSrc" :class="full ? 'py-4' : 'py-2'" :alt="blog.title"></b-card-img>
      <b-card-text>
        {{ blog.contents }}
      </b-card-text>
    </b-card>
    <b-card
      v-if="!full"
      :overlay="true"
      @click="showBlog"
      class="pointer"
      :img-src="imageSrc"
      border-variant="light"
      text-variant="light"
      bg-variant="info"
    >
      <b-card-title>
        <span class="black-bkg">{{ blog.title }}</span></b-card-title
      >
      <b-card-text>
        <b-button variant="info" class="text-white" size="sm">View Blog</b-button></b-card-text
      >
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
      user() {
        return this.$store.getters.user;
      },
      admin() {
        return this.user ? this.user.admin : false;
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
      editBlog() {
        this.$router.push({ name: 'blog-edit', params: { id: this.blog.id } });
      },
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
