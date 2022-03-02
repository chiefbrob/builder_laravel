<template>
  <div>
    <nav-root></nav-root>
    <div class="row">
      <b-card
        :title="user.name"
        :img-src="user.icon"
        img-alt="Image"
        img-top
        tag="article"
        class="col-md-4 offset-md-4"
      >
        <b-card-text>
          <p>Registered: {{ user.created_at | relative }}</p>
          <p v-if="false">Rides Count: 12</p>
          <p>Role: User</p>
        </b-card-text>

        <b-button @click="$router.push({ name: 'profile-edit' })" variant="primary"
          >Edit Profile</b-button
        >
        <b-button v-if="false" @click="startDriving" variant="success">Start Driving</b-button>
      </b-card>
    </div>
  </div>
</template>

<script>
  export default {
    computed: {
      user() {
        return this.$store.state.user;
      },
    },
    methods: {
      startDriving() {
        console.log('Starting Driving');
      },
    },
  };
</script>
