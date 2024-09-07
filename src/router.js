import { createRouter, createWebHistory } from "vue-router";
import HomeView from '@/views/Home.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'Home',
            component: HomeView,
        },
        {
            path: '/login',
            name: 'Login',
            component: () => import('./views/Login.vue')
        },
        {
            path: '/registration',
            name: 'Registration',
            component: () => import('./views/Registration.vue')
        },
        {
            path: '/settings',
            name: 'Settings',
            component: () => import('./views/settings.vue')
        },
        {
            path: '/feed',
            name: 'Feed',
            component: () => import('./views/Feed.vue')
        },
        {
            path: '/:catchAll(.*)',
            name: 'pagenotfound',
            component: () => import('./views/NotFoundView.vue')
        },
    ],
})

export default router;