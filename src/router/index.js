import { createRouter, createWebHistory } from 'vue-router'
import Register from '@/views/Register.vue'
import Login from '@/views/Login.vue'
import NotFound from '@/views/NotFound.vue'
import Account from '@/views/Account.vue'

const routes = [
    {
        name: 'Login',
        path: '/',
        component: Login,
        meta: {
            title: 'Connexion',
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
        name: 'Account',
        path: '/account',
        component: Account,
        meta: {
            title: 'Mon compte',
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
