<template>
  <div>
    <h6>
      Address Manager <i class="fa fa-spinner" v-if="loading"></i>
      <b-button
        v-b-modal="'create-address-modal'"
        size="sm"
        class="float-right text-white"
        variant="info"
        ><i class="fa fa-plus"></i
      ></b-button>
    </h6>

    <b-modal
      hide-footer
      no-close-on-backdrop
      no-close-on-esc
      :ref="`create-address-modal`"
      :id="`create-address-modal`"
      title="New Address"
    >
      <address-form :errors="errors" @submitted="createAddress"></address-form>
    </b-modal>

    <div class="row mt-3" v-if="addresses.length > 0">
      <my-address
        class="col-md-6"
        v-for="address in addresses"
        :key="address.id"
        :address="address"
        @updated="loadAddresses"
      ></my-address>
    </div>
    <div class="row mt-3" v-else>
      <div class="col-md-6 offset-md-3">
        <p v-if="loading"><i class="fa fa-spinner"></i> Loading...</p>
        <p v-else>
          No Addresses found.
          <b-button
            v-b-modal="'create-address-modal'"
            size="sm"
            class="float-right text-white"
            variant="info"
            ><i class="fa fa-plus"></i> New address</b-button
          >
        </p>
      </div>
    </div>

    <b-pagination
      @input="pageChanged"
      v-model="meta.currentPage"
      v-if="meta.lastPage > 1"
      :total-rows="meta.total"
      :per-page="meta.perPage"
      aria-controls="addresses-paginator"
    ></b-pagination>
  </div>
</template>

<script>
  import MyAddress from './MyAddress.vue';
  import AddressForm from './AddressForm.vue';
  export default {
    components: { AddressForm, MyAddress },
    data() {
      return {
        addresses: [],
        loading: true,
        errors: [],
        meta: {
          currentPage: 1,
          lastPage: 1,
          total: 0,
          perPage: 15,
        },
      };
    },
    created() {
      this.loadAddresses();
    },
    methods: {
      loadAddresses() {
        this.loading = true;
        axios
          .get(`/api/v1/addresses/?page=${this.meta.currentPage}`)
          .then(response => {
            this.addresses = response.data.data;

            this.meta.currentPage = response.data.current_page;
            this.meta.total = response.data.total;
            this.meta.perPage = response.data.per_page;
            this.meta.lastPage = response.data.last_page;
          })
          .catch(e => {
            this.$root.$emit('sendMessage', 'Failed to load addresses');
          })
          .finally(f => {
            this.loading = false;
          });
      },
      createAddress(form) {
        axios
          .post('/api/v1/addresses', form)
          .then(response => {
            this.loadAddresses();
            this.$root.$emit('sendMessage', 'Address Created', 'success');
            this.$refs[`create-address-modal`].hide();
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to address!');
          });
      },

      pageChanged(page) {
        this.currentPage = page;
        this.loadAddresses();
      },
    },
  };
</script>
