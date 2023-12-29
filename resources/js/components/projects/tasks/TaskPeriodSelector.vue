<template>
  <div>
    <b-modal
      ref="taskPeriodSelectorModal"
      :ok-disabled="!customStartDate || !customEndDate"
      no-close-on-backdrop
      no-close-on-esc
      ok-only
      @close="closed"
      @ok="customInput"
      title="Select Custom Date"
    >
      <div class="d-block ">
        <b-form-group label="Start date">
          <input
            type="date"
            class="form-control"
            :min="minStartDate"
            :max="maxStartDate"
            @input="startDateChanged"
            v-model="customStartDate"
          />
        </b-form-group>
        <b-form-group label="End date">
          <input
            type="date"
            class="form-control"
            :min="minEndDate"
            :max="maxEndDate"
            @input="endDateChanged"
            v-model="customEndDate"
          />
        </b-form-group>
      </div>
    </b-modal>
    <multiselect
      :close-on-select="true"
      :searchable="true"
      :multiple="true"
      :max="1"
      v-model="period"
      :options="periodOptions"
      @input="periodUpdated"
      :allow-empty="true"
      style="padding: 0;"
      id="task-period-selector"
      ref="taskPeriodSelector"
      placeholder="Select period"
    ></multiselect>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        period: null,
        periods: [],
        customStartDate: null,
        customEndDate: null,
        minEndDate: null,
        minStartDate: null,
        maxEndDate: null,
        maxStartDate: null,
      };
    },
    methods: {
      periodUpdated(period) {
        let newPeriod = '';
        const today = new Date();
        let startDate = new Date();
        if (period.length > 0) {
          let actPeriod = period[0];
          if (actPeriod === 'This week') {
            startDate.setDate(startDate.getDate() - 7);
            newPeriod = this.formatDate(startDate) + '->' + this.formatDate(today);
          } else if (actPeriod === 'Last week') {
            startDate.setDate(startDate.getDate() - 14);
            today.setDate(today.getDate() - 7);
            newPeriod = this.formatDate(startDate) + '->' + this.formatDate(today);
          } else if (actPeriod === 'This month') {
            startDate.setDate(startDate.getDate() - 30);
            newPeriod = this.formatDate(startDate) + '->' + this.formatDate(today);
          } else {
            this.$refs['taskPeriodSelectorModal'].show();
          }
        }
        this.$emit('periodUpdated', newPeriod);
      },
      formatDate(d) {
        return d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate();
      },
      customInput() {
        this.$emit('periodUpdated', this.customStartDate + '->' + this.customEndDate);
      },
      closed() {
        if (!this.customEndDate || !this.customStartDate) {
          this.period = null;
        }
      },
      startDateChanged(d) {
        this.minEndDate = d.target.value;
      },
      endDateChanged(d) {
        this.maxStartDate = d.target.value;
      },
    },
    computed: {
      max() {
        return new Date();
      },
      periodOptions() {
        return ['This week', 'Last week', 'This month', 'Custom'];
      },
    },
  };
</script>

<style scoped></style>
