<template>
  <div class="container">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <file-uploader class="mb-5 pb-5"></file-uploader>
        <phone-number @updated="phoneUpdated"></phone-number>
        <div class="col-md-4">Phone: {{ phone_number }}</div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        phone_number: null,
      };
    },
    methods: {
      phoneUpdated(phone_number) {
        this.phone_number = phone_number;
      },
    },
  };
</script>
