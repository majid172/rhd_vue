import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import Vue3Apexcharts from 'vue3-apexcharts'
import axios from "axios";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";
import CanvasJSChart from '@canvasjs/vue-charts';

import App from './App.vue'
import router from './router'

const app = createApp(App)
axios.defaults.baseURL = "http://127.0.0.1:8000/api";
app.use(createPinia());
app.use(CanvasJSChart);
app.use(router)
app.use(Vue3Apexcharts) // Vue3Apexcharts already registers the component
app.mount('#app')
