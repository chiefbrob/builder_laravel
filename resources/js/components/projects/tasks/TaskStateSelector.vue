<template>
  <multiselect
    :close-on-select="false"
    :searchable="true"
    :multiple="true"
    v-model="selectedStates"
    :options="taskStates"
    @input="updated"
    placeholder="Select state"
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
        selectedStates: ['OPEN', 'READY', 'DOING'],
      };
    },
    computed: {
      taskStates() {
        return ['OPEN', 'READY', 'DOING', 'REVIEWING', 'DONE', 'CANCELLED'];
      },
    },
    methods: {
      updated(data) {
        this.$emit('updated', data);
      },
    },
  };
</script>
