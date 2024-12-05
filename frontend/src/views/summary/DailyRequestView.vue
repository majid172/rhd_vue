<template>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <Aside></Aside>
      <div class="layout-page">
        <Navbar></Navbar>

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <RequestForm/>
          <!-- Content -->
          <Footer></Footer>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
</template>
<script setup>
import Aside from "@/components/layouts/Aside.vue";
import Footer from "@/components/layouts/Footer.vue";
import RequestForm from "@/components/report/RequestForm.vue";
import Navbar from "@/components/layouts/Navbar.vue";
</script>
