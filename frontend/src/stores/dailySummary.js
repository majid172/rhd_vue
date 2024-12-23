import { defineStore } from "pinia";
import axios from "axios";
import router from "@/router/index.js";

export const useDailySummaryStore = defineStore('dailySummary', {
  state: () => ({
    cashDetails: [],
    etcDetails: [],
    exemptDetails: [],  // Fixed typo here from 'examptDetails'
    inputField: {
      selectedBridgeId: null,
      plaza_id: null,
      inputDate: null,
      inputStartTime: null,
      inputEndTime: null,
    }
  }),
  actions: {
    async showDailyReport() {
      try {
        const { data } = await axios.post('http://127.0.0.1:8000/api/summary/daily/report/show', this.inputField);

        this.cashDetails = data.cashDetails;
        this.etcDetails = data.etcDetails;
        this.exemptDetails = data.exemptDetails;  //
        
        router.push({
          name: "dailySummaryReport",
          params: {
            cashDetails: this.cashDetails,
            etcDetails: this.etcDetails,
            exemptDetails: this.exemptDetails,
          },
        });
      } catch (error) {
        console.error("Failed to fetch the report:", error);
      }
    }
  }
});
