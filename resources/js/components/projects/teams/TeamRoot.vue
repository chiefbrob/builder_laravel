<template>
  <div class="container">
    <div class="mb-5 pb-5 mt-2 row">
      <div class="col-md-10 offset-md-1">
        <h4>
          Teams
          <b-button
            @click="$router.push({ name: 'new-team' })"
            class="float-right text-white"
            size="sm"
            variant="info"
            v-if="admin"
            >New Team</b-button
          >
        </h4>
        <team-list v-if="$root.$featureIsEnabled('teams')"></team-list>
        <div v-else>Teams Not Enabled</div>
      </div>
    </div>
  </div>
</template>

<script>
  import TeamList from './TeamList.vue';
  export default {
    components: {
      TeamList,
    },
    props: [],
    data() {
      return {};
    },
    computed: {
      admin() {
        return this.$store.getters.user?.admin;
      },
    },
    methods: {},
    created() {},
  };
</script>
