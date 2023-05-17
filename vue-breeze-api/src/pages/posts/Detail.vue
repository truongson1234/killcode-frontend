<template>
    <div class="container detail-unique-post relative">
        <div class="grid grid-cols-4 gap-x-7 gap-y-5 mx-auto">
            <div
                class="main-detail-post col-span-4 row-span-1 lg:col-span-3 lg:row-span-3"
            >
                <div class="flex justify-between">
                    <div class="flex items-center">
                        <div class="userimage">
                            <img :src="author.avatar" alt="" />
                        </div>
                        <div class="ml-2">
                            <span
                                class="username leading-5 text-blue-600 font-bold"
                                ><a href="javascript:;">{{ author.name }}</a>
                            </span>
                        </div>
                    </div>
                    <div v-if="post.status_id == 2">
                        <span class="text-gray-500">
                            <span
                                ><i class="bx bxs-lock-alt"></i>Bản nháp -
                            </span>
                            Sửa đổi lần cuối khoảng
                            {{ formatDateTimeFB(new Date(post.updated_at)) }}
                        </span>
                    </div>
                    <div v-else-if="post.status_id == 3">
                        <span class="text-gray-500">
                            <span><i class="bx bx-block"></i></span>
                            Bài viết đã vi phạm khoảng
                            {{ formatDateTimeFB(new Date(post.created_at)) }}
                        </span>
                    </div>
                    <div v-else>
                        <span class="text-gray-500">
                            Đã đăng vào
                            {{ formatDetailDateTime(post.updated_at) }}
                        </span>
                        <ul class="flex items-center justify-end">
                            <li
                                class="pr-4 text-gray-500 text-lg flex items-center"
                            >
                                <i class="bx bx-show pr-1"></i>
                                {{ post.views_count ? post.views_count : 0 }}
                            </li>
                            <li
                                class="pr-4 text-gray-500 text-lg flex items-center"
                            >
                                <i class="bx bx-comment-detail pr-1"></i>
                                {{
                                    post.comments_count
                                        ? post.comments_count
                                        : 0
                                }}
                            </li>
                            <li
                                class="pr-4 text-gray-500 text-lg flex items-center"
                            >
                                <i class="bx bx-like pr-1"></i>
                                {{ post.likes_count ? post.likes_count : 0 }}
                            </li>
                            <li class="text-gray-500 text-sm">
                                <button
                                    @click="showModalReport($event)"
                                    class="bg-red-600 hover:bg-red-700 text-gray-100 px-2 py-1 flex items-center"
                                    style="border-radius: 3px"
                                >
                                    <i class="bx bxs-flag-alt mr-1"></i>
                                    Báo cáo
                                </button>
                                <div
                                    id="modal-report"
                                    class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
                                >
                                    <div
                                        @click="showModalReport($event)"
                                        class="backdrop-modal-report absolute z-10"
                                    ></div>
                                    <div class="relative h-full border-0">
                                        <div
                                            class="absolute bg-white rounded-lg shadow z-20"
                                            style="
                                                top: 50%;
                                                left: 50%;
                                                transform: translate(
                                                    -50%,
                                                    -50%
                                                );
                                            "
                                        >
                                            <button
                                                type="button"
                                                @click="showModalReport($event)"
                                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                            >
                                                <i class="bx bx-x text-xl"></i>
                                            </button>
                                            <form @submit.prevent="sendReport($event,report_obj)">
                                                <div
                                                    class="px-4 pt-4 pb-2 lg:px-5 cc"
                                                >
                                                    <h3
                                                        class="mb-3 text-xl font-medium text-gray-900 dark:text-white"
                                                    >
                                                        Nội dung báo cáo
                                                    </h3>
                                                    <textarea
                                                        id=""
                                                        v-model="report_obj.reason"
                                                        cols="30"
                                                        rows="2"
                                                        class="w-full rounded border-gray-400"
                                                        placeholder="Nhập lí do vì sao bài viết bị báo cáo"
                                                    ></textarea>
                                                </div>
                                                <div
                                                    class="px-4 pb-4 lg:px-5 text-right"
                                                    style="width: 450px"
                                                >
                                                    <button
                                                        type="submit"
                                                        class="px-2 py-2 bg-red-600 text-gray-100"
                                                        style="
                                                            border-radius: 3px;
                                                        "
                                                    >
                                                        Báo cáo
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <h1 class="text-4xl font-bold title-post mt-4 text-gray-800">
                    {{ post.title }}
                </h1>
                <div class="prose mt-4 text-gray-800" v-html="post.body"></div>
                <div class="list-tag">
                    <a
                        href=""
                        class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300"
                        v-for="tag in tags"
                        :key="tag.id"
                        >{{ tag.name }}</a
                    >
                </div>
                <button
                    @click="handleLiked"
                    type="button"
                    v-if="post.status_id == 1"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-3 py-2.5 mt-3 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    style="border-radius: 3px"
                >
                    <span v-html="statusLike" class="flex"></span>
                </button>
                <div v-if="post.status_id == 1">
                    <h2 class="text-lg font-bold mb-3 mt-4">
                        Bình luận ({{ post.comments_count }})
                    </h2>
                    <div class="space-y-4 box-users-comment">
                        <div v-if="comments && comments.length > 0">
                            <comment
                                v-for="comment in comments"
                                :key="comment.id"
                                :comment="comment"
                                :author="comment.author"
                                :deletecomment="deleteComment"
                                :formatdate="formatDateTimeFB"
                                :editcomment="editComment"
                            />
                        </div>
                        <div v-else class="text-center">
                            <span class="text-gray-500"
                                >Chưa có bình luận nào.</span
                            >
                        </div>
                    </div>
                    <div class="box-type-comment mt-4">
                        <form
                            v-if="authStore.getInfoUser"
                            @submit.prevent="sendCmt(payload)"
                        >
                            <div class="flex items-center space-x-3">
                                <div class="userimage self-start">
                                    <img
                                        :src="authStore.getInfoUser.avatar"
                                        alt=""
                                        class=""
                                    />
                                </div>
                                <textarea
                                    class="w-full"
                                    v-model="payload.content"
                                    placeholder="Viêt bình luận..."
                                ></textarea>
                            </div>
                            <div class="flex">
                                <button
                                    type="submit"
                                    class="ml-auto bg-blue-500 hover:bg-blue-700 text-white py-2 px-2.5 rounded mt-2 justify-self-end"
                                >
                                    Bình luận
                                </button>
                            </div>
                        </form>
                        <div v-else class="text-center text-gray-500">
                            <span class=""
                                >Đăng nhập để được bình luận!
                                <router-link
                                    :to="{ name: 'Login' }"
                                    class="text-blue-500"
                                    >Đăng nhập ngay.</router-link
                                ></span
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="main-related-posts col-span-4 p-3 box-popular_tags h-100 row-span-1 lg:col-span-1 lg:row-span-1"
            >
                <h5 class="text-center pb-3 font-bold text-blue-500">
                    Bài viết liên quan
                </h5>
                <div v-for="post in related_posts" :key="post.id">
                    <PostSidebar :data="post" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import {
    pageLoading,
    pageLoaded,
    formatDetailDateTime,
    formatDateTimeFB,
} from "@/assets/js/app.js";
import axios from "axios";
import Pusher from "pusher-js";
import Comment from "@/components/ui/Comment.vue";
import PostSidebar from "@/components/ui/PostSidebar.vue";
import router from "@/router";
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

