<script setup>
import Aside from "@/components/layouts/Aside.vue";
import Navbar from "@/components/layouts/Navbar.vue";
import Dashboard from "@/components/Dashboard.vue";
import Footer from "@/components/layouts/Footer.vue";
</script>
<template>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <Aside></Aside>
      <div class="layout-page">
        <Navbar/>
        <!-- Content wrapper -->
        <div class="content-wrapper">
          <Dashboard/>

          <Footer/>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
</template>
