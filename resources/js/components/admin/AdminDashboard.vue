<template>
  <div>
    <nav-root></nav-root>
    <h4>Admin Panel</h4>
    <admin-users></admin-users>
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
