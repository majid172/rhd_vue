<script setup>
import { useBridgeStore } from "@/stores/bridges.js";
import { useRealtimeStore } from "@/stores/realtime.js";
import { onMounted, computed } from "vue";

const realtimeStore = useRealtimeStore();
const bridgeStore = useBridgeStore();

onMounted(() => {
  bridgeStore.fetchBridge();
});

// Check if a bridge is selected
const isBridgeSelected = computed(() => !!realtimeStore.inputField.selectedBridgeId);
const plazas = computed(() => {
  const selectedBridge = bridgeStore.bridges.find(
    (bridge) => bridge.id === realtimeStore.inputField.selectedBridgeId
  );
  return selectedBridge ? selectedBridge.plazas : [];
});
</script>
<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-6">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Realtime Data</h5>
      </div>
      <div class="card-body">
        <form>
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-4">
                <label for="defaultSelect" class="form-label">Bridge Select</label>
                <select
                  id="defaultSelect"
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

            <!-- Conditionally display the Plaza field -->
            <div class="col-lg-6" v-if="isBridgeSelected">
              <div class="mb-6">
                <label class="form-label" for="basic-default-company">Select Plaza</label>
                <select
                  id="defaultSelect"
                  class="form-select"
                  v-model="realtimeStore.inputField.plaza_id"
                >
                  <option value="">Choose Plaza</option>
                  <option v-for="(item, index) in plazas" :key="index" :value="item.plaza_id">
                    {{ item.plaza_name }}
                  </option>
                </select>
              </div>
            </div>
          </div>

          <button
            type="submit"
            class="btn btn-primary"
            @click.prevent="realtimeStore.fetchRealtime">Submit
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

