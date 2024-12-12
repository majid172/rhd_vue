import { defineStore } from 'pinia';
import axios from 'axios';
import router from '@/router';

export const useRealtimeStore = defineStore('realtime', {
  state: () => ({
    reports: [], // Stores fetched data
    loading: false, // Indicates loading state
    error: null, // Holds any error message
    inputField: {
      selectedBridgeId: null, // Bridge ID input
      plaza_id: null,
      lane : null
    },
  }),

  actions: {
    // Fetch Realtime Data and Navigate
    async fetchRealtime() {
      this.loading = true;
      this.error = null;

      try {
      console.log('realtime');

        // API call to fetch data
        const { data } = await axios.post(
          'http://127.0.0.1:8000/api/realtime/show',
          this.inputField
        );

        // Store the fetched data
        this.reports = data;

        // Navigate to the RealtimeShowView with params
        await router.push({
          name: 'realtimeShow',
          params: {
            selectedBridgeId: this.inputField.selectedBridgeId,
            plaza_id: this.inputField.plaza_id,
          },
        });
      } catch (error) {
        console.error('Error fetching realtime data:', error);
        this.error = error.response?.data?.message || 'Failed to fetch realtime data';
      } finally {
        this.loading = false; // Reset loading state
      }
    },

    // Reload Realtime Data based on current route params
    async reloadRealtime() {
      const parameters = router.currentRoute.value.params;

      try {
        const { data } = await axios.post('http://127.0.0.1:8000/api/realtime/show', parameters);

        if (data) {
          this.reports = data;
          console.log(data);

        } else {
          console.log('No existing data to reload.');
        }
      } catch (error) {
        console.error('Error reloading realtime data:', error);
        this.error = error.response?.data?.message || 'Failed to reload realtime data';
      }
    },

    async lanewise(){
    console.log('lane');

      const { data } = await axios.post('http://127.0.0.1:8000/api/realtime/show',this.inputField);
      this.reports = data;


      await router.push({
      name: 'realtimeShow',
      params: {
        selectedBridgeId: this.inputField.selectedBridgeId,
        plaza_id: this.inputField.plaza_id,
        // lane: this.inputField.lane

      }
      });

    },
    async reloadLane(){
      const parameters = router.currentRoute.value.params;
      console.log(parameters);

      const { data } = await axios.post('http://127.0.0.1:8000/api/realtime/show',this.parameters);
      this.reports = data;
      console.log(data);

    }
  },
});
