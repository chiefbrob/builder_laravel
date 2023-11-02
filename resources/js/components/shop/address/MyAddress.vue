<template>
  <b-card>
    <b-card-title>
      {{ address.street_address.substr(0, 20) }}
    </b-card-title>
    <b-card-sub-title>created {{ address.created_at | relative }}</b-card-sub-title>
    <b-card-text>
      {{ address.first_name }} {{ address.last_name }} <br />
      {{ address.street_address }} <br />
      <span v-if="address.street_address_2">{{ address.street_address_2 }} <br /></span>
      <span>{{ address.country }}</span> <span>{{ address.city }}</span>
      <span>{{ address.country }}</span>
      <span>{{ address.post_code }}</span>
      <span>{{ address.phone_number }}</span>
    </b-card-text>
    <b-card-footer>
      <span><i class="fa fa-star" style="color: gold"></i> Default</span>
      <b-button class="float-right" size="sm" variant="link"><i class="fa fa-pen"></i></b-button>
      <b-button class="float-right" size="sm" variant="link"
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
  };
</script>
