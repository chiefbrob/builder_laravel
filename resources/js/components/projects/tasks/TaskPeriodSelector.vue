<template>
  <b-form-datepicker
    v-model="period"
    :max="max"
    @input="periodUpdated"
    locale="en"
  ></b-form-datepicker>
</template>

<script>
  export default {
    data() {
      return {
        period: null,
        periods: [],
      };
    },
    methods: {
      periodUpdated(period) {
        this.$emit('periodUpdated', period);
      },
    },
    computed: {
      max() {
        const maxDate = new Date();
      },
    },
  };
</script>
