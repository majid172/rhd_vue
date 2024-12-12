import { defineStore } from "pinia";
import axios from "axios";

export const useMonthlySummaryStore = defineStore("monthlySummary", {
  state: () => ({
    transactionCount: [],
    inputField: {
      selectedBridgeId: null,
      plaza_id: null,
      month: null,
      payment_type: null,
      report_type: null,
    },
  }),
  actions: {

    validateInputs() {
      const { selectedBridgeId, plaza_id, month, payment_type, report_type } = this.inputField;

      if (!selectedBridgeId) return "Please select a bridge.";
      if (!plaza_id) return "Please select a plaza.";
      if (!month) return "Please select a month.";
      if (!payment_type) return "Please select a payment type.";
      if (!report_type) return "Please select a report type.";

      return true;
    },

    /**
     * Fetch and process the monthly report
     */
    async showMonthlyReport() {
      const validation = this.validateInputs();
      if (validation !== true) {
        alert(validation);
        return;
      }

      try {
        // console.log("Generating report with data:", this.inputField);
        const {data} = await axios.get('http://127.0.0.1:8000/api/summary/daily/report');
        console.log(data);


      } catch (error) {
        console.error("Error generating report:", error);
        alert("Failed to generate report. Please try again.");
      }
    },
  },
});
