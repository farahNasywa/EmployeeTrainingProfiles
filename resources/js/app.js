import { createApp } from 'vue';
import DashboardSpeedometer from './components/DashboardSpeedometer.vue';
import DashboardBarChart from './components/DashboardBarChart.vue';
import DashboardLineChart from './components/DashboardLineChart.vue';

// Mount Speedometer chart
createApp(DashboardSpeedometer).mount('#vue-dashboard-speedometer');

// Mount Bar chart with data from the template
const barChartElement = document.getElementById('vue-dashboard-barchart');
if (barChartElement) {
    const chartData = window.divisionTrainingData || JSON.parse(barChartElement.getAttribute('data-division-training'));
    createApp(DashboardBarChart, { chartData }).mount(barChartElement);
}

// Mount Line chart for division relevance
const lineChartElement = document.getElementById('vue-dashboard-linechart');
if (lineChartElement) {
    const chartData = window.divisionRelevanceData || JSON.parse(lineChartElement.getAttribute('data-division-relevance'));
    createApp(DashboardLineChart, { chartData }).mount(lineChartElement);
}