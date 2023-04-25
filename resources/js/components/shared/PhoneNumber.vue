<template>
  <div>
    <b-input-group>
      <vue-phone-number-input
        @update="updated"
        no-flags
        v-model="phone_number"
        :preferred-countries="['KE', 'UG', 'TZ', 'RW', 'CD', 'BI', 'ZA']"
        style="width: 100%; z-index: 100;"
        default-country-code="KE"
      />
      <field-error :solid="false" :errors="errors" field="phone_number"></field-error>
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
      number: {
        required: false,
        default: null,
      },
    },
    data() {
      return {
        phone_number: this.number,
      };
    },
    methods: {
      updated(phone) {
        if (phone.isValid) {
          this.$emit('updated', phone);
        }
      },
    },
  };
</script>
