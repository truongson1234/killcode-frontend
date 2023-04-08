<template>
    <div class="wrapper container">
        <div class="p-6">
            <h1 class="text-xl font-bold">{{ post.title }}</h1>
            <div class="text-gray-500 mt-2">
                {{ post.created_at }}
            </div>
            <div class="prose mt-4" v-html="post.body"></div>
            <hr class="my-6" />
            <h2 class="text-lg font-bold mb-4">Comments</h2>
            <div class="space-y-4">
                <comment
                    v-for="comment in comments"
                    :key="comment.id"
                    :comment="comment"
                />
            </div>
            <form v-if="authStore.getInfoUser" @submit.prevent="sendCmt(payload)">
                <input type="text" v-model="payload.content" />
                <button type="submit">Gửi</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import axios from "axios";
import Pusher from "pusher-js";
import Comment from "@/components/ui/Comment.vue";

// lấy user_id
const authStore = useAuthStore();
// lấy post_id
const route = useRoute();
const postId = route.params.id;

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
    post_id: postId,
    user_id: null,
    content: "",
});
const post = ref({});
const comments = ref([]);

onMounted(async () => {
    await authStore.getToken();
    await authStore.getUser();

    // add user_id
    if (infoAuth.value) {
        payload.value.user_id = infoAuth.value.id;
    }

    fetchData(postId);

    // lắng nghe sự kiện
    data.pusher = new Pusher("100f9f72ec40accb9c52", {
        cluster: "ap1",
        encrypted: true,
    });

    data.channel = data.pusher.subscribe("chanel-comments");

    data.channel.bind(`event-comment-${postId}`, (cmt) => {
        comments.value.push(cmt);
    });
});

const fetchData = () => {
    axios
        .get(`/api/posts/${postId}`)
        .then((response) => {
            post.value = response.data.post;
            comments.value = response.data.comments;
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
</script>
