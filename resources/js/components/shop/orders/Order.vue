<template>
  <b-card class="p-0">
    <b-card-title>{{ order.reference }} </b-card-title>
    <b-card-sub-title>{{ order.sub_total | kes }}</b-card-sub-title>

    <b-card-text> {{ order.created_at | relative }} <br /> </b-card-text>

    <b-list-group>
      <b-list-group-item v-for="item in order.cart" :key="item.id"
        >{{ item.quantity }} x {{ item.product_variant.name }}</b-list-group-item
      >
    </b-list-group>
    <b-card-footer>
      <b-button size="sm" variant="link" class="float-right">Track</b-button>
      <b-badge variant="success">{{ order.status }}</b-badge>
    </b-card-footer>
  </b-card>
</template>

<script>
  export default {
    props: {
      order: {
        required: true,
      },
    },
  };
</script>
