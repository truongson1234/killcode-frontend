import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/auth";
const requireAuth = async (to, from, next) => {
    const authStore = useAuthStore();
    await authStore.getUser();
    const roles = authStore.getAuthRoles;
    // console.log(roles, 'roles')
    if (roles == null) {
        next("login");
    } else if (roles.indexOf("admin") == -1) {
        next("/authenticated");
    } else {
        next();
    }
};
const checkLogin = async (to, frorm, next) => {
    const status = localStorage.getItem("isAuthenticated");
    // console.log('GET AUTH STATUS', status)
    if (!status) {
        next();
    } else {
        next("/home");
    }
};
const routes = [
    {
        path: "/login",
        name: "Login",
        component: () => import("@/pages/auth/Login.vue"),
        beforeEnter: checkLogin,
        meta: { showHeader: false, showFooter: false, isAdmin: false },
    },
    {
        path: "/register",
        name: "Register",
        component: () => import("@/pages/auth/Register.vue"),
        beforeEnter: checkLogin,
        meta: { showHeader: false, showFooter: false, isAdmin: false },
    },
    {
        path: "/forgot_password",
        name: "ForgotPassword",
        component: () => import("@/pages/auth/ForgotPassword.vue"),
        beforeEnter: checkLogin,
        meta: { showHeader: false, showFooter: false, isAdmin: false },
    },
    {
        path: "/password-reset/:token",
        name: "PasswordReset",
        component: () => import("@/pages/auth/PasswordReset.vue"),
        beforeEnter: checkLogin,
        meta: { showHeader: false, showFooter: false, isAdmin: false },
    },
    {
        path: "/send-verify-email",
        name: "SendVerifyEmail",
        component: () => import("@/pages/auth/SendVerifyEmail.vue"),
        beforeEnter: checkLogin,
        meta: { showHeader: false, showFooter: false, isAdmin: false },
    },
    { path: "/", name: "Main", component: () => import("@/pages/Main.vue") },
    {
        path: "/home",
        name: "Home",
        component: () => import("@/pages/Home.vue"),
        beforeRouteEnter(to, from, next) {
            window.location.reload();
        },
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
                name: "AdminRoles",
                component: () => import("@/pages/admin/Roles.vue"),
            },
            {
                path: "profile-card",
                name: "ProfileCard",
                component: () => import("@/pages/admin/ProfileCard.vue"),
            },
        ],
        name: "Admin",
        component: () => import("@/pages/admin/Index.vue"),
        beforeEnter: requireAuth,
        meta: { showHeader: false, showFooter: false, isAdmin: true },
    },
    {
        path: "/authenticated",
        name: "Authenticated",
        component: () => import("@/pages/errors/Authenticated.vue"),
        meta: { showHeader: false, showFooter: false, isAdmin: false },
    },
    {
        path: "/:catchAll(.*)",
        name: "NotFound",
        component: () => import("@/pages/errors/404.vue"),
        meta: { showHeader: false, showFooter: false, isAdmin: false },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
