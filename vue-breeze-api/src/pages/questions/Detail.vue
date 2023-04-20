<template>
    <div class="container detail-unique-question">
        <div class="grid grid-cols-4 gap-x-7 gap-y-5 mx-auto">
            <div class="main-detail-question col-span-4 row-span-1 lg:col-span-3 lg:row-span-3">
                <div class="flex justify-between">
                    <div class="flex items-center">
                        <div class="userimage"><img :src="author.avatar" alt="" /></div>
                        <div class="ml-2">
                            <span class="username leading-5 text-blue-600 font-bold"><a
                                    href="javascript:;">{{ author.name }}</a>
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="text-gray-500">
                            Đã đăng vào
                            {{ formatDetailDateTime(post.created_at) }}
                        </span>
                        <ul class="flex items-center justify-end">
                            <li class="pr-4 text-gray-500 text-lg flex items-center">
                                <i class="bx bx-show pr-1"></i>
                                {{ post.views_count }}
                            </li>
                            <li class="pr-4 text-gray-500 text-lg flex items-center">
                                <i class="bx bx-comment-detail pr-1"></i>
                                {{ post.comments_count }}
                            </li>
                            <li class="pr-4 text-gray-500 text-lg flex items-center">
                                <i class="bx bx-like pr-1"></i>
                                {{ post.likes_count }}
                            </li>
                        </ul>
                    </div>
                </div>
                <h1 class="text-4xl font-bold title-post mt-4">{{ post.title }}</h1>
                <div class="prose mt-4" v-html="post.body"></div>
                <div class="list-tag">
                    <a href=""
                        class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 "
                        v-for="tag in tags" :key="tag.id">{{ tag.name }}</a>
                </div>
                <button @click="handleLiked" type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 mt-3 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <span v-html="statusLike" class="flex"></span>
                </button>
                <h2 class="text-lg font-bold mb-3 mt-4">Bình luận</h2>
                <div class="space-y-4 box-users-comment">
                    <div v-if="comments && comments.length > 0">
                        <comment v-for="comment in comments" :key="comment.id"
                            :comment="comment" :author="comment.author"
                            :formatdate="formatDetailDateTime" />
                    </div>
                    <div v-else class="text-center">
                        <span class="text-gray-500">Chưa có bình luận nào.</span>
                    </div>
                </div>
                <div class="box-type-comment mt-4">
                    <form v-if="authStore.getInfoUser"
                        @submit.prevent="sendCmt(payload)">
                        <div class="flex items-center space-x-3">
                            <div class="userimage self-start">
                                <img :src="authStore.getInfoUser.avatar" alt=""
                                    class="">
                            </div>
                            <textarea class="w-full" v-model="payload.content"
                                placeholder="Viêt bình luận..."></textarea>
                        </div>
                        <div class="flex">
                            <button type="submit"
                                class="ml-auto bg-blue-500 hover:bg-blue-700 text-white py-2 px-2.5 rounded mt-2 justify-self-end">Bình
                                luận</button>
                        </div>
                    </form>
                    <div v-else class="text-center text-gray-500">
                        <span class="">Đăng nhập để được bình luận! <router-link
                                :to="{ name: 'Login' }" class="text-blue-500">Đăng nhập
                                ngay.</router-link></span>
                    </div>
                </div>
            </div>
            <div class="main-related-questions col-span-4 p-3 box-popular_tags h-100 row-span-1 lg:col-span-1 lg:row-span-1">
                <h5 class="text-center pb-3 font-bold text-blue-500">Câu hỏi liên quan</h5>
                <div v-for="question in related_questions" :key="question.id">
                    <QuestionSidebar :data="question"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { pageLoading, pageLoaded, formatDetailDateTime } from '@/assets/js/app.js'
import axios from "axios";
import Pusher from "pusher-js";
import Comment from "@/components/ui/Comment.vue";
import router from "@/router";
import QuestionSidebar from "@/components/ui/QuestionSidebar.vue";
// lấy user_id
const authStore = useAuthStore();
// lấy post_id
const route = useRoute();
const questionId = route.params.id;

const isAdmin = computed(() => {
    return authStore.getAuthRoles;
});
const infoAuth = computed(() => {
    return authStore.getInfoUser;
});

