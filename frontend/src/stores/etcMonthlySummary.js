import { defineStore } from "pinia";
import axios from "axios";
import router from "@/router";

export const useEtcMonthlySummaryStore = defineStore("etcMonthlySummary", {
  state: () => ({
    monthlyReports: [],
    inputField: {
      selectedBridgeId: null,
      selectedPlazaId: null,
      month: null,

    },
  }),
  actions: {
    validateInputs() {
      const { selectedBridgeId, selectedPlazaId, month } =
        this.inputField;

      if (!selectedBridgeId) return "Please select a bridge.";
      if (!selectedPlazaId) return "Please select a plaza.";
      if (!month) return "Please select a month.";
      return true;
    },

    /**
     * Fetch and display the monthly report and update the URL with query params
     */
    async showMonthlyReport() {
      try {
        console.log(this.inputField)
        // Validate inputs
        const validationResult = this.validateInputs();
        if (validationResult !== true) {
          throw new Error(validationResult);
        }

        // Fetch data from API
        const { data } = await axios.post(
          "http://127.0.0.1:8000/api/summary/etc/monthly/show",
          this.inputField
        );

        console.log("Report data:", data);

        // Update state with fetched data
        this.monthlyReports = data.transactions;

        // Update the URL with query parameters and navigate to the report page
        await router.push({
          name: "monthlySummaryReport",
          query: { ...this.inputField },
        });

        console.log("Report generated successfully.");
      } catch (error) {
        console.error("Error fetching monthly report:", error);
        throw error;
      }
    },

    /**
     * Reload the report using the parameters from the current route
     */
    async reloadReport() {
      try {

        const queryParams = router.currentRoute.value.query;

        console.log("Reloading with params:", queryParams);

        // Fetch data using the current query parameters
        const { data } = await axios.post(
          "http://127.0.0.1:8000/api/summary/monthly/show",
          queryParams
        );

        // Update state with fetched data
        this.monthlyReports = data.transactions;

        console.log("Report reloaded successfully.");
      } catch (error) {
        console.error("Error reloading monthly report:", error);
        throw error;
      }
    },
  },
});
