<template>
  <div class="container">
    <div class="row mb-5 py-5">
      <b-card no-body class="overflow-hidden col-md-8 offset-md-2 py-2 ">
        <b-row no-gutters>
          <b-col md="3">
            <b-card-img
              :src="$store.getters.avatarUrl"
              :alt="$store.state.user.name"
              class="rounded-0"
            ></b-card-img>
          </b-col>
          <b-col md="9">
            <b-card-title style="text-align: center;" class="mt-2">
              <span v-text="$store.state.user.name"></span
            ></b-card-title>
            <b-card-body>
              <b-card-text style="text-align: center;">
                <p>
                  Howdy <u>{{ $store.state.user.admin ? 'Admin' : 'User' }}</u>
                  <b>{{ $store.state.user.name }}</b
                  >, <br />
                  You created this account <b>{{ $store.state.user.created_at | relative }}</b>
                </p>
                <p>
                  <b-button
                    size="sm"
                    @click="$router.push({ name: 'profile-edit' })"
                    variant="primary"
                    >Edit Profile</b-button
                  >
                  <b-button size="sm" variant="dark" @click="$router.push({ name: 'contacts' })"
                    >My Contacts</b-button
                  >
                </p>
              </b-card-text>
            </b-card-body>
          </b-col>
        </b-row>
      </b-card>
      <address-manager
        v-if="$featureIsEnabled('shop')"
        class="col-md-8 offset-md-2 mt-3"
      ></address-manager>
    </div>
  </div>
</template>

<script>
  import AddressManager from '../shop/address/AddressManager.vue';
  export default {
    components: { AddressManager },
    methods: {
      startDriving() {
        //
      },
    },
  };
</script>
