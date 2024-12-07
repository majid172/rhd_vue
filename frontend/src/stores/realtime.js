import { defineStore } from 'pinia';
import axios from 'axios';
import router from '@/router';

export const useRealtimeStore = defineStore('realtime', {
  state: () => ({
    realtimeDatas: JSON.parse(localStorage.getItem('realtimeDatas')) || [],
    total_toll: JSON.parse(localStorage.getItem('total_toll')) || [],
    total_etc: JSON.parse(localStorage.getItem('total_etc')) || [],
    inputField: {
      selectedBridgeId: null,
      plaza_id: null,
    },
    loading: false,
    error: null,
  }),
  actions: {
    async realtimeReport() {
      this.error = null;

      try {
        if (!this.inputField.selectedBridgeId || !this.inputField.plaza_id) {
          this.error = 'Please select both a bridge and a plaza.';
          return;
        }

        this.loading = true;

        const { data } = await axios.post(
          `http://127.0.0.1:8000/api/realtime/show/`,
          this.inputField
        );

        this.realtimeDatas = data.transactions;
        this.total_toll = data.total_toll;
        this.total_etc = data.total_etc;

        // Save fetched data to localStorage
        localStorage.setItem('realtimeDatas', JSON.stringify(this.realtimeDatas));
        localStorage.setItem('total_toll', JSON.stringify(this.total_toll));
        localStorage.setItem('total_etc', JSON.stringify(this.total_etc));

        console.log('Fetched data:', data);

        router.push({ name: 'realtimedataShow' });

        this.loading = false;
        this.inputField.selectedBridgeId = null;
        this.inputField.plaza_id = null;
      } catch (error) {
        this.loading = false;
        this.error = 'Failed to fetch the report. Please try again later.';
        console.error('Failed to fetch the report:', error.response?.data || error.message);
      }
    },

    resetState() {
      this.loading = false;
      this.error = null;
    },

    clearStoredData() {
      // Method to clear the data from localStorage
      localStorage.removeItem('realtimeDatas');
      this.realtimeDatas = [];
    },
  },
});
