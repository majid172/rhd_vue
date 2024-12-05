import { defineStore } from "pinia";
import axios from "axios";
import router from "@/router";

export const useRealtimeStore = defineStore("realtime", {
  state: () => ({
    realtimeDatas: [],
    inputField: {
      selectedBridgeId: null,
      plaza_id: null,
    },
  }),
  actions: {
    async realtimeReport() {
      try {
        // Validate input fields
        if (!this.inputField.selectedBridgeId || !this.inputField.plaza_id) {
          console.error("Validation failed: Missing required fields.");
          return;
        }

        // API request
        const { data } = await axios.post(
          `http://127.0.0.1:8000/api/realtime/show/`,
          this.inputField
        );

        // Update state with the fetched data
        this.realtimeDatas = data;

        console.log("Fetched data:", data);
      } catch (error) {
        console.error("Failed to fetch the report:", error.response?.data || error.message);
      }
    },
  },
});
