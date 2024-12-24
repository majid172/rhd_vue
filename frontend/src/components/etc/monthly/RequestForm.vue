<script setup>
import { onMounted, computed } from "vue";
import { useBridgeStore } from "@/stores/bridges.js";
import { useMonthlySummaryStore } from "@/stores/monthlySummary";
import { useRouter } from "vue-router";
import {useEtcMonthlySummaryStore} from "@/stores/etcMonthlySummary.js";

// Fetch stores and router
const bridgeStore = useBridgeStore();
const monthlySummaryStore = useEtcMonthlySummaryStore();
const router = useRouter();

// Fetch bridge data on component mount
onMounted(async () => {
  try {
    await bridgeStore.fetchBridge();
  } catch (error) {
    console.error("Error fetching bridges:", error);
  }
});

// Computed properties
const isBridgeSelected = computed(() => !!monthlySummaryStore.inputField.selectedBridgeId);
const plazas = computed(() => {
  const selectedBridge = bridgeStore.bridges.find(
    (bridge) => bridge.id === monthlySummaryStore.inputField.selectedBridgeId
  );
  return selectedBridge ? selectedBridge.plazas : [];
});

// Form submission handler
const validateAndSubmit = async () => {
  const validation = monthlySummaryStore.validateInputs();
  if (validation !== true) {
    alert(validation);
    return;
  }

  // Call showMonthlyReport to fetch the data
  await monthlySummaryStore.showMonthlyReport();
};
</script>

<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-6">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">ETC Monthly Report Form</h5>
      </div>

      <div class="card-body">
        <form @submit.prevent="validateAndSubmit">
          <!-- Bridge Selection -->
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-4">
                <label for="bridgeSelect" class="form-label">Bridge Select</label>
                <select
                  id="bridgeSelect"
                  class="form-select"
                  v-model="monthlySummaryStore.inputField.selectedBridgeId"
                >
                  <option value="" disabled>Choose Bridge</option>
                  <option
                    v-for="bridge in bridgeStore.bridges"
                    :key="bridge.id"
                    :value="bridge.id"
                  >
                    {{ bridge.bridge_name }}
                  </option>
                </select>
              </div>
            </div>

            <!-- Plaza Selection -->
            <div class="col-lg-6" v-if="isBridgeSelected">
              <div class="mb-4">
                <label for="plazaSelect" class="form-label">Select Plaza</label>
                <select
                  id="plazaSelect"
                  class="form-select"
                  v-model="monthlySummaryStore.inputField.selectedPlazaId"
                >
                  <option value="" disabled>Choose Plaza</option>
                  <option
                    v-for="plaza in plazas"
                    :key="plaza.plaza_id"
                    :value="plaza.plaza_id"
                  >
                    {{ plaza.plaza_name }}
                  </option>
                </select>
              </div>
            </div>
          </div>

          <!-- Month and Payment Type -->
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-4">
                <label for="monthInput" class="form-label">Select Month</label>
                <input
                  id="monthInput"
                  class="form-control"
                  type="month"
                  v-model="monthlySummaryStore.inputField.month"
                />
              </div>
            </div>


          </div>

          <!-- Submit Button -->
          <div class="row">
            <div class="col-lg-12 ">
              <button type="submit" class="btn btn-primary" :disabled="monthlySummaryStore.isLoading">
                Submit
              </button>
            </div>
          </div>

          <!-- Feedback -->
          <div v-if="monthlySummaryStore.isLoading" class="text-center mt-3">Loading...</div>
          <div v-if="monthlySummaryStore.error" class="alert alert-danger mt-3">
            {{ monthlySummaryStore.error }}
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
