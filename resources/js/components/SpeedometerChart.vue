<template>
  <div class="flex flex-col items-center">
    <!-- Speedometer Wrapper -->
    <div class="relative w-40 h-40 flex items-center justify-center">
      <svg viewBox="0 0 200 190" class="w-full h-full">
        <!-- Background Track -->
        <path
          d="M 10 100 A 90 90 0 0 1 190 100"
          fill="none"
          stroke="#e5e7eb"
          stroke-width="20"
          opacity="0.3"
        />

        <!-- Progress Arc -->
        <path
          :d="arcPath"
          fill="none"
          stroke="url(#speedometerGradient)"
          stroke-width="20"
          stroke-linecap="round"
        />

        <!-- Gradient Definition -->
        <defs>
          <linearGradient id="speedometerGradient">
            <stop offset="0%" :stop-color="colorFrom" />
            <stop offset="50%" stop-color="yellow" />
            <stop offset="100%" :stop-color="colorTo" />
          </linearGradient>
        </defs>

        <!-- Gambar berdasarkan label -->
        <image 
          :href="getIconImage"
          x="50" 
          y="60" 
          width="100" 
          height="100"
        />

        <!-- Percentage Text -->
        <text x="105" y="120" font-size="35" font-weight="bold" text-anchor="middle" fill="#fff">
          {{ animatedPercentage }}%
        </text>
      </svg>
    </div>

    <!-- Label -->
    <div class="-mt-1 px-4 py-1 rounded-full text-lg font-bold text-white" :class="labelBgColor">
      {{ label }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    percentage: {
      type: Number,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    colorFrom: {
      type: String,
      default: "#10b981"
    },
    colorTo: {
      type: String,
      default: "#22c55e"
    }
  },
  data() {
    return {
      animatedPercentage: 0,
      progressValue: 0
    };
  },
  computed: {
    arcPath() {
      const startAngle = Math.PI;
      const endAngle = startAngle + (Math.PI * this.progressValue / 100);
      const radius = 90;
      const startX = 100 + radius * Math.cos(startAngle);
      const startY = 100 + radius * Math.sin(startAngle);
      const endX = 100 + radius * Math.cos(endAngle);
      const endY = 100 + radius * Math.sin(endAngle);
      const largeArcFlag = this.progressValue > 50 ? 1 : 0;

      return `M ${startX} ${startY} A ${radius} ${radius} 0 ${largeArcFlag} 1 ${endX} ${endY}`;
    },
    labelBgColor() {
      if (this.label === "LOW RELEVANCE") return "bg-yellow-400";
      if (this.label === "MEDIUM RELEVANCE") return "bg-blue-300";
      if (this.label === "HIGH RELEVANCE") return "bg-blue-900";
      return "";
    },
    getIconImage() {
      // Menentukan gambar berdasarkan label
      if (this.label === "LOW RELEVANCE") {
        return "/img/icon-diagram-low.png";
      } else if (this.label === "MEDIUM RELEVANCE") {
        return "/img/icon-diagram-medium.png";
      } else if (this.label === "HIGH RELEVANCE") {
        return "/img/icon-diagram-high.png";
      }
      return ""; // Jika label tidak diketahui, kembalikan kosong
    }
  },
  mounted() {
    this.animateProgress();
  },
  methods: {
    animateProgress() {
      const duration = 1000;
      const startTime = performance.now();
      const animate = (currentTime) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        this.progressValue = this.percentage * progress;
        this.animatedPercentage = Math.round(this.progressValue);

        if (progress < 1) {
          requestAnimationFrame(animate);
        }
      };
      requestAnimationFrame(animate);
    }
  }
};
</script>
