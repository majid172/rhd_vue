<script setup>
import { onMounted } from "vue";
import { useBridgeStore } from "@/stores/bridges.js";
import { useMonthlySummaryStore } from "@/stores/monthlySummary";

// Fetch stores
const bridgeStore = useBridgeStore();
const monthlySummaryStore = useMonthlySummaryStore();

// Fetch bridge data on component mount
onMounted(async () => {
  try {
    await bridgeStore.fetchBridge();
  } catch (error) {
    console.error("Error fetching bridges:", error);
  }
});

// Form submission handler
const validateAndSubmit = async () => {
  try {
    // Call store's action to validate and submit the form
    await monthlySummaryStore.showMonthlyReport();
  } catch (error) {
    console.error("Error generating report:", error);
    alert("Failed to generate report. Please try again.");
  }
};
</script>

<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-6">
      <!-- Header -->
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Monthly Report Form</h5>
      </div>

      <!-- Form -->
      <div class="card-body">
        <form @submit.prevent="validateAndSubmit">
          <div class="row">
            <!-- Bridge Selection -->
            <div class="col-lg-6">
              <div class="mb-4">
                <label for="bridgeSelect" class="form-label">Select Bridge</label>
                <div class="col-md-10">
                  <select id="bridgeSelect" class="form-select" v-model="monthlySummaryStore.inputField.selectedBridgeId">
                    <option value="" disabled>Choose Bridge</option>
                    <option
                      v-for="(bridge, index) in bridgeStore.bridges"
                      :key="index"
                      :value="bridge.id"
                    >
                      {{ bridge.bridge_name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Plaza Selection -->
            <div class="col-lg-6">
              <div class="mb-4">
                <label for="plazaSelect" class="form-label">Select Plaza</label>
                <div class="col-md-10">
                  <select id="plazaSelect" class="form-select" v-model="monthlySummaryStore.inputField.plaza_id">
                    <option value="" disabled>Choose Plaza</option>
                    <option :value="3">Meghna</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Month Selection -->
            <div class="col-lg-6">
              <div class="mb-4">
                <label for="monthInput" class="form-label">Select Month</label>
                <div class="col-md-10">
                  <input
                    id="monthInput"
                    class="form-control"
                    type="month"
                    v-model="monthlySummaryStore.inputField.month"
                  />
                </div>
              </div>
            </div>

            <!-- Payment Type Selection -->
            <div class="col-lg-6">
              <div class="mb-4">
                <label for="paymentTypeSelect" class="form-label">Select Payment Type</label>
                <div class="col-md-10">
                  <select id="paymentTypeSelect" class="form-select" v-model="monthlySummaryStore.inputField.payment_type">
                    <option value="" disabled>Choose Payment Type</option>
                    <option :value="1">Cash</option>
                    <option :value="2">Exempt</option>
                    <option :value="3">ETC</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Report Type Selection -->
            <div class="col-lg-6">
              <div class="mb-4">
                <label for="reportTypeSelect" class="form-label">Select Report Type</label>
                <div class="col-md-10">
                  <select id="reportTypeSelect" class="form-select" v-model="monthlySummaryStore.inputField.report_type">
                    <option value="" disabled>Choose Report Type</option>
                    <option :value="1">Transaction Count</option>
                    <option :value="2">Transaction Amount</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</template>
