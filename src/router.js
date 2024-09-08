import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('./views/Home.vue')
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
        component: () => import('./views/Settings.vue') // Überprüfen Sie den Dateinamen und Pfad
    },
    {
        path: '/feed',
        name: 'Feed',
        component: () => import('./views/Feed.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/:catchAll(.*)',
        name: 'pagenotfound',
        component: () => import('./views/NotFoundView.vue')
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

export default router;