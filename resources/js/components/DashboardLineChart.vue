<template>
    <div class="chart-container" style="height: 280px; width: 100%; position: relative; z-index: 1;">
      <canvas ref="lineChart" width="400" height="200"></canvas>
    </div>
  </template>
  
  <script>
  import Chart from 'chart.js/auto';
  
  export default {
    name: 'DashboardLineChart',
    props: {
      chartData: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        chart: null
      };
    },
    mounted() {
      this.$nextTick(() => {
        this.renderChart(this.chartData);
      });
    },
    methods: {
      renderChart(data) {
        const ctx = this.$refs.lineChart.getContext('2d');
        
        if (this.chart) {
          this.chart.destroy();
        }
        
        // Define colors for each relevance level
        const lowLineColor = '#FF7272'; // Red for low relevance
        const mediumLineColor = '#FFD166'; // Yellow/Orange for medium relevance
        const highLineColor = '#06D6A0'; // Green for high relevance
        
        this.chart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: data.divisions,
            datasets: [
              {
                label: 'Low Relevance',
                data: data.lowRelevance,
                borderColor: lowLineColor,
                backgroundColor: 'rgba(255, 114, 114, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: lowLineColor,
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.3,
                // Store division names and training counts for tooltips
                divisionNames: data.originalNames,
                trainingCounts: data.lowCounts
              },
              {
                label: 'Medium Relevance',
                data: data.mediumRelevance,
                borderColor: mediumLineColor,
                backgroundColor: 'rgba(255, 209, 102, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: mediumLineColor,
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.3,
                // Store division names and training counts for tooltips
                divisionNames: data.originalNames,
                trainingCounts: data.mediumCounts
              },
              {
                label: 'High Relevance',
                data: data.highRelevance,
                borderColor: highLineColor,
                backgroundColor: 'rgba(6, 214, 160, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: highLineColor,
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.3,
                // Store division names and training counts for tooltips
                divisionNames: data.originalNames,
                trainingCounts: data.highCounts
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
              duration: 1000,
              easing: 'easeOutQuart'
            },
            plugins: {
              legend: {
                position: 'top',
                labels: {
                  font: {
                    size: 12,
                    weight: 'bold'
                  },
                  usePointStyle: true,
                  pointStyle: 'circle',
                  padding: 20
                }
              },
              tooltip: {
                enabled: true,
                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                titleColor: '#333',
                titleFont: {
                  size: 14,
                  weight: 'bold'
                },
                bodyColor: '#333',
                bodyFont: {
                  size: 13
                },
                borderColor: '#76DEDB',
                borderWidth: 2,
                cornerRadius: 6,
                padding: 12,
                displayColors: true,
                intersect: false,
                mode: 'index',
                callbacks: {
                  title: function(tooltipItems) {
                    const index = tooltipItems[0].dataIndex;
                    const dataset = tooltipItems[0].dataset;
                    return dataset.divisionNames ? dataset.divisionNames[index] : tooltipItems[0].label;
                  },
                  label: function(context) {
                    const dataset = context.dataset;
                    const index = context.dataIndex;
                    const trainings = dataset.trainingCounts ? dataset.trainingCounts[index] : 0;
                    return `${dataset.label}: ${context.raw} trainings (${trainings} total)`;
                  }
                }
              }
            },
            scales: {
              x: {
                grid: {
                  display: false
                },
                ticks: {
                  color: '#333',
                  font: {
                    size: 12,
                    weight: 'bold'
                  },
                  maxRotation: 45,
                  minRotation: 0
                },
                border: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              },
              y: {
                beginAtZero: true,
                grid: {
                  display: true,
                  color: 'rgba(0, 0, 0, 0.1)',
                  lineWidth: 1
                },
                ticks: {
                  color: '#333',
                  font: {
                    size: 12,
                    weight: 'bold'
                  },
                  precision: 0
                },
                border: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              }
            }
          }
        });
      }
    },
    watch: {
      chartData: {
        handler(newData) {
          this.renderChart(newData);
        },
        deep: true
      }
    }
  };
  </script>
  
  <style scoped>
  .chart-container {
    position: relative;
    margin: auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    padding: 6px;
    background-color: rgba(255, 255, 255, 0.15);
    overflow: visible !important;
  }
  
  /* Ensure canvas doesn't clip content */
  canvas {
    overflow: visible !important;
  }
  </style>