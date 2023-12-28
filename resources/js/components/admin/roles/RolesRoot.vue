<template>
  <div class="container">
    <div class="mb-5 pb-5 mt-2 row">
      <div class="col-md-10 offset-md-1">
        <h4>
          Roles
          <b-button
            @click="$router.push({ name: 'new-role' })"
            class="float-right text-white"
            size="sm"
            variant="info"
            >New Role</b-button
          >
        </h4>
        <role-list></role-list>
      </div>
    </div>
  </div>
</template>

<script>
  import RoleList from './RoleList';
  export default {
    components: {
      RoleList,
    },
    props: [],
    data() {
      return {};
    },
    computed: {
      user() {
        return this.$store.getters.user;
      },
    },
    methods: {},
    created() {},
  };
</script>
