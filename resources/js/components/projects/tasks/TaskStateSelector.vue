<template>
  <div>
    <multiselect
      :close-on-select="false"
      :searchable="true"
      :multiple="true"
      v-model="selectedStates"
      :options="taskStates"
      style="padding: 0;"
      @input="updated"
      placeholder="Select state"
    ></multiselect>
  </div>
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
        selectedStates: ['OPEN'],
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
