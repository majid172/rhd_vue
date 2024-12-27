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
import MonthlyReportView from '@/views/summary/MonthlyReportView.vue';
import MonthlyView from "@/views/etc/monthly/MonthlyView.vue";
import EtcBankwiseView from "@/views/etc/bankwise/ReportView.vue";
import EtcBankwiseShowView from "@/views/etc/bankwise/SummaryView.vue";
import EtcMonthlyReportView from "@/views/etc/monthly/MonthlyReportView.vue";
import EtcSummaryReportView from "@/views/etc/summary/ReportView.vue";
import EtcSummaryView from "@/views/etc/summary/SummaryView.vue";
import EtcYearlyRequestView from "@/views/etc/yearly/YearlyRequestView.vue";
import EtcYearlyReportView from "@/views/etc/yearly/YearlyReportView.vue";
import YearlyRequestView from '@/views/summary/YearlyRequestView.vue';
import UserListView from "@/views/user/UserListView.vue";
import YearlyReportView from "@/views/summary/YearlyReportView.vue";

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
      path: '/monthly/summary/report',
      name: 'monthlySummaryReport',
      component: MonthlyReportView
    },
    {
      path: '/etc/summary',
      name: 'etcSummary',
      component: EtcSummaryReportView
    },
    {
      path:'/etc/summary/show',
      name: "etcSummaryShow",
      component: EtcSummaryView
    },
    {
      path: "/etc/bankwise",
      name: "etcBankwise",
      component: EtcBankwiseView
    },

    {
      path: '/etc/bankwise/show',
      name: "etcBankwiseShow",
      component: EtcBankwiseShowView
    },
    {
      path: '/etc/monthly/summary',
      name: 'etcMonthlySummary',
      component: MonthlyView
    },
    {
      path: '/etc/monthly/show',
      name: 'etcMonthlyReport',
      component: EtcMonthlyReportView
    },
    {
      path: '/etc/yearly/report',
      name: "etcYearlyReport",
      component: EtcYearlyRequestView
    },
    {
      path: '/etc/yearly/report/show',
      name: "etcYearlyReportShow",
      component: EtcYearlyReportView
    },

    {
      path: '/user-list',
      name: 'userlist',
      component: UserListView
    },
    {
      path: '/yearly/summary/report',
      name:'yearly',
      component: YearlyRequestView
    },
    {
      path: '/yearly/summary/report/show',
      name: "yearlyShow",
      component: YearlyReportView,
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
