<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6 g-6">
      <div class="col-md-6 col-lg-6">
        <div class="card">
          <div class="card-body">
            <CanvasJSChart :options="options"/>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-6">
        <div class="card text-center">
          <div class="card-body">
            <CanvasJSChart :options="options"/>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-6 g-6">
      <div class="col-md-6 col-lg-6">
        <div class="card">
          <div class="card-body">
            <CanvasJSChart :options="options"/>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-6">
        <div class="card text-center">
          <div class="card-body">
            <CanvasJSChart :options="options"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<!-- App.vue -->
<script>
export default {
  data() {
    return {
      chart: null,
      options: {
        animationEnabled: true,
        title:{
          text: "pie"
        },
        data: [{
          type: "pie",
          dataPoints: [
            { label: "apple",  y: 10 },
            { label: "orange", y: 15 },
            { label: "banana", y: 25 },
            { label: "mango",  y: 30 },
            { label: "grape",  y: 28 }
          ]
        }]
      }
    }

  }
}
</script>
