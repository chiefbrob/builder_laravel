<template>
  <div>
    <div class="mb-5 mt-2 pb-5 mt-2 row">
      <b-card
        class="col-md-10 offset-md-1"
        border-variant="light"
        bg-variant="light"
        text-variant="dark"
      >
        <admin-users></admin-users>
      </b-card>
    </div>
  </div>
</template>

<script>
  import AdminUsers from './AdminUsers';
  export default {
    components: { AdminUsers },
    props: [],
    data() {
      return {};
    },
    computed: {},
    methods: {},
    created() {},
  };
</script>
