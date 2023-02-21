<template>
  <b-form-select
    multiple="multiple"
    v-model="selectedStates"
    :options="taskStates"
    :select-size="4"
    @input="updated"
  ></b-form-select>
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
        let states = ['OPEN', 'READY', 'DOING', 'REVIEWING', 'DONE', 'CANCELLED'];

        return states.map(state => {
          return {
            value: state,
            text: state,
          };
        });
      },
    },
    methods: {
      updated(data) {
        this.$emit('updated', data);
      },
    },
  };
</script>
