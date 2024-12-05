<script setup>
import { useDailySummaryStore } from "@/stores/dailySummary.js";

const dailySummaryStore = useDailySummaryStore();
const dailyReport = dailySummaryStore.cashDetails; // Access dailyReport from the store
const etcDetails = dailySummaryStore.etcDetails; // Access dailyReport from the store
const exemptDetails = dailySummaryStore.exemptDetails; // Access dailyReport from the store
</script>

<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4" >
      <h5 class="card-header">Cash Summary Report</h5>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center">SL</th>
                <th class="text-center">VEHICLE CLASS NAME</th>
                <th class="text-center">PER VEHICLE RATE</th>
                <th class="text-center">NUMBER OF TRANSACTION</th>
                <th class="text-center">AMOUNT</th>
              </tr>
            </thead>
            <tbody>
              <!-- Check if data exists -->
              <tr v-if="dailyReport.length === 0">
                <td colspan="5" class="text-center">No data available</td>
              </tr>
              <!-- Loop through dailyReport to generate rows dynamically -->
              <tr v-for="(report, index) in dailyReport" :key="index">
                <td class="text-center">{{ index + 1 }}</td>
                <td class="text-center">{{ report.vehicle_class }}</td>
                <td class="text-center">{{ parseFloat(report.vehicle_rate).toFixed(2) }}</td>
                <td class="text-center">{{ report.transaction_count }}</td>
                <td class="text-center">{{ parseFloat(report.total_amount).toFixed(2) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="card mb-4" >
      <h5 class="card-header">ETC Summary Report</h5>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center">SL</th>
                <th class="text-center">VEHICLE CLASS NAME</th>
                <th class="text-center">PER VEHICLE RATE</th>
                <th class="text-center">NUMBER OF TRANSACTION</th>
                <th class="text-center">AMOUNT</th>
              </tr>
            </thead>
            <tbody>
              <!-- Check if data exists -->
              <tr v-if="dailyReport.length === 0">
                <td colspan="5" class="text-center">No data available</td>
              </tr>
              <!-- Loop through dailyReport to generate rows dynamically -->
              <tr v-for="(report, index) in etcDetails" :key="index">
                <td class="text-center">{{ index + 1 }}</td>
                <td class="text-center">{{ report.vehicle_class }}</td>
                <td class="text-center">{{ parseFloat(report.vehicle_rate).toFixed(2) }}</td>
                <td class="text-center">{{ report.transaction_count }}</td>
                <td class="text-center">{{ parseFloat(report.total_amount).toFixed(2) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="card mb-4" >
      <h5 class="card-header">Exempt Summary Report</h5>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center">SL</th>
                <th class="text-center">VEHICLE CLASS NAME</th>
                <th class="text-center">PER VEHICLE RATE</th>
                <th class="text-center">NUMBER OF TRANSACTION</th>
                <th class="text-center">AMOUNT</th>
              </tr>
            </thead>
            <tbody>
              <!-- Check if data exists -->
              <tr v-if="dailyReport.length === 0">
                <td colspan="5" class="text-center">No data available</td>
              </tr>
              <!-- Loop through dailyReport to generate rows dynamically -->
              <tr v-for="(report, index) in exemptDetails" :key="index">
                <td class="text-center">{{ index + 1 }}</td>
                <td class="text-center">{{ report.vehicle_class }}</td>
                <td class="text-center">{{parseFloat( report.vehicle_rate).toFixed(2) }}</td>
                <td class="text-center">{{ report.transaction_count }}</td>
                <td class="text-center">{{ parseFloat(report.total_amount).toFixed(2) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
