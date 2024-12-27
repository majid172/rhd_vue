<script setup>
import { onMounted, computed, ref } from "vue";
import {useEtcMonthlySummaryStore} from "@/stores/etcMonthlySummary.js";
// import { router } from "vue-router";

// Access the store
const monthlySummaryStore = useEtcMonthlySummaryStore();

// Loading state
const isLoading = ref(true);

// Format the selected month for display
const formattedMonth = computed(() => {
  const month = monthlySummaryStore.inputField.month;
  if (!month) return "N/A";

  const [year, monthNumber] = month.split("-");
  const monthNames = [
    "January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"
  ];
  return `${monthNames[parseInt(monthNumber, 10) - 1]} ${year}`;
});


// Function to get the current month in the required format (YYYY-MM)
const getCurrentMonth = () => {
  const now = new Date();
  const year = now.getFullYear();
  const month = String(now.getMonth() + 1).padStart(2, "0"); // Ensure 2-digit month
  return `${year}-${month}`;
};


onMounted(async () => {
  try {
    await monthlySummaryStore.reloadReport();
    isLoading.value = false;

    if (!monthlySummaryStore.inputField.month) {
      monthlySummaryStore.inputField.month = getCurrentMonth();
    }
  } catch (error) {
    console.error("Error reloading report:", error);
    isLoading.value = false;
  }
});
</script>

<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
      <div class="d-flex justify-content-between">
        <div>
          <h5 class="card-header">
            Monthly ETC
            Summary Report for {{monthlySummaryStore.plazaName}}
            <span v-if="isLoading">Loading...</span>
            <span v-else>({{ formattedMonth }})</span>
          </h5>
        </div>
        <div class="mt-3 mx-5">
          <router-link to="/etc/monthly/summary" class="btn rounded-pill btn-outline-primary">Back</router-link>
        </div>

      </div>

      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <thead>
            <tr>
              <td></td>
              <td colspan="4" class="text-center fw-bolder">Trasaction Count</td>
              <td colspan="4" class="text-center fw-bold">Trasaction Amount</td>
            </tr>
            <tr>
              <th class="text-center">Day</th>
              <th class="text-center">Bkash</th>
              <th class="text-center">Upay</th>
              <th class="text-center">Rocket</th>
              <th class="text-center">TOTAL COUNT</th>
              <th class="text-center">Bkash</th>
              <th class="text-center">Upay</th>
              <th class="text-center">Rocket</th>
              <th class="text-center">TOTAL Amount</th>

            </tr>
            </thead>
            <tbody>
            <!-- Check if the data is empty -->
            <tr v-if="monthlySummaryStore.monthlyReports.length === 0">
              <td class="text-center" colspan="12">No data available</td>
            </tr>

            <!-- Loop through monthlyReports and render each row -->
            <tr v-for="(report, index) in monthlySummaryStore.monthlyReports" :key="index">
              <td class="text-center">{{ report.day || "N/A" }}</td>
              <td class="text-center">{{ report.bkash_count || 0 }}</td>
              <td class="text-center">{{ report.upay_count || 0 }}</td>
              <td class="text-center">{{ report.rocket_count || 0 }}</td>
              <td class="text-center">{{ report.transaction_count || 0 }}</td>
              <td class="text-center">{{ report.bkash_amount || 0 }}</td>
              <td class="text-center">{{ report.upay_amount || 0 }}</td>
              <td class="text-center">{{ report.rocket_amount || 0 }}</td>
              <td class="text-center">{{ report.total_amount || 0 }}</td>

            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

