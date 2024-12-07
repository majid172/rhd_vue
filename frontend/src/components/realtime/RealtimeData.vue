<script setup>
import { onMounted, onBeforeUnmount } from 'vue';
import { useRealtimeStore } from '@/stores/realtime';

// Access the Pinia store
const realtimeStore = useRealtimeStore();


</script>

<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-12 g-6 justify-content-center">
      <h5 class="text-center font-weight-bold text-danger mb-0">Total Cash Toll Collection: {{ parseFloat(realtimeStore.total_toll || 0).toFixed(2) }} BDT

    </h5>
    <h5 class="text-center font-weight-bold text-danger mb-0">
  Total ETC Toll Collection: {{ parseFloat(realtimeStore.total_etc || 0).toFixed(2) }} BDT
</h5>

      <div class="row row-cols-1 row-cols-md-3 g-3 mb-12 justify-content-center">
        <!-- Loop through the realtime data from the store -->
        <div class="col" v-for="(item, index) in realtimeStore.realtimeDatas" :key="index">
          <div class="card h-100">
            <img class="card-img-top" src="@/assets/img/download.png" alt="Card image cap" />
            <div class="card-body">
              <table class="border" width="100%">
                <tr>
                  <th class="text-right pr-1">Lane No :</th>
                  <th class="text-danger">{{ item.lane_no }}</th>
                </tr>
                <tr>
                  <th class="text-right pr-1">Operator</th>
                  <th>{{ item.user.username }}</th>
                </tr>
                <tr>
                  <th class="text-right pr-1">TOLL RATE :</th>
                  <th>{{ item.amount }}</th>
                </tr>
                <tr>
                  <th class="text-right pr-1">REGISTRATION NO :</th>
                  <th>{{ item.registration_number }}</th>
                </tr>
                <tr>
                  <th class="text-right pr-1">VEHICLE CLASS :</th>
                  <th>{{ item.vehicle_class }}</th>
                </tr>
                <tr>
                  <th class="text-right pr-1">PAYMENT METHOD :</th>
                  <th>
                    <span v-if="item.payment_type_id == 1">Cash</span>
                    <span v-else-if="item.payment_type_id == 2">Exempt</span>
                    <span v-else-if="item.payment_type_id == 3">Online</span>
                    <span v-else>N/A</span>
                  </th>
                </tr>
                <tr>
                  <th class="text-right pr-1">RECOGNIZED BY :</th>
                  <th>
                    <span v-if="item.recognize_by == 'ANPR'">ANPR</span>
                    <span v-else-if="item.recognize_by == 'RFID'">RFID</span>
                    <span v-else>OTHER</span>
                  </th>
                </tr>
                <tr>
                  <th class="text-right pr-1">TIME :</th>
                  <th class="text-danger">{{ item.created_at }}</th>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
table,
th {
  border: 1px solid #625e5e;
  border-collapse: collapse;
  padding-left: 10px;
  padding-top: 0;
  padding-bottom: 0;
  margin: 0;
  font-size: 12px;
}
</style>
