<template>
  <a href="#" v-on:click.prevent @success="copied" v-clipboard="content"
    >{{ content }} <i class="fa fa-clipboard"></i
  ></a>
</template>

<script>
  export default {
    props: ['content'],
    methods: {
      copied() {
        console.log('copied');
      },
    },
  };
</script>
