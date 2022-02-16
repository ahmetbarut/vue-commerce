import { createRouter, createWebHashHistory } from 'vue-router'
import authentication from '../middleware/authentication'
import Home from '../views/Home.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/Product.vue')
  },
  {
    name: 'search',
    component: Home
  },
  {
    path: '/product/:productId',
    name: 'Product',
    component: () => import('../views/Product.vue')
  },
  {
    path: "/login",
    name: "login",
    component: () => import('../views/Login.vue')
  },
  {
    path: "/cart-total",
    name: "cart-total",
    component: () => import('../views/CartTotal.vue'),
    meta: {
      middleware: [authentication],
    }
  },
  {
    path: "/my-profile",
    name: "my-account",
    component: () => import('../views/MyAccount.vue'),
    meta: {
      middleware: [authentication],
    }
  },
  {
    path: "/my-orders",
    name: "my-orders",
    component: () => import('../views/MyOrders.vue'),
    meta: {
      middleware: [authentication],
    }
  },
]

const router = createRouter({
  history: createWebHashHistory(process.env.BASE_URL),
  routes
})

export default router
