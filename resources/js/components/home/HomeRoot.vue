<template>
  <div>
    <nav-root></nav-root>
    <div class="pb-5 row">
      <my-contacts class="col-md-10 offset-md-1 py-4"></my-contacts>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  import MyContacts from '../contacts/MyContacts';
  export default {
    components: { MyContacts },
  };
</script>
