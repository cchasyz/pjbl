import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import MenuView from '@/views/MenuView.vue'
import OrderView from '@/views/OrderView.vue'
import OrdersView from '@/views/OrdersView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/menu',
      name: 'menu',
      component: MenuView,
    },
    {
      path: '/order',
      name: 'order',
      component: OrderView,
    },
    {
      path: '/orders',
      name: 'orders',
      component: OrdersView,
    },
  ],
})

export default router
