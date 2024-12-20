import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/views/auth/LoginView.vue'
import DashboardView from '@/views/DashboardView.vue'
import RealtimeRequestView from '@/views/realtime/RealtimeRequestView.vue'
import RealtimeShowView from '@/views/realtime/RealtimeShowView.vue';
import LaneRequestView from "@/views/realtime/LaneRequestView.vue";
import LaneShowView from "@/views/realtime/LaneShowView.vue";
import DailyRequestView from "@/views/summary/DailyRequestView.vue";
import DailyReportView from "@/views/summary/DailyReportView.vue";
import LaneSummaryRequestView from '@/views/summary/LaneSummaryRequestView.vue';
import MonthlySummaryRequestView from '@/views/summary/MonthlyRequestView.vue';
import UserListView from "@/views/user/UserListView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.VUE_APP_BASE_API_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component:DashboardView
    },
    {
      path: '/realtime-request',
      name: 'realtime',
      component: RealtimeRequestView
    },
    {
      path: '/realtime-show/:selectedBridgeId/:plaza_id',
      name: 'realtimeShow',
      component: RealtimeShowView
    },
    {
      path: '/realtime/lane-request',
      name: 'laneWise',
      component: LaneRequestView

    },
    {
      path: '/realtime/lane-show/:selectedBridgeId/:plaza_id/:lane',
      name: 'laneShow',
      component: LaneShowView

    },
    {
      path: '/daily/summary',
      name: 'dailySummary',
      component: DailyRequestView
    },
    {
      path:'/daily/summary/report',
      name:'dailySummaryReport',
      component: DailyReportView
    },
    {
      path: '/lane/summary',
      name: 'laneSummary',
      component: LaneSummaryRequestView
    },
    {
      path: '/monthly/summary',
      name: 'monthlySummary',
      component: MonthlySummaryRequestView
    },
    {
      path: '/user-list',
      name: 'userlist',
      component: UserListView
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue'),
    },
  ],
})

export default router
