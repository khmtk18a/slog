import 'primeicons/primeicons.css';

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createRouter, createWebHistory } from 'vue-router'

import AppVue from './App.vue';
import routes from './router';

const router = createRouter({
  history: createWebHistory(),
  routes
})


const app = createApp(AppVue)

app.use(createPinia())
  .use(router)
  .mount('#app')
