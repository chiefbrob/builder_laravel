<template>
  <div>
    <nav-root></nav-root>
    <h4>Admin Panel</h4>
    <admin-users class="mb-5 py-5"></admin-users>
    <page-footer></page-footer>
  </div>
</template>

<script>
  import AdminUsers from './AdminUsers';
  export default {
    components: {
      AdminUsers,
    },
  };
</script>
