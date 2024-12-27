<script setup>
import { computed } from "vue";
import { useEtcSummaryStore } from "@/stores/etcSummary.js";

const etcSummaryStore = useEtcSummaryStore();
</script>

<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
      <div class="d-flex justify-content-between">
        <div>
          <h6 class="card-header">
            ETC SUMMARY REPORT
          </h6>
        </div>
        <div class="mt-3 mx-5">
          <router-link to="/etc/summary" class="btn rounded-pill btn-outline-primary">Back</router-link>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <thead>
            <!-- Bridge and Plaza Name -->
            <tr>
              <td colspan="13" class="text-center">
                {{ etcSummaryStore.reports?.bridgeName || 'N/A' }} ||
                {{ etcSummaryStore.reports?.plazaName || 'N/A' }}
              </td>
            </tr>

            <!-- Table Headers -->
            <tr>
              <th class="text-center">SL</th>
              <th class="text-center">Vehicle Class</th>

              <!-- Dynamically create headers for each lane -->
              <th v-for="lane in etcSummaryStore.reports.lanes" :key="lane.lane_no" class="text-center">
                Lane {{ lane.lane_no }}
              </th>

              <th class="text-center">TOTAL Amount</th>
            </tr>
            </thead>

            <tbody>
            <!-- Check if the data is empty -->
            <tr v-if="!etcSummaryStore.reports?.transactions || etcSummaryStore.reports.transactions.length === 0">
              <td class="text-center" colspan="12">No data available</td>
            </tr>

            <!-- Populate the table with data -->
            <tr v-for="(report, vehicle, index) in etcSummaryStore.reports?.transactions || []" :key="index">
              <td class="text-center">{{ index + 1 }}</td>
              <td class="text-center">{{ vehicle }}</td>

              <!-- Vehicle count per lane, avoid extra empty columns -->
              <td v-for="(lane, laneIndex) in etcSummaryStore.reports.lanes" :key="laneIndex" class="text-center">
                <!-- Check if the report has this lane data, else show 0 -->
                {{ report.lanes?.find(l => l.lane_no === lane.lane_no)?.count || 0 }}
              </td>

              <!-- TOTAL Amount -->
              <td class="text-end">
                {{ Number(report.total_amount || 0).toFixed(2) }}
              </td>
            </tr>
            <tr>
              <td colspan="2" class="text-end">
                Total
              </td>
              <td colspan="10"> - </td>
              <td class="text-end">--</td> <!-- Display the computed sum -->
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
