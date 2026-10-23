<template>
  <div class="flex justify-center gap-2.5 text-center">
    <div class="w-40">
      <SpeedometerChart :percentage="lowPercentage" label="LOW RELEVANCE" />
    </div>
    <div class="w-40">
      <SpeedometerChart :percentage="highPercentage" label="HIGH RELEVANCE" />
    </div>
    <div class="w-40">
      <SpeedometerChart :percentage="mediumPercentage" label="MEDIUM RELEVANCE" />
    </div>
  </div>
</template>

<script>
import SpeedometerChart from './SpeedometerChart.vue';

export default {
  components: {
    SpeedometerChart
  },
  data() {
    return {
      lowPercentage: window.relevanceData.low,
      mediumPercentage: window.relevanceData.medium,
      highPercentage: window.relevanceData.high
    };
  },
};
</script>
