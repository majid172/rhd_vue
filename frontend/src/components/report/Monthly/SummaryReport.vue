<script setup>
import { onMounted, computed, ref } from "vue";
import { useMonthlySummaryStore } from "@/stores/monthlySummary";
// import { router } from "vue-router";

// Access the store
const monthlySummaryStore = useMonthlySummaryStore();

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

// Corrected paymentType computed property
const paymentType = computed(() => {
  const pay_type = monthlySummaryStore.inputField.payment_type;
  let type = "N/A";  // Default value in case of an invalid or undefined payment_type

  if (pay_type === 1) {
    type = "Cash";
  } else if (pay_type === 2) {
    type = "Exempt";
  } else if (pay_type === 3) {
    type = "ETC";
  }

  return type;
});

// Report type based on report_type value (Transaction Count or Amount)
const reportType = computed(() => {
  const r_type = monthlySummaryStore.inputField.report_type;
  return r_type === 1 ? 'Transaction Count' : 'Transaction Amount';
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
        Monthly <span v-if="isLoading">Loading... </span>
        <span v-else>{{ paymentType }} </span>
        Summary Report for
        <span v-if="isLoading">Loading...</span>
        <span v-else>{{ formattedMonth }}</span>
      </h5>
      </div>
      <div class="mt-3 mx-5">
      <router-link to="/monthly/summary" class="btn rounded-pill btn-outline-primary">Back</router-link>
      </div>

    </div>

      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <thead>
              <tr>
                <!-- Display the report type header -->
                <th colspan="12" class="text-left"><span v-if="isLoading">Loading...</span>
                  <span v-else>{{ reportType }}</span></th>
              </tr>
              <tr>
                <th class="text-center">Day</th>
                <th class="text-center">MOTORCYCLE</th>
                <th class="text-center">SEDAN CAR</th>
                <th class="text-center">MINI TRUCK</th>
                <th class="text-center">MICROBUS</th>
                <th class="text-center">PICKUP</th>
                <th class="text-center">MINIBUS</th>
                <th class="text-center">LARGE BUS</th>
                <th class="text-center">HEAVY TRUCK</th>
                <th class="text-center">TRAILER</th>
                <th class="text-center">AGRO USE</th>
                <th class="text-center">TOTAL TRANSACTIONS</th>
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
                <td class="text-center">{{ report.motorcycle || 0 }}</td>
                <td class="text-center">{{ report.sedancar || 0 }}</td>
                <td class="text-center">{{ report.mini_truck || 0 }}</td>
                <td class="text-center">{{ report.microbus || 0 }}</td>
                <td class="text-center">{{ report.pickup || 0 }}</td>
                <td class="text-center">{{ report.minibus || 0 }}</td>
                <td class="text-center">{{ report.largebus || 0 }}</td>
                <td class="text-center">{{ report.heavy_truck || 0 }}</td>
                <td class="text-center">{{ report.trailer || 0 }}</td>
                <td class="text-center">{{ report.agro_use || 0 }}</td>
                <td class="text-center">{{ report.total_trx || 0 }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

