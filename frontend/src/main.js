import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import Vue3Apexcharts from 'vue3-apexcharts'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(Vue3Apexcharts) // Vue3Apexcharts already registers the component
app.mount('#app')
