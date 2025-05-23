import { createRouter, createWebHashHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('./views/Home.vue')
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('./views/Login.vue'),
        meta: { isAuth: true }
    },
    {
        path: '/registration',
        name: 'Registration',
        component: () => import('./views/Registration.vue'),
        meta: { isAuth: true }
    },
    {
        path: '/settings',
        name: 'Settings',
        component: () => import('./views/Settings.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/feed',
        name: 'Feed',
        component: () => import('./views/Feed.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/features',
        name: 'Features',
        component: () => import('./views/navViews/features.vue')
    },
    {
        path: '/project',
        name: 'Project',
        component: () => import('./views/navViews/project.vue')
    },
    {
        path: '/contact',
        name: 'Contact',
        component: () => import('./views/navViews/contact.vue')
    },
    {
        path: '/privacy-policy',
        name: 'Privacy Policy',
        component: () => import('./views/footerViews/privacy-policy.vue')
    },
    {
        path: '/imprint',
        name: 'Imprint',
        component: () => import('./views/footerViews/imprint.vue')
    },
    {
        path: '/:catchAll(.*)',
        name: 'pagenotfound',
        component: () => import('./views/NotFoundView.vue')
    }
];


const router = createRouter({
    history: createWebHashHistory(import.meta.env.BASE_URL),
    routes
});


router.beforeEach(async (to, from, next) => {
    // Damit der User nicht auf Seiten kommt, die Authentifizierung benötigen
    if(to.matched.some(record => record.meta.requiresAuth)) {
        // authetifications check
        const token = localStorage.getItem('token');
        if(token) {
            next();
        } else {
            next('/login');
        }
        return;
    }

    // Damit sich der User nicht nochmal einloggen kann, wenn er bereits eingeloggt ist
    if(to.matched.some(record => record.meta.isAuth)) {
        // authetifications check
        const token = localStorage.getItem('token');
        if(token) {
            next('/feed');
        } else {
            next();
        }
        return;
    }
    next();
});


export default router;