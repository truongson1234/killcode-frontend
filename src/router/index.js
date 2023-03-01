import {
    createRouter,
    createWebHistory
} from 'vue-router'

// Home
import Home from '@/pages/Home.vue'
// User
import User from '@/pages/user/Index.vue'
import userEdit from '@/pages/user/Edit.vue'
// Posts
// import ArticleList from '@/pages/posts/ArticleList.vue'
// Question
import QuestionList from '@/pages/q&a/QuestionList.vue'
import QuestionDetails from '@/pages/q&a/QuestionDetails.vue'
// Editor
import Editor from '@/pages/Editor.vue'
// Test
import Test from '@/pages/Test.vue'

const routes = [{
        path: '/',
        component: Home,
        name: 'Home',
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
        path: '/question-details/:id',
        component: QuestionDetails,
        name: 'QuestionDetails',
    },
    {
        path: '/editor',
        component: Editor,
        name: 'Editor',
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