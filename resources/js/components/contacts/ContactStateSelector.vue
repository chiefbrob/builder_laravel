<template>
  <multiselect
    :close-on-select="false"
    :searchable="true"
    :multiple="true"
    v-model="selectedStates"
    :options="contactStates"
    @input="updated"
    placeholder="Select contact state"
  ></multiselect>
</template>

<script>
  export default {
    props: {
      multiple: {
        type: Boolean,
        default: true,
      },
    },
    data() {
      return {
        selectedStates: ['PENDING'],
      };
    },
    computed: {
      contactStates() {
        return ['PENDING', 'QUEUED', 'IN_PROGRESS', 'COMPLETE'];
      },
    },
    methods: {
      updated(data) {
        this.$emit('updated', data);
      },
    },
  };
</script>
