import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import './assets/main.css';
import './index.css';
import App from './App.vue';
import Top from './include/top.vue';
import Foot from './include/foot.vue';
import Home from './home.vue';

const routes = [
    { path: '/', component: Home },
    { path: '/top', component: Top },
    { path: '/foot', component: Foot },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

createApp(App).use(router).mount('#app')
