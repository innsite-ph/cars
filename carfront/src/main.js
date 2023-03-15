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
    { path: '/', component: Home },
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

createApp(App).use(router).mount('#app')
