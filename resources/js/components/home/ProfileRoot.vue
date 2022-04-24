<template>
  <div>
    <nav-root></nav-root>

    <div class="row py-4">
      <b-card no-body class="overflow-hidden col-md-6 offset-md-3 py-2 ">
        <b-row no-gutters>
          <b-col md="6">
            <b-card-img
              :src="$store.getters.avatarUrl"
              :alt="$store.state.user.name"
              class="rounded-0"
            ></b-card-img>
          </b-col>
          <b-col md="6">
            <b-card-body :title="$store.state.user.name">
              <b-card-text>
                <p>
                  Howdy {{ $store.state.user.admin ? 'Admin' : 'User' }}
                  {{ $store.state.user.name }}, <br />
                  You created this account <b>{{ $store.state.user.created_at | relative }}</b>
                </p>
                <p>
                  <b-button @click="$router.push({ name: 'profile-edit' })" variant="primary"
                    >Edit Profile</b-button
                  >
                </p>
              </b-card-text>
            </b-card-body>
          </b-col>
        </b-row>
      </b-card>
    </div>
  </div>
</template>

<script>
  export default {
    methods: {
      startDriving() {
        console.log('Starting Driving');
      },
    },
  };
</script>
