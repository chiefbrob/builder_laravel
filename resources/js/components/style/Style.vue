<template>
  <div>
    <nav-root></nav-root>
    <file-uploader class="mb-5 pb-5"></file-uploader>
    <div class="row">
        <div class="col-md-4">
            <phone-number @updated="phoneUpdated"></phone-number>
        </div>
        <div class="col-md-4">Phone: {{ phone_number }}</div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  export default {
      data() {
          return {
              phone_number: null,
          }
      },
      methods: {
          phoneUpdated(phone_number) {
              this.phone_number = phone_number;
          }
      }
  };
</script>
