import { createRouter, createWebHistory } from 'vue-router'


import HabitsView from '../views/HabitsView.vue'
import LoginPage from '../views/LoginPage.vue' 

const routes = [
  {
    path: '/',
    name: 'habits',
    component: HabitsView,
  },
    {
    path: '/login',
    name: 'login',
    component: LoginPage,
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router

