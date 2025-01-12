<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- First Row -->
    <div class="row mb-6 g-6">
      <!-- Pie Chart -->
      <div class="col-md-6 col-lg-6">
        <div class="card">
          <div class="card-body">
            <CanvasJSChart :options="pieOptions"/>
          </div>
        </div>
      </div>

      <!-- Bar Chart -->
      <div class="col-md-6 col-lg-6">
        <div class="card text-center">
          <div class="card-body">
            <CanvasJSChart :options="barOptions"/>
          </div>
        </div>
      </div>
    </div>

    <!-- Second Row -->
    <div class="row mb-6 g-6">
      <!-- Line Chart -->
      <div class="col-md-6 col-lg-6">
        <div class="card">
          <div class="card-body">
            <CanvasJSChart :options="lineOptions"/>
          </div>
        </div>
      </div>

      <!-- Area Chart -->
      <div class="col-md-6 col-lg-6">
        <div class="card text-center">
          <div class="card-body">
            <CanvasJSChart :options="areaOptions"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import {useGraphStore} from "@/stores/graphSummary.js";

const graphStore = useGraphStore();
onMounted(()=>{
  graphStore.fetchGraph();
})

// Pie Chart options
const pieOptions = ref({
  animationEnabled: true,
  theme: "light2",
  title: {
    text: "Toll Collection ( Today )"
  },
  data: [{
    type: "pie",
    dataPoints: graphStore.piecharts
  }]
})

// Bar Chart options
const barOptions = ref({
  animationEnabled: true,
  theme: "light2",
  title: {
    text: "Today Vehicle Classwise Toll "
  },
  axisX: {
    interval: 1
  },
  data: [{
    type: "column",
    dataPoints: graphStore.barcharts
  }]
})

// Line Chart options
const lineOptions = ref({
  animationEnabled: true,
  theme:"light2",
  title: {
    text: "Current Month Toll Collection",
  },
  axisX:{
    interval: 1
  },
  data: [{
    type: "spline",
    dataPoints: graphStore.linecharts
  }]
})

// Area Chart options
const areaOptions = ref({
  animationEnabled: true,
  theme: "light2",
  title: {
    text: "Today Hourly Toll Collection"
  },
  axisX:{
    interval: 1
  },
  data: [{
    type: "area",
    dataPoints: graphStore.areacharts
  }]
})
</script>
