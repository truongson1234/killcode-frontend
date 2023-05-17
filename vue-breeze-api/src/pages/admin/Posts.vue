<template>
    <div class="bg-[#596cff] shadow-lg p-3.5 rounded-lg">
        <form
            @submit.prevent="submitInputSearch"
            class="flex items-center mb-5"
        >
            <label for="voice-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <input
                    v-model="keyword"
                    type="text"
                    id="voice-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Tìm kiếm tiêu đề, nội dung, id, ..."
                />
            </div>
            <button
                type="submit"
                class="btn-search"
            >
                Tìm
            </button>
        </form>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-4 py-3">Tiều đề</th>
                        <th scope="col" class="px-4 py-3">Trạng thái</th>
                        <th scope="col" class="px-4 py-3">Tác giả</th>
                        <th scope="col" class="px-4 py-3">Thẻ</th>
                        <th scope="col" class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        v-for="post in posts"
                        :key="post.id"
                        :class="{ 'text-red-500': post.is_banned }"
                    >
                        <th
                            scope="row"
                            class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white title-post-ban"
                            :class="{ 'text-red-500': post.is_banned }"
                        >
                            {{ post.title }}
                        </th>
                        <td class="px-4 py-4">{{ post.status.name }}</td>
                        <td class="px-4 py-4">{{ post.user.name }}</td>
                        <td class="px-4 py-4">
                            {{ post.tags.map((tag) => tag.name).join(", ") }}
                        </td>
                        <td class="flex items-center px-2 py-4 space-x-3">
                            <ModalBanPost
                                v-if="!post.is_banned"
                                :post_id="post.id"
                                @update-posts="loadPosts"
                            />
                            <button
                                v-else
                                @click="unbanPost(post.id)"
                                type="button"
                                class="mx-1 focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-2 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900"
                                style="border-radius: 3px;"
                            >
                                <i class="bx bx-wrench"></i>
                            </button>
                            <button
                                @click="removePost(post.id)"
                                type="button"
                                class="mx-1 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium text-sm px-2 py-1.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                style="border-radius: 3px;"
                            >
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import ModalBanPost from "@/components/admin/ui/ModalBanPost.vue";

const posts = ref([]);
const keyword = ref("");

onMounted(() => {
    fetchData();
});

const fetchData = () => {
    axios
        .get("/api/dashboard/posts")
        .then((response) => {
            posts.value = response.data.posts;
            console.log(posts);
        })
        .catch((error) => {
            console.log(error);
        });
};

const loadPosts = (data) => {
    posts.value = data;
};

const unbanPost = async (id) => {
    await axios
        .post(`/api/dashboard/posts/${id}/unban`)
        .then((response) => {
            // posts.value = response.data.posts;
            if (response.data.status == 1) {
                posts.value = response.data.posts;
                Swal.fire(
                    "Đã hủy cấm bài viết này!",
                    "",
                    "success"
                );
            }
            console.log(response);
        })
        .catch((error) => {
            console.log(error);
        });
};

const removePost = (id) => {
    Swal.fire({
        title: 'Bạn có chắc không?',
        text: "Sẽ không thể khôi phục lại!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Có, xóa đi!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios
                .delete(`/api/dashboard/posts/${id}`)
                .then((response) => {
                    posts.value = response.data.posts;
                    // console.log(postStatuses);
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    })
    
};

const submitInputSearch = async () => {
    axios
        .get("/api/dashboard/posts", {
            params: {
                keyword: keyword.value,
            },
        })
        .then((response) => {
            posts.value = response.data.posts;
            console.log(posts);
        })
        .catch((error) => {
            console.log(error);
        });
};
</script>

<style scoped>
.title-post-ban {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.btn-search{
    padding: 9px 20px;
    margin-left: 10px!important;
    background: #fff;
    border: none!important;
    outline: none!important;
    border-radius: 5px!important;
}
</style>
