import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/views/Home.vue'
import About from '@/views/About.vue'
import Register from '@/views/Register.vue'
import Login from '@/views/Login.vue'
import NotFound from '@/views/NotFound.vue'

const routes = [
    {
        name: 'Home',
        path: '/',
        component: Home,
        meta: {
            title: 'Accueil',
        },
    },
    {
        name: 'Register',
        path: '/register',
        component: Register,
        meta: {
            title: 'Inscription',
        },
    },
    {
        name: 'Login',
        path: '/login',
        component: Login,
        meta: {
            title: 'Connexion',
        },
    },
    {
        name: 'About',
        path: '/about',
        component: About,
        meta: {
            title: 'À propos',
        },
    },
    {
        name: 'NotFound',
        path: '/:pathMatch(.*)',
        component: NotFound,
        meta: {
            title: 'Page introuvable',
        },
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.afterEach((to) => {
    document.title = 'FuturePresents - ' + to.meta.title
})

export default router