const data = () => ({
    pusher: null,
    channel: null,
});

const payload = ref({
    question_id: questionId,
    user_id: null,
    content: "",
});

const liked = ref(false);
const author = ref({});
const post = ref({});
const viewers = ref({});
const tags = ref({});
const comments = ref([]);
const related_questions = ref([]);

onMounted(async () => {
    await pageLoading()
    await authStore.getToken();
    await authStore.getUser();
    // add user_id
    if (infoAuth.value) {
        payload.value.user_id = infoAuth.value.id;
    }

    await fetchData(questionId);

    // lắng nghe sự kiện
    data.pusher = new Pusher("100f9f72ec40accb9c52", {
        cluster: "ap1",
        encrypted: true,
    });

    data.channel = data.pusher.subscribe("chanel-comments");

    data.channel.bind(`event-comment-${questionId}`, (cmt) => {
        cmt.author.avatar = 'http://localhost:8000/images/' + cmt.author.avatar
        comments.value.unshift(cmt);
        post.value.comments_count = post.value.comments_count + 1;
    });
    pageLoaded(1000)
});
const statusLike = computed(() => {
    return liked.value == false ? "<i class='bx bx-like text-lg pr-1' ></i> Thích" : "<i class='bx bxs-like text-lg pr-1' ></i> Bỏ thích"
})
const fetchData = () => {
    axios
        .get("/api/questions/interactions/views", {
            params: {
                question_id: questionId,
            },
        })
        .catch((e) => {
            console.error(e);
        });
    axios
        .get(`/api/questions/${questionId}`)
        .then((response) => {
            post.value = response.data.question;
            liked.value = response.data.liked ? true : false;
            viewers.value = response.data.viewers;
            tags.value = response.data.tags;
            author.value = response.data.author;
            comments.value = response.data.comments;
            related_questions.value = response.data.related_questions;
            comments.value.forEach(function (item) {
                item.author.avatar = 'http://localhost:8000/images/' + item.author.avatar
            })
            // console.log('detail-question', response.data.related_questions)
            comments.value.reverse();
        })
        .catch((error) => {
            console.log(error);
        });
};

const sendCmt = async (payload) => {
    if (payload.user_id) {
        await axios.post('/api/comments', payload)
        payload.content = ""
    } else {
        console.error("Lỗi");
    }
};
const handleLiked = () => {
    if (authStore.getInfoUser != null) {
        axios
            .post("/api/questions/interactions/liked", {
                question_id: questionId,
            })
            .then((response) => {
                console.log(response.data);
                if (response.data.status == 1) {
                    liked.value = response.data.liked;
                    post.value.likes_count = response.data.likes_count;
                    post.value.views_count = response.data.views_count;
                } else {
                    console.error("Lỗi");
                }
            })
            .catch((e) => {
                console.error(e);
            });
    } else {
        Swal.fire({
            title: "",
            text: 'Vui lòng đăng nhập để có thể thích chủ đề!',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#aaa8a5",
            confirmButtonText: "Đăng nhập",
            cancelButtonText: "Hủy",
        }).then(result => {
            if (result.isConfirmed) {
                router.push({ name: 'Login' })
                    .then(() => { router.go() })
            }
        })
    }
};
</script>
<style scoped>
.main-related-questions {
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    border-radius: 6px;
}
</style>
<style>
.detail-unique-question .userimage img {
    width: 100%;
}

.detail-unique-question .userimage {
    width: 50px;
    height: 50px;
    border-radius: 40px;
    overflow: hidden;
}

.detail-unique-question .box-users-comment {
    border: 1px solid #e2e7eb;
    padding: 15px;
    border-radius: 3px;
}

.detail-unique-question .box-type-comment {
    border: 1px solid #e2e7eb;
    padding: 15px;
    border-radius: 3px;
}

.detail-unique-question .box-type-comment .userimage {
    width: 45px;
    height: 42px;
}

.detail-unique-question .box-type-comment textarea {
    border-radius: 3px;
    height: 100px;
}

.detail-unique-question .prose pre {
    margin: 1em 0;
    background-color: #f1f2f3;
    border: 1px solid #e5e5e5;
    padding: 1em;
    overflow: auto;
    background-color: #f6f8fa;
    border-radius: 3px
}
</style>