<template>
  <div class="container">
    <div class="pb-5 row">
      <my-contacts class="col-md-10 offset-md-1 py-4"></my-contacts>
    </div>
  </div>
</template>

<script>
  import MyContacts from './MyContacts.vue';
  export default {
    components: { MyContacts },
  };
</script>
