<template>
  <div>
    <h6>
      Address Manager <i class="fa fa-spinner" v-if="loading"></i>
      <b-button size="sm" class="float-right text-white" variant="info"
        ><i class="fa fa-plus"></i
      ></b-button>
    </h6>

    <div class="row" v-if="addresses.length > 0">
      <div class="col-md-6" v-for="address in addresses" :key="address.id">
        <my-address :address="address"></my-address>
      </div>
    </div>
  </div>
</template>

<script>
  import MyAddress from './MyAddress.vue';
  export default {
    components: { MyAddress },
    data() {
      return {
        addresses: [],
        loading: true,
      };
    },
    created() {
      this.loadAddresses();
    },
    methods: {
      loadAddresses() {
        this.loading = true;
        axios
          .get('/api/v1/addresses')
          .then(response => {
            this.addresses = response.data.data;
          })
          .catch(e => {
            this.$root.$emit('sendMessage', 'Failed to load addresses');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