const liked = ref(false);
const author = ref({});
const post = ref({});
const viewers = ref({});
const tags = ref({});
const comments = ref([]);
const related_posts = ref([]);
const report_obj = ref({
    post_id: postId,
    user_id: null,
    reason: ""
});

onMounted(async () => {
    await pageLoading();
    await authStore.getToken();
    await authStore.getUser();
    // add user_id
    if (infoAuth.value) {
        payload.value.user_id = infoAuth.value.id;
        report_obj.value.user_id = infoAuth.value.id;
    }

    await fetchData(postId);

    // lắng nghe sự kiện
    data.pusher = new Pusher("100f9f72ec40accb9c52", {
        cluster: "ap1",
        encrypted: true,
    });

    data.channel = data.pusher.subscribe("chanel-comments");

    data.channel.bind(`event-comment-${postId}`, (cmt) => {
        cmt.author.avatar = "http://localhost:8000/images/" + cmt.author.avatar;
        comments.value.unshift(cmt);
        post.value.comments_count = post.value.comments_count + 1;
    });
    pageLoaded(1000);
});

const statusLike = computed(() => {
    return liked.value == false
        ? "<i class='bx bx-like text-lg pr-1' ></i> Thích"
        : "<i class='bx bxs-like text-lg pr-1' ></i> Bỏ thích";
});
const fetchData = () => {
    axios
        .get(`/api/posts/${postId}`)
        .then((response) => {
            // console.log(response.data);
            post.value = response.data.post;
            liked.value = response.data.liked ? true : false;
            viewers.value = response.data.viewers;
            tags.value = response.data.tags;
            author.value = response.data.author;
            comments.value = response.data.comments;
            related_posts.value = response.data.related_posts;
            comments.value.forEach(function (item) {
                item.author.avatar =
                    "http://localhost:8000/images/" + item.author.avatar;
            });
            if (post.value && post.value.status_id == 1) {
                axios
                    .get("/api/posts/interactions/views", {
                        params: {
                            post_id: postId,
                        },
                    })
                    .catch((e) => {
                        console.error(e);
                    });
            }
            // console.log('detail-post', post.value.status_id)
            // comments.value.reverse();
        })
        .catch((error) => {
            console.log(error);
        });
};

