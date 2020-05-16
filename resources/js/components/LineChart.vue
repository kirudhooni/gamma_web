<script>
import { Line } from "vue-chartjs";

export default {
  extends: Line,
  name: "LineChart",
  props: [
      "data",
      "labelName",
  
  ],
  mounted() {
    // reformat in the way the lib wants
    let chartData = {
      labels: [],
      datasets: [
        {
          label: this.labelName,
          backgroundColor: "#3d5a80",
          data: []
        }
      ]
    };

    for (let i = 0; i < this.data.length; i++) {
      chartData.labels.push(this.data[i].date);
      chartData.datasets[0].data.push(this.data[i].views);
    }

    this.renderChart(chartData, {
      responsive: true,
      maintainAspectRatio: false
    });
    
    
  }
};
</script>