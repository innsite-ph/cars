import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import './assets/main.css'
import './index.css'
import './assets/css/main.css'
import App from './App.vue'
import Top from './include/top.vue'
import Foot from './include/foot.vue'
import Home from './home.vue'
import Login from './account/login.vue'
import Register from './account/register.vue'
import Add from './car/add.vue'

const routes = [
    { path: '/', component: Home, meta: { requiresAuth: true }},
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/top', component: Top },
    { path: '/foot', component: Foot },
    { path: '/add', component: Add },
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
