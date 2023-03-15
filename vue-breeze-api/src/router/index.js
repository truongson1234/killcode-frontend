import { createRouter, createWebHistory } from "vue-router";
import { getActivePinia } from "pinia";
import { useAuthStore } from "@/stores/auth";
const requireAuth = async (to, from, next) => {
    const authStore = useAuthStore();
    const status = await authStore.checkAuth()
    console.log('GET AUTH STATUS', status)
    if (status) {
        next();
    } else {
        next("/login");
    }
};
const checkLogin = async (to, frorm, next) => {
    const authStore = useAuthStore();
    const status = await authStore.checkAuth()
    // console.log('GET AUTH STATUS', status)
    if (!status) {
        next();
    } else {
        next("/home");
    }
}
const routes = [
    {
        path: "/login",
        name: "Login",
        component: () => import("@/pages/auth/Login.vue"),
        beforeEnter: checkLogin,
    },
    {
        path: "/register",
        name: "Register",
        component: () => import("@/pages/auth/Register.vue"),
        beforeEnter: checkLogin,
    },
    {
        path: "/forgot_password",
        name: "ForgotPassword",
        component: () => import("@/pages/auth/ForgotPassword.vue"),
        beforeEnter: checkLogin,
    },
    {
        path: "/password-reset/:token",
        name: "PasswordReset",
        component: () => import("@/pages/auth/PasswordReset.vue"),
        beforeEnter: checkLogin,
    },
    {
        path: "/send-verify-email",
        name: "SendVerifyEmail",
        component: () => import("@/pages/auth/SendVerifyEmail.vue"),
        beforeEnter: checkLogin,
    },
    { path: "/", name: "Main", component: () => import("@/pages/Main.vue") },
    {
        path: "/home",
        name: "Home",
        component: () => import("@/pages/Home.vue"),
    },
    {
        path: "/user",
        children: [
            {
                path: ":edit",
                name: "userEdit",
                component: () => import("@/pages/user/Edit.vue"),
            },
        ],
        name: "User",
        component: () => import("@/pages/user/Index.vue"),
    },
    {
        path: "/posts",
        children: [
            {
                path: "",
                name: "PostsList",
                component: () => import("@/pages/posts/List.vue"),
            },
            {
                path: "/create-posts",
                name: "PostsCreate",
                component: () => import("@/pages/posts/Create.vue"),
            },
            {
                path: "/edit-posts/:id",
                name: "PostsEdit",
                component: () => import("@/pages/posts/Edit.vue"),
            },
            {
                path: "/posts-detail/:id",
                name: "PostsDetail",
                component: () => import("@/pages/posts/Detail.vue"),
            },
        ],
        name: "Posts",
        component: () => import("@/pages/posts/Index.vue"),
    },
    {
        path: "/question",
        children: [
            {
                path: "",
                name: "QuestionList",
                component: () => import("@/pages/question/List.vue"),
            },
            {
                path: "/question-detail/:id",
                name: "QuestionDetail",
                component: () => import("@/pages/question/Detail.vue"),
            },
        ],
        name: "Question",
        component: () => import("@/pages/question/Index.vue"),
    },
    {
        path: "/test",
        name: "Test",
        component: () => import("@/pages/Test.vue"),
    },
    {
        path: "/admin",
        children: [
            {
                path: "",
                name: "Dashboard",
                component: () => import("@/pages/admin/Dashboard.vue"),
            },
            {
                path: "roles",
                name: "Admin-Roles",
                component: () => import("@/pages/admin/Roles.vue"),
            },
        ],
        name: "Admin",
        component: () => import("@/pages/admin/Index.vue"),
        beforeEnter: requireAuth,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
