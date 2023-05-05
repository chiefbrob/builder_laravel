<template>
  <div>
    <div class="pb-5 row">
      <my-contacts class="col-md-10 offset-md-1 py-4"></my-contacts>
    </div>
  </div>
</template>

<script>
  import MyContacts from './MyContacts';
  export default {
    components: { MyContacts },
  };
</script>
