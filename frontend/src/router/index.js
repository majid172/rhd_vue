import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/views/auth/LoginView.vue'
import DashboardView from '@/views/DashboardView.vue'
import RealtimeRequestView from '@/views/realtime/RealtimeRequestView.vue'
import RealtimeShowView from '@/views/realtime/RealtimeShowView.vue'
import DailyRequestView from "@/views/summary/DailyRequestView.vue";
import DailyReportView from "@/views/summary/DailyReportView.vue";
import UserListView from "@/views/user/UserListView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
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
      name: 'realtimedata',
      component: RealtimeRequestView
    },
    {
      path: '/realtime-show',
      name: 'realtimedataShow',
      component: RealtimeShowView
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
