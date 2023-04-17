<template>
    <div class="wrapper container detail-unique-question">
        <div class="p-6">
            <div class="flex items-center">
                <div class="userimage"><img :src="author.avatar" alt="" /></div>
                <div class="flex flex-col ml-2">
                    <span class="username leading-5 text-blue-600 font-bold"><a
                            href="javascript:;">{{
                                author.name }}</a>
                    </span>
                    <span class="text-gray-500">
                        Đã đăng vào
                        {{ formatDetailDateTime(post.created_at) }}
                    </span>
                </div>
            </div>
            <h1 class="text-4xl font-bold title-post mt-4">{{ post.title }}</h1>
            <div class="prose mt-4" v-html="post.body"></div>
            <div class="list-tag">
                <a href=""
                    class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 "
                    v-for="tag in tags" :key="tag.id">{{ tag.name }}</a>
            </div>
            <h2 class="text-lg font-bold mb-3 mt-4">Bình luận</h2>
            <div class="space-y-4 box-users-comment">
                <div v-if="comments && comments.length > 0">
                    <comment v-for="comment in comments" :key="comment.id"
                        :comment="comment" :author="author"
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
                            <img :src="author.avatar" alt="" class="">
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
    post_id: questionId,
    user_id: null,
    content: "",
});

const author = ref({});
const post = ref({});
const tags = ref({})
const comments = ref([]);

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
        comments.value.push(cmt);
    });
    pageLoaded(1000)
});

const fetchData = () => {
    axios
        .get(`/api/questions/${questionId}`)
        .then((response) => {
            post.value = response.data.question;
            tags.value = response.data.question.tags;
            author.value = response.data.author;
            comments.value = response.data.comments;
            // console.log('detail-post', response.data.question)
            // comments.value.reverse();
        })
        .catch((error) => {
            console.log(error);
        });
};

const sendCmt = async (payload) => {
    if (payload.user_id) {
        await axios.post('/api/comments/post', payload)
        payload.content = ""
    } else {
        console.error("Lỗi");
    }
};
</script>
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
}</style>