import {
    createRouter,
    createWebHistory
} from 'vue-router'

// Home
import Home from '@/pages/Home.vue'
// Auth
import Auth from '@/pages/auth/Index.vue'
import Login from '@/pages/auth/Login.vue'
import Register from '@/pages/auth/Register.vue'
// User
import User from '@/pages/user/Index.vue'
import userEdit from '@/pages/user/Edit.vue'
// Posts
// import ArticleList from '@/pages/posts/ArticleList.vue'
import QuestionList from '@/pages/posts/QuestionList.vue'
// Test
import Test from '@/pages/Test.vue'

const routes = [{
        path: '/',
        component: Home,
        name: 'Home',
    },
    {
        path: '/Auth',
        component: Auth,
        name: 'Auth',
        children: [{
                path: '/login',
                name: 'authLogin',
                component: Login
            },
            {
                path: '/register',
                name: 'authRegister',
                component: Register
            }
        ]
    },
    {
        path: '/user',
        component: User,
        name: 'User',
        children: [{
            path: ':edit',
            name: 'userEdit',
            component: userEdit
        }]
    },
    {
        path: '/question-list',
        component: QuestionList,
        name: 'QuestionList',
    },
    {
        path: '/test',
        component: Test,
        name: 'Test',
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

export default router