<script setup>
import { onMounted, computed, ref } from "vue";
import { useBridgeStore } from "@/stores/bridges.js";
import { useRouter } from "vue-router";
import { useEtcSummaryStore } from "@/stores/etcSummary.js";

// Fetch stores and router
const bridgeStore = useBridgeStore();
const etcSummaryStore = useEtcSummaryStore();
const router = useRouter();

// Initialize Flatpickr for both startTime and endTime
onMounted(() => {
  flatpickr(".date", {
    dateFormat: "Y-m-d",
    maxDate: "today",
  });

  flatpickr("#startTime", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i:ss",
  });

  flatpickr("#endTime", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i:ss",
  });
});

// Fetch bridge data on component mount
onMounted(async () => {
  try {
    await bridgeStore.fetchBridge();
  } catch (error) {
    console.error("Error fetching bridges:", error);
  }
});

// Computed properties
const isBridgeSelected = computed(() => !!etcSummaryStore.inputField.selectedBridgeId);
const plazas = computed(() => {
  const selectedBridge = bridgeStore.bridges.find(
    (bridge) => bridge.id === etcSummaryStore.inputField.selectedBridgeId
  );
  return selectedBridge ? selectedBridge.plazas : [];
});

// Form submission handler
const validateAndSubmit = async () => {
  const validation = etcSummaryStore.validateInputs();
  if (validation !== true) {
    alert(validation);
    return;
  }

  await etcSummaryStore.showReport();
};
</script>


<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-6">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">ETC Summary Report Form</h5>
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
                  v-model="etcSummaryStore.inputField.selectedBridgeId"
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
                  v-model="etcSummaryStore.inputField.plaza_id"
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
                <label for="date" class="form-label">Select Date</label>
                <input
                  id="date"
                  class="form-control date"
                  type="text" v-model="etcSummaryStore.inputField.inputDate"
                />
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-4">
                <label for="shift" class="form-label">Select Shift</label>
                <select
                  id="shift"
                  v-model="etcSummaryStore.inputField.shift"
                  class="form-control"
                  @change="etcSummaryStore.shift"
                >
                  <option value="all_shift">All Shift</option>
                  <option value="first_shift">First Shift</option>
                  <option value="second_shift">Second Shift</option>
                  <option value="third_shift">Third Shift</option>
                  <option value="custom">Custom</option>
                </select>

              </div>
            </div>


          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-4">
                <label for="startTime" class="form-label">Start Time</label>
                <input
                  id="startTime"
                  class="form-control startTime"
                  type="text" v-model="etcSummaryStore.inputField.inputStartTime"

                />
              </div>
            </div>

            <div class="col-lg-6">
              <div class="mb-4">
                <label for="endTime" class="form-label">End Time</label>
                <input
                  id="endTime"
                  class="form-control endTime"
                  type="text" v-model="etcSummaryStore.inputField.inputEndTime"
                />
              </div>
            </div>
          </div>
          <!-- Submit Button -->
          <div class="row">
            <div class="col-lg-12 ">
              <button type="submit" class="btn btn-primary" :disabled="etcSummaryStore.isLoading">
                Submit
              </button>
            </div>
          </div>

          <!-- Feedback -->
          <div v-if="etcSummaryStore.isLoading" class="text-center mt-3">Loading...</div>
          <div v-if="etcSummaryStore.error" class="alert alert-danger mt-3">
            {{ etcSummaryStore.error }}
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
