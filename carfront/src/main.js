import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import './assets/main.css'
import './index.css'
import './assets/css/main.css'
import App from './App.vue'
import Top from './include/top.vue'
import Foot from './include/foot.vue'
import Car from './home.vue'
import Login from './account/login.vue'
import Register from './account/register.vue'
import Index from './car/index.vue'
import Reservation from './car/reservation.vue'

const routes = [
    { path: '/Car', component: Car, meta: { requiresAuth: true }},
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/top', component: Top },
    { path: '/foot', component: Foot },
    { path: '/', component: Index, meta: { requiresAuth: true } },
    { path: '/reservation', component: Reservation, meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
    const token = localStorage.getItem('token')
    const user = localStorage.getItem('user')

    if (requiresAuth && (!token || !user)) {

      next('/login')


    } else {
      next()
    }
  })
createApp(App).use(router).mount('#app')
