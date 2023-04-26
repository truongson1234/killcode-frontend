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
const checkUnLogin = (to, frorm, next) => {
    const status = localStorage.getItem("isAuthenticated");
    if (!status) {
        next();
    } else {
        next("/home");
    }
};
const checkLogined = (to, from, next) => {
    const status = localStorage.getItem("isAuthenticated");
    if (status) {
        next();
    } else {
        next("/home");
    }
};
// Kiểm tra xem người dùng đang đăng nhập hiện tại có được phép edit bài viết hay không 
const checkAuthorPost = async (to, from, next) => {
    const authStore = useAuthStore();
    if(authStore.getInfoUser != null) {
        const authId = authStore.getInfoUser.id;
        const paramAuthId = to.params.auth;
    
        if (authId === parseInt(paramAuthId)) {
            next();
        } else {
            next("/home");
        }
    }else {
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
        beforeEnter: checkUnLogin,
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
                path: "search",
                name: "Search",
                component: () => import("@/pages/Search.vue"),
                meta: { showFooter: true, showNavBar: true },
                props: true,
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
                path: "list-all-notice/:id",
                name: "ListAllNotice",
                component: () => import("@/pages/notice/Index.vue"),
                meta: { showFooter: true, showNavBar: true },
                beforeEnter: checkLogined,
            },
            {
                path: "list-all-notice/:id",
                name: "ListAllNotice",
                component: () => import("@/pages/notice/Index.vue"),
                meta: { showFooter: true, showNavBar: true },
                beforeEnter: checkLogined,
            },
            {
                path: "questions",
                name: "Questions",
                children: [
                    {
                        path: "",
                        name: "QuestionsList",
                        component: () => import("@/pages/questions/List.vue"),
                    },
                    {
                        path: "/create-question",
                        name: "QuestionCreate",
                        component: () => import("@/pages/questions/Create.vue"),
                        beforeEnter: checkLogined,
                    },
                    {
                        path: "/question-detail/:id",
                        name: "QuestionDetail",
                        component: () => import("@/pages/questions/Detail.vue"),
                    },
                    {
                        path: "/question-edit/:id/auth/:auth",
                        name: "QuestionEdit",
                        component: () => import("@/pages/questions/Edit.vue"),
                        beforeEnter: checkAuthorPost,
                    },
                ],
                component: () => import("@/pages/questions/Index.vue"),
                meta: { showFooter: true, showNavBar: true },
            },
            {
                path: "tags",
                name: "Tags",
                children: [
                    {
                        path: "",
                        name: "TagsList",
                        component: () => import("@/pages/tags/List.vue"),
                    },
                    {
                        path: "/create-tags",
                        name: "TagsCreate",
                        component: () => import("@/pages/tags/Create.vue"),
                    },
                    // {
                    //     path: "/edit-tags/:id",
                    //     name: "TagsEdit",
                    //     component: () => import("@/pages/tags/Edit.vue"),
                    // },
                    {
                        path: "/tag-detail/:id",
                        name: "TagDetail",
                        component: () => import("@/pages/tags/Detail.vue"),
                    },
                ],
                component: () => import("@/pages/tags/Index.vue"),
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
                        path: "/create-post",
                        name: "PostCreate",
                        component: () => import("@/pages/posts/Create.vue"),
                        beforeEnter: checkLogined,
                    },
                    {
                        path: "/post-edit/:id/auth/:auth",
                        name: "PostEdit",
                        component: () => import("@/pages/posts/Edit.vue"),
                        beforeEnter: checkAuthorPost,
                    },
                    {
                        path: "/post-detail/:id",
                        name: "PostDetail",
                        component: () => import("@/pages/posts/Detail.vue"),
                    },
                ],
                component: () => import("@/pages/posts/Index.vue"),
                meta: { showFooter: true, showNavBar: true },
            },
            {
                path: "user",
                name: "User",
                children: [
                    {
                        path: "/user/:id",
                        name: "Profile",
                        component: () => import("@/pages/user/Profile.vue"),
                    },
                    {
                        path: "post/drafts",
                        name: "PostDrafts",
                        component: () => import("@/pages/user/PostDrafts.vue"),
                        beforeEnter: checkLogined,
                    },
                ],
                component: () => import("@/pages/user/Index.vue"),
                meta: { showFooter: true, showNavBar: true },
                // beforeEnter: checkLogined,
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
            {
                path: "tags",
                name: "AdminTags",
                component: () => import("@/pages/admin/Tags.vue"),
            },
            {
                path: "users",
                name: "AdminUsers",
                component: () => import("@/pages/admin/Users.vue"),
            },
            {
                path: "posts",
                name: "AdminPosts",
                component: () => import("@/pages/admin/Posts.vue"),
            },
            {
                path: "questions",
                name: "AdminQuestions",
                component: () => import("@/pages/admin/Questions.vue"),
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
