<template>
  <div>
    <b-input-group>
      <vue-phone-number-input
        @update="updated"
        no-flags
        v-model="phone_number"
        default-country-code="KE"
      />
      <field-error :solid="false" :errors="errors" field="phone_number"></field-error>
      {{ phone_number }}
    </b-input-group>
  </div>
</template>

<script>
  export default {
    props: {
      errors: {
        required: false,
        default: () => [],
      },
      required: {
        required: false,
        default: false,
      },
    },
    data() {
      return {
        phone_number: null,
      };
    },
    methods: {
      updated(phone) {
        this.$emit('updated', phone);
      },
    },
  };
</script>
