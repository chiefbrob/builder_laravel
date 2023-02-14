<template>
  <b-button :variant="variant" href="#" v-on:click.prevent @success="copied" v-clipboard="content"
    >{{ content }} <i class="fa fa-clipboard"></i
  ></b-button>
</template>

<script>
  export default {
    props: {
      content: {
        required: true,
      },
      variant: {
        default: 'success',
      },
    },
    methods: {
      copied() {
        this.$root.$emit('sendMessage', 'Copied to clipboard', 'success');
      },
    },
  };
</script>
