<template>
  <div class="container">
    <div class="mb-5 pb-5 mt-2 row">
      <div class="col-md-10 offset-md-1">
        <h4>Admin Panel</h4>
        <admin-users class="mb-5 py-5"></admin-users>
      </div>
    </div>
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
