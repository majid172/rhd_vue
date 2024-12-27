<script setup>
import { ref, onMounted } from "vue";
import { useYearlySummaryStore } from "@/stores/yearlySummary.js";

const yearlySummaryStore = useYearlySummaryStore();
const year = yearlySummaryStore.inputField.year;
// Sample data initialization (optional for testing purposes)

</script>

<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
      <!-- Header Section -->
      <div class="d-flex justify-content-between">
        <div>
          <h5 class="card-header">Yearly Summary Report - {{year}}</h5>
        </div>
        <div class="mt-3 mx-5">
          <router-link to="/yearly/summary/report" class="btn rounded-pill btn-outline-primary">Back</router-link>
        </div>
      </div>

      <!-- Table Section -->
      <div class="card-body">
        <!-- Transaction Count Table -->
        <div class="table-responsive text-nowrap mb-5">
          <table class="table table-bordered">
            <thead>
            <tr>
              <th colspan="13" class="text-left">Transaction Count</th>
            </tr>
            <tr>
              <th class="text-center">Payment Type</th>
              <th class="text-center">Jan</th>
              <th class="text-center">Feb</th>
              <th class="text-center">Mar</th>
              <th class="text-center">Apr</th>
              <th class="text-center">May</th>
              <th class="text-center">June</th>
              <th class="text-center">July</th>
              <th class="text-center">Aug</th>
              <th class="text-center">Sep</th>
              <th class="text-center">Oct</th>
              <th class="text-center">Nov</th>
              <th class="text-center">Dec</th>
            </tr>
            </thead>
            <tbody>
            <!-- Show "No Data Available" if yearlyReports is empty -->
            <tr v-if="yearlySummaryStore.yearlyReports.length === 0">
              <td class="text-center" colspan="13">No data available</td>
            </tr>
            <!-- Loop through yearlyReports to display transaction counts -->
            <tr v-for="(report,index) in yearlySummaryStore.yearlyReports" :key="report.paymentType">
              <td class="text-center" >
                <span v-if="index == 1">Cash</span>
                <span v-else-if="index == 2">Exempt</span>
                <span v-else-if="index == 3">Etc</span>
                <span v-else>Unknown</span>
              </td>
              <td v-for="(item, monthIndex) in report" :key="monthIndex">
                <span>{{ item.transaction_count }} </span>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <!-- Transaction Amount Table -->
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <thead>
            <tr>
              <th colspan="13" class="text-left">Transaction Amount</th>
            </tr>
            <tr>
              <th class="text-center">Payment Type</th>
              <th class="text-center">Jan</th>
              <th class="text-center">Feb</th>
              <th class="text-center">Mar</th>
              <th class="text-center">Apr</th>
              <th class="text-center">May</th>
              <th class="text-center">June</th>
              <th class="text-center">July</th>
              <th class="text-center">Aug</th>
              <th class="text-center">Sep</th>
              <th class="text-center">Oct</th>
              <th class="text-center">Nov</th>
              <th class="text-center">Dec</th>
            </tr>
            </thead>
            <tbody>
            <!-- Show "No Data Available" if yearlyReports is empty -->
            <tr v-if="yearlySummaryStore.yearlyReports.length === 0">
              <td class="text-center" colspan="13">No data available</td>
            </tr>
            <!-- Loop through yearlyReports to display transaction amounts -->
            <tr v-for="(report,index) in yearlySummaryStore.yearlyReports" :key="index">
              <td class="text-center" >

                <span v-if="index == 1">Cash</span>
                <span v-else-if="index == 2">Exempt</span>
                <span v-else-if="index == 3">Etc</span>
                <span v-else>Unknown</span>
              </td>
              <td v-for="item in report" :key="item.month" class="text-center">
                <span>{{ parseFloat(item.total_amount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}</span>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
