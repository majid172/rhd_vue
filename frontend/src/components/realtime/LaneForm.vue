<script setup>
import { useBridgeStore } from "@/stores/bridges.js";
import { useRealtimeStore } from "@/stores/realtime.js";
import { onMounted, computed, ref } from "vue";

const realtimeStore = useRealtimeStore();
const bridgeStore = useBridgeStore();

// Variable to store selected lane
const selectedLane = ref("");

onMounted(() => {
  bridgeStore.fetchBridge();
});

// Check if a bridge is selected
const isBridgeSelected = computed(() => !!realtimeStore.inputField.selectedBridgeId);

// Check if a plaza is selected
const isPlazaSelected = computed(() => !!realtimeStore.inputField.plaza_id);

// Compute plazas for the selected bridge
const plazas = computed(() => {
  const selectedBridge = bridgeStore.bridges.find(
    (bridge) => bridge.id === realtimeStore.inputField.selectedBridgeId
  );
  return selectedBridge ? selectedBridge.plazas : [];
});

// Static lane logic (1 to 12)
const lanes = computed(() => {
  const selectedPlaza = plazas.value.find(
    (plaza) => plaza.plaza_id == realtimeStore.inputField.plaza_id
  );
  return selectedPlaza ? Array.from({ length: 12 }, (_, i) => i + 1) : []; // Lanes 1 to 12
});
</script>

<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-6">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lanewise Realtime Data</h5>
      </div>
      <div class="card-body">
        <form>
          <div class="row">
            <!-- Bridge Select -->
            <div class="col-lg-6">
              <div class="mb-4">
                <label for="bridgeSelect" class="form-label">Bridge Select</label>
                <select
                  id="bridgeSelect"
                  class="form-select"
                  v-model="realtimeStore.inputField.selectedBridgeId"
                >
                  <option value="">Choose Bridge</option>
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

            <!-- Plaza Select -->
            <div class="col-lg-6" v-if="isBridgeSelected">
              <div class="mb-4">
                <label for="plazaSelect" class="form-label">Select Plaza</label>
                <select
                  id="plazaSelect"
                  class="form-select"
                  v-model="realtimeStore.inputField.plaza_id"
                >
                  <option value="">Choose Plaza</option>
                  <option v-for="(plaza, index) in plazas" :key="index" :value="plaza.plaza_id">
                    {{ plaza.plaza_name }}
                  </option>
                </select>
              </div>
            </div>

            <!-- Lane Select -->
            <div class="col-lg-6" v-if="isPlazaSelected">
              <div class="mb-4">
                <label for="laneSelect" class="form-label">Select Lane</label>
                <select
                  id="laneSelect"
                  class="form-select"
                  v-model="realtimeStore.inputField.lane"
                >
                  <option value="">Choose Lane</option>
                  <option v-for="(lane, index) in lanes" :key="index" :value="lane">
                    {{ lane }}
                  </option>
                </select>
              </div>
            </div>
          </div>

          <button
            type="submit"
            class="btn btn-primary"
            @click.prevent="realtimeStore.lanewise">
            Submit
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

