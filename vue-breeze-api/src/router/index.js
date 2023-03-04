import { createRouter, createWebHistory } from "vue-router";

const routes = [
    { path: '/login', name: 'Login',component: () => import ('@/pages/auth/Login.vue') },
    { path: '/register', name: 'Register',component: () => import ('@/pages/auth/Register.vue') },
    { path: '/forgot_password', name: 'ForgotPassword',component: () => import ('@/pages/auth/ForgotPassword.vue') },
    { path: '/password-reset/:token', name: 'PasswordReset',component: () => import ('@/pages/auth/PasswordReset.vue') },
    { path: '/send-verify-email', name: 'SendVerifyEmail',component: () => import ('@/pages/auth/SendVerifyEmail.vue') },
    { path: '/', name: 'Home',component: () => import ('@/pages/Home.vue') },
    { path: '/user', children: [{
        path: ':edit',
        name: 'userEdit',
        component: () => import ('@/pages/user/Edit.vue')
    }], name: 'User',component: () => import ('@/pages/user/Index.vue') },
    { path: '/question-list', name: 'QuestionList',component: () => import ('@/pages/q&a/QuestionList.vue') },
    { path: '/question-details/:id', name: 'QuestionDetails',component: () => import ('@/pages/q&a/QuestionDetails.vue') },
    { path: '/editor', name: 'Editor',component: () => import ('@/pages/Editor.vue') },
    { path: '/test', name: 'Test',component: () => import ('@/pages/Test.vue') },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router