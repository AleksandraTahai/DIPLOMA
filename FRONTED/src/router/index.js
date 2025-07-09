import { createRouter, createWebHistory } from 'vue-router'

import HabitsView from '../views/HabitsView.vue'
import LoginPage from '../views/LoginPage.vue'

const routes = [
  {
    path: '/',
    redirect: '/habits',
  },
  {
    path: '/auth',
    name: 'auth',
    component: LoginPage,
    meta: { guestOnly: true },
  },
  {
    path: '/habits',
    name: 'habits',
    component: HabitsView,
    meta: { requiresAuth: true },
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router

