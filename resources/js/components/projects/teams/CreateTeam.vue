<template>
  <div>
    <nav-root></nav-root>
    <div class="mb-5 pb-5 row">
      <div class="col-md-10 offset-md-1">
        <h4>Create Team</h4>
        <team-form :url="url"></team-form>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  import TeamForm from './TeamForm';
  export default {
    components: { TeamForm },
    props: [],
    data() {
      return {
        url: '/api/v1/admin/teams',
      };
    },
    computed: {},
    methods: {},
    created() {},
  };
</script>
