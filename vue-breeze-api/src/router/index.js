import { createRouter, createWebHistory } from "vue-router";

const routes = [
    { path: '/login', name: 'Login',component: () => import ('@/pages/auth/Login.vue') },
    { path: '/register', name: 'Register',component: () => import ('@/pages/auth/Register.vue') },
    { path: '/forgot_password', name: 'ForgotPassword',component: () => import ('@/pages/auth/ForgotPassword.vue') },
    { path: '/password-reset/:token', name: 'PasswordReset',component: () => import ('@/pages/auth/PasswordReset.vue') },
    { path: '/send-verify-email', name: 'SendVerifyEmail',component: () => import ('@/pages/auth/SendVerifyEmail.vue') },
    { path: '/', name: 'Main',component: () => import ('@/pages/Main.vue') },
    { path: '/home', name: 'Home',component: () => import ('@/pages/Home.vue') },
    { path: '/user', children: [{
        path: ':edit',
        name: 'userEdit',
        component: () => import ('@/pages/user/Edit.vue')
    }], name: 'User',component: () => import ('@/pages/user/Index.vue') },
    { path: '/posts', children: [
        {
            path: '',
            name: 'PostsList',
            component: () => import ('@/pages/posts/List.vue')
        },
        {
            path: '/create-posts',
            name: 'PostsCreate',
            component: () => import ('@/pages/posts/Create.vue')
        },
        {
            path: '/posts-detail/:id',
            name: 'PostsDetail',
            component: () => import ('@/pages/posts/Detail.vue')
        }
    ], name: 'Posts',component: () => import ('@/pages/posts/Index.vue') },
    { path: '/question', children: [
        {
            path: '',
            name: 'QuestionList',
            component: () => import ('@/pages/question/List.vue')
        },
        {
            path: '/question-detail/:id',
            name: 'QuestionDetail',
            component: () => import ('@/pages/question/Detail.vue')
        }
    ], name: 'Question',component: () => import ('@/pages/question/Index.vue') },
    { path: '/test', name: 'Test',component: () => import ('@/pages/Test.vue') },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router