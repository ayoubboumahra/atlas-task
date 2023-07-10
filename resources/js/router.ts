import { createWebHistory, createRouter } from "vue-router";
import store from "./store";
import Login from "./views/login.vue";
import Projects from "./views/projects.vue";
import Project from "./views/project.vue";

const routes = [
    {
        path: "/projects",
        name: 'projects',
        component: Projects,
        meta: { requiresAuth: true },
    },
    {
        path: "/projects/:id",
        name: 'project',
        component: Project,
        meta: { requiresAuth: true },
    },
    {
        path: "/",
        name: 'home',
        component: Projects,
        meta: { requiresAuth: true },
    },
    {
        path: "/login",
        name: 'login',
        component: Login,
        meta: { requiresAuth: false },
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const requiresAuth = to.matched.some((record) => record.meta.requiresAuth);
    const isAuthenticated = store.getters['auth/getAuthenticated'];
    const token = store.getters['auth/getToken'];

    if (to.meta.requiresAuth) {
        if (!token || !isAuthenticated) {
            next({ path: '/login' });
        } else {
            next();
        }
    } else if (to.path === '/login') {
        if (isAuthenticated) {
            next({ path: '/', replace: true });
        } else {
            if (token) {
                try {
                    await store.dispatch('auth/me');
                    if (store.getters['auth/getAuthenticated']) {
                        next({ path: '/', replace: true });
                    } else {
                        next();
                    }
                } catch (error) {
                    console.error('An error occurred while checking authentication:', error);
                    next();
                }
            } else {
                next();
            }
        }
    } else {
        next();
    }
});


export default router;