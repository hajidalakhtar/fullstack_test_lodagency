import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import Detail from "@/views/article/Detail.vue";
import Login from "@/views/auth/Login.vue";
import Create from "@/views/article/Create.vue";
import Article from "@/views/dashboard/Article.vue";
import Search from "@/views/article/Search.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/detail/:id',
            name: 'detail',
            component: Detail
        },
        {
            path: '/create',
            name: 'create',
            component: Create
        },
        {
            path: '/edit/:id',
            name: 'edit',
            component: Create
        },
        {
            path: '/search',
            name: 'search',
            component: Search
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Article
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        }

    ]
})

export default router
