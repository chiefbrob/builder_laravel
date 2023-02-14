<template>
  <div>
    <b-card @click="showRole">
      <b-card-title class="pointer">
        {{ role.name }}
      </b-card-title>
      <b-card-sub-title> {{ role.created_at | relative }} </b-card-sub-title>
      <b-card-text v-if="full">
        {{ role.description }}
      </b-card-text>
    </b-card>
  </div>
</template>

<script>
  export default {
    props: ['role', 'full'],
    data() {
      return {
        loading: false,
        errors: [],
      };
    },
    methods: {
      showRole() {
        if (!this.full) {
          this.$router.push({
            name: 'role-single',
            params: {
              role_id: this.role.id,
            },
          });
        }
      },
    },
  };
</script>
