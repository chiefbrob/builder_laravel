<template>
  <b-button
    size="sm"
    :variant="variant"
    href="#"
    v-on:click.prevent
    @success="copied"
    v-clipboard="content"
    ><slot v-if="$slots.default"></slot>
    <span v-else><i class="fa fa-clipboard"></i> Copy</span></b-button
  >
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
