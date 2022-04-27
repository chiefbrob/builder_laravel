<template>
  <img
    style="border-radius: 50%; margin-left: auto;
  margin-right: auto;
  width: 50%; display: block;"
    :src="url"
  />
</template>

<script>
  export default {
    props: {
      user: {
        required: false,
        default: null,
      },
    },
    computed: {
      url() {
        if (this.user) {
          if (this.user.photo) {
            return '/storage/images/profile/' + this.user.photo;
          } else {
            return '/images/avatar.png';
          }
        }
        return this.$store.getters.avatarUrl;
      },
    },
  };
</script>
