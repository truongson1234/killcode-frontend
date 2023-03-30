import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import UserLayout from "@/pages/Index.vue";
import AdminLayout from "@/pages/admin/Index.vue";
import ErrorLayout from "@/pages/auth/Index.vue";
import AuthLayout from "@/pages/errors/Index.vue";

const requireAuth = async (to, from, next) => {
    const authStore = useAuthStore();
    await authStore.getUser();
    const roles = authStore.getAuthRoles;
    // console.log(roles, 'roles')
    if (roles == null) {
        next("auth/login");
    } else if (roles.indexOf("admin") == -1) {
        next("error/authenticated");
    } else {
        next();
    }
};
const checkLogin = (to, frorm, next) => {
    const status = localStorage.getItem("isAuthenticated");
    if (!status) {
        next();
    } else {
        next("/home");
    }
};
const routes = [
    //! ROUTES AUTH
    {
        path: "/auth",
        components: {
            default: AuthLayout,
            other: AuthLayout,
        },
        children: [
            {
                path: "login",
                name: "Login",
                component: () => import("@/pages/auth/Login.vue"),
                meta: { showHeader: false, showFooter: false, isAdmin: false },
            },
            {
                path: "register",
                name: "Register",
                component: () => import("@/pages/auth/Register.vue"),
                meta: { showHeader: false, showFooter: false, isAdmin: false },
            },
            {
                path: "forgot_password",
                name: "ForgotPassword",
                component: () => import("@/pages/auth/ForgotPassword.vue"),
                meta: { showHeader: false, showFooter: false, isAdmin: false },
            },
            {
                path: "password-reset/:token",
                name: "PasswordReset",
                component: () => import("@/pages/auth/PasswordReset.vue"),
                meta: { showHeader: false, showFooter: false, isAdmin: false },
            },
            {
                path: "send-verify-email",
                name: "SendVerifyEmail",
                component: () => import("@/pages/auth/SendVerifyEmail.vue"),
                meta: { showHeader: false, showFooter: false, isAdmin: false },
            },
        ],
        beforeEnter: checkLogin,
    },

    //! ROUTE USER
    {
        path: "/",
        components: {
            default: UserLayout,
            user: UserLayout,
        },
        children: [
            {
                path: "",
                name: "Main",
                component: () => import("@/pages/Main.vue"),
                meta: { showFooter: false, showNavBar: false },
            },
            {
                path: "home",
                name: "Home",
                component: () => import("@/pages/Home.vue"),
                meta: { showFooter: true, showNavBar: true },
            },

            {
                path: "test",
                name: "Test",
                component: () => import("@/pages/Test.vue"),
                meta: { showFooter: true, showNavBar: true },
            },
            {
                path: "profile",
                name: "Profile",
                component: () => import("@/pages/user/Profile.vue"),
                meta: { showFooter: true, showNavBar: false },
            },
            {
                path: "question",
                name: "Question",
                children: [
                    {
                        path: "",
                        name: "QuestionList",
                        component: () => import("@/pages/question/List.vue"),
                    },
                    {
                        path: "question-detail/:id",
                        name: "QuestionDetail",
                        component: () => import("@/pages/question/Detail.vue"),
                    },
                ],
                component: () => import("@/pages/question/Index.vue"),
                meta: { showFooter: true, showNavBar: true },
            },
            {
                path: "posts",
                name: "Posts",
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
                component: () => import("@/pages/posts/Index.vue"),
                meta: { showFooter: true, showNavBar: true },
            },
            {
                path: "user",
                children: [
                    {
                        path: ":edit",
                        name: "userEdit",
                        component: () => import("@/pages/user/Edit.vue"),
                    },
                ],
                name: "User",
                component: () => import("@/pages/user/Index.vue"),
                meta: { showFooter: true, showNavBar: true },
                beforeEnter: checkLogin
            },
        ],
    },

    //! ROUTES ADMIN
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
            
        ],
        name: "Admin",
        components: {
            default: AdminLayout,
            admin: AdminLayout,
        },
        beforeEnter: requireAuth,
    },

    //! ROUTES ERRORS
    {
        path: "/error",
        components: {
            default: ErrorLayout,
            other: ErrorLayout,
        },
        children: [
            {
                path: "authenticated",
                name: "Authenticated",
                component: () => import("@/pages/errors/Authenticated.vue"),
            },
        ],
    },
    {
        path: "/:catchAll(.*)",
        name: "NotFound",
        components: {
            default: () => import("@/pages/errors/404.vue"),
            other: () => import("@/pages/errors/404.vue"),
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