const sendCmt = async (payload) => {
    if (payload.user_id) {
        await axios.post("/api/comments", payload)
            .then((res) => {
                if (res.data.status == 1) {
                    payload.content = "";
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: res.data.message,
                    })                    
                }
            });
    } else {
        console.error("Lỗi");
    }
};
const deleteComment = (id) => {
    axios
        .delete(`api/comments/${id}`)
        .then((res) => {
            if (res.data.status == 1) {
                comments.value = comments.value.filter(
                    (comment) => comment.id !== id
                );  
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: res.data.message,
                })                    
            }
        })
        .catch((err) => {
            console.log(err);
        });
};
const editComment = (id, content) => {
    if (content != "") {
        $(`#default-comment-${id}`).removeClass(
            "focus:ring-red-500 focus:border-red-500 ring-red-500 border-red-500"
        );
        $(`#default-comment-${id}`).removeAttr();
        axios
            .put(`api/comments/${id}`, { content: content })
            .then((res) => {
                if (res.data.status == 1) {
                    $(".tool-comment").each(function () {
                        $(this).removeClass("hidden");
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: res.data.message,
                    })                    
                }
            })
            .catch((err) => {
                console.log(err);
            });
    } else {
        $(`#default-comment-${id}`).addClass(
            "focus:ring-red-500 focus:border-red-500 ring-red-500 border-red-500"
        );
    }
};

const handleLiked = () => {
    if (authStore.getInfoUser != null) {
        axios
            .post("/api/posts/interactions/liked", {
                post_id: postId,
            })
            .then((response) => {
                if (response.data.status == 1) {
                    liked.value = response.data.liked;
                    post.value.likes_count = response.data.likes_count;
                    post.value.views_count = response.data.views_count;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.data.message,
                    })                    
                }
            })
            .catch((e) => {
                console.error(e);
            });
    } else {
        Swal.fire({
            title: "",
            text: "Vui lòng đăng nhập để có thể thích bài viết!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#aaa8a5",
            confirmButtonText: "Đăng nhập",
            cancelButtonText: "Hủy",
        }).then((result) => {
            if (result.isConfirmed) {
                router.push({ name: "Login" }).then(() => {
                    router.go();
                });
            }
        });
    }
};
const showModalReport = (event) => {
    event.stopPropagation();
    if ($(`#modal-report`).first().is(":hidden")) {
        $(`#modal-report`).fadeIn(300);
    } else {
        $(`#modal-report`).fadeOut(300);
    }
};
const sendReport = async (event,report_obj) => {
    if (report_obj.user_id == null) {
        Swal.fire({
            icon: 'error',
            title: 'Ố...',
            text: 'Hãy đăng nhập trước khi báo cáo!',
        })
    }
    if (report_obj.reason == "") {
        Swal.fire({
            icon: 'error',
            title: 'Ố...',
            text: 'Hãy điền đầy đủ nội dung!',
        })
    } else {
        await axios.post("/api/reports", report_obj)
            .then(res => {
                if (res.data.status == 1) {
                    Swal.fire(
                        'Thật tuyệt!',
                        'Đã gửi thành công báo cáo!',
                        'success'
                    )
                    showModalReport(event)
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: res.data.message,
                    })                    
                }
            })
    }
}
</script>
<style scoped>
.main-related-posts {
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    border-radius: 6px;
}

#modal-report .backdrop-modal-report {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.2);
}
</style>
<style>
.detail-unique-post h3 {
    font-size: 1.55rem!important
}
.detail-unique-post h2 {
    font-size: 1.75rem!important
}
.detail-unique-post .prose ul,
.detail-unique-post .prose ol {
    list-style: inherit;
    padding-left: 32px;
}

.detail-unique-post .prose ol {
    list-style-type: auto;
}

.detail-unique-post .prose a {
    color: rgb(24, 132, 255);
}

.detail-unique-post .prose a:hover {
    text-decoration: underline;
}

.detail-unique-post .userimage img {
    width: 100%;
}

.detail-unique-post .userimage {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    border-radius: 40px;
    overflow: hidden;
}

.detail-unique-post .box-users-comment {
    border: 1px solid #e2e7eb;
    padding: 15px;
    border-radius: 3px;
}

.detail-unique-post .box-type-comment {
    border: 1px solid #e2e7eb;
    padding: 15px;
    border-radius: 3px;
}

.detail-unique-post .box-type-comment .userimage {
    width: 45px;
    height: 42px;
}

.detail-unique-post .box-type-comment textarea {
    border-radius: 3px;
    height: 100px;
}

.detail-unique-post .prose pre {
    margin: 1em 0;
    background-color: #f1f2f3;
    border: 1px solid #e5e5e5;
    padding: 1em;
    overflow: auto;
    background-color: #f6f8fa;
    border-radius: 3px;
}
</style>
