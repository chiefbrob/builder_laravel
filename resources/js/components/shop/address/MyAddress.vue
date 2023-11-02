<template>
  <b-card>
    <b-card-title>
      {{ address.street_address.substr(0, 20) }}
    </b-card-title>
    <b-card-sub-title>created {{ address.created_at | relative }}</b-card-sub-title>
    <b-card-text>
      {{ address.first_name }} {{ address.last_name }} <br />
      {{ address.street_address }} <br />
      <span>{{ address.phone_number }}</span>
    </b-card-text>
    <b-card-footer>
      <span v-if="defaultAddress"><i class="fa fa-star" style="color: gold"></i> Default</span>
      <span v-else
        ><b-button :disabled="loading" @click="setDefault" variant="link" size="sm"
          >Set Default</b-button
        ></span
      >
      <b-button :disabled="loading" class="float-right" size="sm" variant="link"
        ><i class="fa fa-pen"></i
      ></b-button>
      <b-button :disabled="loading" class="float-right" style="color: red" size="sm" variant="link"
        ><i class="fa fa-trash-can"></i></b-button
    ></b-card-footer>
  </b-card>
</template>

<script>
  export default {
    props: {
      address: {
        required: true,
      },
    },
    data() {
      return {
        loading: false,
      };
    },
    computed: {
      user() {
        return this.$store.getters.user;
      },
      defaultAddress() {
        return this.user.default_address_id === this.address.id;
      },
    },
    methods: {
      setDefault() {
        this.loading = true;
        const form = { ...this.address, set_default: 'true' };
        axios
          .put(`/api/v1/addresses/${this.address.id}`, form)
          .then(results => {
            this.$root.$emit('sendMessage', 'Default address updated', 'success');
            this.$root.$emit('loadUser');
          })
          .catch(e => {
            this.$root.$emit('sendMessage', 'Failed to update Address');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
