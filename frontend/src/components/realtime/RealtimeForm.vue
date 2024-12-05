<script setup>
import {useBridgeStore} from "@/stores/bridges.js";
import {useRealtimeStore} from "@/stores/realtime.js";
import {onMounted} from "vue";
const realtimeStore = useRealtimeStore();
const bridgeStore = useBridgeStore();
onMounted(()=>{
  bridgeStore.fetchBridge();
})
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
                              <select id="defaultSelect" class="form-select" v-model="realtimeStore.inputField.selectedBridgeId">
                                <option>Choose Bridge</option>
                                <option v-for="(bridge, index) in bridgeStore.bridges" :key="index" :value="bridge.id">
                                  {{ bridge.bridge_name }}
                                </option>

                              </select>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="mb-6">
                              <label class="form-label" for="basic-default-company">Select Plaza</label>
                              <select id="defaultSelect" class="form-select" v-model="realtimeStore.inputField.plaza_id">
                                <option>Choose Bridge</option>
                                <option value="3">
                                  Meghna
                                </option>

                              </select>
                            </div>
                          </div>
                        </div>

                        <button type="submit" class="btn btn-primary" @click.prevent="realtimeStore.realtimeReport">Submit</button>
                      </form>
                    </div>
                  </div>
  </div>
</template>
