<template>
  <b-card class="p-0">
    <b-card-title
      ><span class="pointer" @click="viewOrder">{{ order.reference }}</span>
    </b-card-title>
    <b-card-sub-title>{{ order.sub_total | kes }}</b-card-sub-title>

    <b-card-text>
      {{ order.created_at | relative }} <br />
      <p v-if="full || admin">
        <a :href="`tel:${order.address.phone_number}`"><i class="fa fa-phone"></i></a>
        <b>{{ order.address.first_name }} {{ order.address.last_name }}</b>

        <br />
        <i>{{ order.address.street_address }}</i>
      </p>
    </b-card-text>

    <b-list-group>
      <b-list-group-item v-for="item in order.cart" :key="item.id"
        >{{ item.quantity }} x {{ item.product_variant.name }}</b-list-group-item
      >
    </b-list-group>
    <b-card-footer>
      <b-button @click="viewOrder" v-if="!full" size="sm" variant="link" class="float-right"
        >Track</b-button
      >
      <b-badge variant="success">{{ order.status }}</b-badge>
    </b-card-footer>
    <b-card-text v-if="admin">
      <b-form-select
        :disabled="loading"
        v-model="form.status"
        :options="statusOptions"
      ></b-form-select>
      <b-form-textarea
        :disabled="loading"
        v-model="form.notes"
        rows="2"
        placeholder="notes"
      ></b-form-textarea>
      <b-button
        size="sm"
        class="text-white"
        variant="info"
        @click="updateOrder"
        :disabled="updateDisabled || loading"
        >Update Order</b-button
      >
      <i class="fa fa-spinner" v-if="loading"></i>
    </b-card-text>
    <b-card-text v-if="full">
      <p v-for="state in order.invoice_states" :key="state.id">
        <b>{{ state.status }}</b> | {{ state.created_at | relative }} | {{ state.user.name }} ({{
          '@' + state.user.username
        }}) <br />
        <i>{{ state.notes }} </i>
      </p>
    </b-card-text>
  </b-card>
</template>

<script>
  export default {
    props: {
      order: {
        required: true,
      },
      full: {
        required: false,
        default: false,
      },
    },
    data() {
      return {
        form: {
          status: this.order.status,
          notes: null,
          invoice_id: this.order.id,
        },
        statusOptions: ['PENDING', 'PAID', 'DELIVERY', 'COMPLETE', 'CANCELLED'],
        loading: false,
      };
    },
    computed: {
      user() {
        return this.$store.getters.user;
      },
      admin() {
        return this.user && this.user.admin;
      },
      updateDisabled() {
        return this.order.status === this.form.status;
      },
    },
    methods: {
      viewOrder() {
        this.$router.push({
          name: 'view-order',
          params: { reference: this.order.reference },
        });
      },
      updateOrder() {
        this.loading = true;
        axios
          .post(`/api/v1/invoices/${this.order.reference}/invoice-states`, this.form)
          .then(response => {
            this.$emit('updated');
          })
          .catch(e => {
            console.log(e);
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
