import { defineStore } from "pinia";
import axios from "axios";

export const useGraphStore = defineStore('graph', {
  state: () => ({
    piecharts: [],
    barcharts: [],
    linecharts: [],
    areacharts: []
  }),
  actions: {
    async fetchGraph() {
      try {
        const { data } = await axios.get('/graph');
        console.log(data);
        this.piecharts = data.chartTwo;
        this.barcharts = data.chartOne || [];
        this.linecharts = data.chartThree || [];
        this.areacharts = data.chartFour || [];
      } catch (error) {
        console.error("Error fetching graph data:", error);
        this.piecharts = [];
        this.areacharts = [];
      }
    }
  }
});
