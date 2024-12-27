<script setup>
import { RouterLink } from 'vue-router'
</script>
<template>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
          <router-link to="/dashboard" class="app-brand-link">
<!--              <span class="app-brand-logo demo">-->
<!--                <img  src="@/assets/img/logo.png" width="40" height="40" alt="Card image cap" />-->
<!--              </span>-->
              <span class="app-brand-text demo menu-text fw-bold ms-2">TCMS</span>
            </router-link>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">

          <li class="menu-item">

              <router-link to="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Email">Dashboard</div>

              </router-link>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Realtime &amp; Data</span>
            </li>
            <li class="menu-item">
              <a
                href="javascript:void(0);"
                class="menu-link"
                data-bs-toggle="collapse"
                data-bs-target="#realtimeCollapse"
                aria-expanded="false"
                aria-controls="realtimeCollapse">
                <i class="menu-icon tf-icons bx bx-camera"></i>
                <div class="text-truncate" data-i18n="realtime">Realtime</div>
              </a>
              <ul class="collapse" id="realtimeCollapse">
                <li class="menu-item">
                  <router-link to="/realtime-request" class="menu-link">
                    <div class="text-truncate" data-i18n="realtime">Realtime Data</div>
                  </router-link>
                </li>
                <li class="menu-item">
                  <router-link to="/realtime/lane-request" class="menu-link">
                    <div class="text-truncate" data-i18n="lanewise">Lanewise Realtime </div>
                  </router-link>
                </li>

              </ul>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Summary &amp; Reports</span>
            </li>
            <li class="menu-item">
              <a
                href="javascript:void(0);"
                class="menu-link"
                data-bs-toggle="collapse"
                data-bs-target="#summaryCollapse"
                aria-expanded="false"
                aria-controls="summaryCollapse">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div class="text-truncate" data-i18n="summary">Summary Report</div>
              </a>
              <ul class="collapse" id="summaryCollapse">
                <li class="menu-item">
                  <router-link to="/daily/summary" class="menu-link">
                    <div class="text-truncate" data-i18n="daily">Daily Report</div>
                  </router-link>

                </li>
                <li class="menu-item">
                  <router-link to="/lane/summary" class="menu-link">
                    <div class="text-truncate" data-i18n="lane">Lane Summary</div>

                  </router-link>
                </li>
                <li class="menu-item">
                  <router-link to="/monthly/summary"  class="menu-link">
                    <div class="text-truncate" data-i18n="Academy">Monthly Report</div>

                  </router-link>
                </li>
              </ul>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Details Report</span>
            </li>
            <li class="menu-item">
              <a
                href="javascript:void(0);"
                class="menu-link"
                data-bs-toggle="collapse"
                data-bs-target="#detailsCollapse"
                aria-expanded="false"
                aria-controls="detailsCollapse">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>

                <div class="text-truncate" data-i18n="details">Details Report</div>
              </a>
              <ul class="collapse" id="detailsCollapse">
                <li class="menu-item">
                  <router-link to="/daily/summary" class="menu-link">
                    <div class="text-truncate" data-i18n="daily">Transaction Report</div>
                  </router-link>

                </li>
                <li class="menu-item">
                  <router-link to="/lane/summary" class="menu-link">
                    <div class="text-truncate" data-i18n="lane">NON - BRTA Transaction</div>
                  </router-link>
                </li>

              </ul>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Yearly Report</span>
            </li>

              <li class="menu-item">
                <router-link to="/yearly/summary/report" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-calendar"></i>
                  <div class="text-truncate" data-i18n="Email">Yearly Summary Report</div>

                </router-link>
              </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Electronic Toll Collection</span>
            </li>

            <li class="menu-item">
              <a
                href="javascript:void(0);"
                class="menu-link"
                data-bs-toggle="collapse"
                data-bs-target="#etcCollapse"
                aria-expanded="false"
                aria-controls="etcCollapse">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div class="text-truncate" data-i18n="etc">ETC Report</div>
              </a>
              <ul class="collapse" id="etcCollapse">
                <li class="menu-item">
                  <router-link to="/etc/summary" class="menu-link">
                    <div class="text-truncate" data-i18n="daily">ETC Summary Report</div>
                  </router-link>
                </li>
                <li class="menu-item">
                  <router-link to="/etc/bankwise" class="menu-link">
                    <div class="text-truncate" data-i18n="lane">Bankwise Report</div>

                  </router-link>
                </li>
                <li class="menu-item">
                  <router-link to="/etc/monthly/summary"  class="menu-link">
                    <div class="text-truncate" data-i18n="Academy">Monthly Report</div>
                  </router-link>
                </li>
                <li class="menu-item">
                  <router-link to="/etc/yearly/report"  class="menu-link">
                    <div class="text-truncate" data-i18n="Academy">Yearly Report</div>
                  </router-link>
                </li>
                <li class="menu-item">
                  <router-link to="/monthly/summary"  class="menu-link">
                    <div class="text-truncate" data-i18n="Academy">Details Report</div>
                  </router-link>
                </li>
              </ul>
            </li>


            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">User Management</span>
            </li>

            <li class="menu-item">

              <router-link to="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div class="text-truncate" data-i18n="Email">Create User</div>
              </router-link>
              <li class="menu-item">
                <router-link to="/user-list" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-user"></i>
                  <div class="text-truncate" data-i18n="Email">User List</div>

                </router-link>
              </li>
            </li>

            <!-- Layouts -->
          <li class="menu-item">

              <router-link to="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-power-off"></i>
                <div class="text-truncate" data-i18n="Email">Logout</div>

              </router-link>
            </li>
          </ul>
        </aside>
</template>
