<template>
  <div class="chart-container" style="height: 220px; width: 100%; position: relative; z-index: 1;">
    <canvas ref="barChart" width="400" height="200"></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js/auto';

export default {
  name: 'DashboardBarChart',
  props: {
    chartData: {
      type: Object,
      required: true
    },
    sourceRef: {
      type: String,
      default: 'beranda' // Default source is 'beranda', can be overridden with 'strukturorganisasi'
    }
  },
  data() {
    return {
      chart: null,
      hoveredIndex: -1,
      gradient: null
    };
  },
  mounted() {
    this.$nextTick(() => {
      this.renderChart(this.chartData);
    });
  },
  methods: {
    renderChart(data) {
      const ctx = this.$refs.barChart.getContext('2d');
      
      if (this.chart) {
        this.chart.destroy();
      }
      
      // Create gradient
      this.gradient = ctx.createLinearGradient(0, 0, 0, 300);
      this.gradient.addColorStop(0, '#6AD2E1');   // Top color
      this.gradient.addColorStop(1, '#1C869D');   // Bottom color
      
      const highlightGradient = ctx.createLinearGradient(0, 0, 0, 300);
      highlightGradient.addColorStop(0, '#84E9F7');   // Top color (lighter for highlight)
      highlightGradient.addColorStop(1, '#2AA7BD');   // Bottom color (stronger for highlight)
      
      // Generate background colors based on hover state
      const backgroundColors = data.trainingCounts.map((_, i) => this.hoveredIndex === i ? highlightGradient : this.gradient);
      
      this.chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.divisions,
          datasets: [{
            label: 'Total Trainings',
            data: data.trainingCounts,
            backgroundColor: backgroundColors,
            borderColor: '#1C869D',
            borderWidth: 2,
            borderRadius: 8,
            // Store original division names for tooltip
            originalNames: data.originalNames || data.divisions,
            // Store division IDs for navigation
            divisionIds: data.divisionIds || [],
            hoverBackgroundColor: highlightGradient,
            hoverBorderColor: '#2AA7BD',
            hoverBorderWidth: 3
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          animation: {
            duration: 1000,
            easing: 'easeOutQuart'
          },
          onClick: (e) => {
            // Handle click event
            const points = this.chart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true);
            
            if (points.length) {
              const firstPoint = points[0];
              const index = firstPoint.index;
              const divisionId = this.chart.data.datasets[0].divisionIds[index];
              
              if (divisionId) {
                this.navigateToDivision(divisionId);
              }
            }
          },
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              enabled: true,
              backgroundColor: 'rgba(255, 255, 255, 0.8)',
              titleColor: '#1C869D',
              titleFont: {
                size: 14,
                weight: 'bold'
              },
              bodyColor: '#333',
              bodyFont: {
                size: 13
              },
              borderColor: '#1C869D',
              borderWidth: 2,
              cornerRadius: 6,
              padding: 12,
              displayColors: false,
              intersect: false,
              mode: 'index',
              callbacks: {
                title: function(tooltipItems) {
                  const index = tooltipItems[0].dataIndex;
                  const dataset = tooltipItems[0].dataset;
                  // Show original division name if available
                  return dataset.originalNames && dataset.originalNames[index]
                    ? dataset.originalNames[index]
                    : tooltipItems[0].label;
                },
                label: function(context) {
                  return `Total Trainings: ${context.raw}`;
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
                color: 'rgba(255, 255, 255, 0.3)',
                lineWidth: 1
              },
              ticks: {
                color: '#333',
                font: {
                  size: 12,
                  weight: 'bold'
                },
                precision: 0,
                callback: function(value) {
                  return value;
                }
              },
              border: {
                color: 'rgba(0, 0, 0, 0.1)'
              }
            }
          },
          barPercentage: 0.7,
          categoryPercentage: 0.8
        }
      });
    },
    
    navigateToDivision(divisionId) {
      // Navigate to the division details page with source reference
      // You can use Vue Router or window.location depending on your setup
      
      // Option 1: Using Vue Router (recommended for SPA)
      if (this.$router) {
        this.$router.push({ 
          name: 'division.show', 
          params: { id_divisi: divisionId },
          query: { ref: this.sourceRef } // Add source reference as query parameter
        });
      } else {
        // Option 2: Using window.location (fallback)
        window.location.href = `/user/division/${divisionId}?ref=${this.sourceRef}`;
      }
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
  background-color: rgba(255, 255, 255, 0.1);
  overflow: visible !important;
  cursor: pointer; /* Add pointer cursor to indicate clickable */
}

/* Ensure canvas doesn't clip content */
canvas {
  overflow: visible !important;
}
</style>