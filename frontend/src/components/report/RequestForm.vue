<script setup>
import {onMounted} from "vue";
import {useBridgeStore} from "@/stores/bridges.js";
import {useDailySummaryStore} from "@/stores/dailySummary.js";

const bridgeStore = useBridgeStore();
const dailySummaryStore = useDailySummaryStore();
onMounted(()=>{
  bridgeStore.fetchBridge();
})
</script>
<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-6">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Report Form</h5>
      </div>
      <div class="card-body">
        <form>
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-4 ">
                <label for="defaultSelect" class="form-label">Select Bridge</label>
                <div class="col-md-10">
                  <select id="defaultSelect" class="form-select" v-model="dailySummaryStore.inputField.selectedBridgeId">
                    <option>Choose Bridge</option>
                    <option v-for="(bridge, index) in bridgeStore.bridges" :key="index" :value="bridge.id">
                      {{ bridge.bridge_name }}
                    </option>
                  </select>
                </div>
              </div>

            </div>
            <div class="col-lg-6">
              <div class="mb-4 ">
                <label for="defaultSelect" class="form-label">Select Plaza</label>
                <div class="col-md-10">
                  <select id="defaultSelect" class="form-select" v-model="dailySummaryStore.inputField.plaza_id">
                    <option>Choose Plaza</option>
                    <option  :value="3">
                      Meghna
                    </option>
                  </select>
                </div>
              </div>

            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-4 ">
                <label for="defaultSelect" class="form-label">Select Date</label>
                <div class="col-md-10">
                  <input class="form-control" type="date" value="2021-06-18" id="html5-date-input"
                         v-model="dailySummaryStore.inputField.inputDate">
                </div>
              </div>

            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-4">
                <label for="html5-time-input" class="col-md-2 col-form-label">Star Time</label>
                <div class="col-md-10">
                  <input class="form-control" type="time" value="12:30:00" id="html5-time-input"
                         v-model="dailySummaryStore.inputField.inputStartTime">
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-4">
                <label for="html5-time-input" class="col-md-2 col-form-label">End Time</label>
                <div class="col-md-10">
                  <input class="form-control" type="time" value="12:30:00" id="html5-time-input"
                         v-model="dailySummaryStore.inputField.inputEndTime">
                </div>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary" @click.prevent="dailySummaryStore.showDailyReport">Submit</button>
        </form>
      </div>
    </div>
  </div>
</template>
