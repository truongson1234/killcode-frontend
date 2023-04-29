<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th scope="col" class="px-6 py-3">Tiều đề</th>
                    <th scope="col" class="px-6 py-3">Trạng thái</th>
                    <th scope="col" class="px-6 py-3">Bình luận</th>
                    <th scope="col" class="px-6 py-3">Lượt thích</th>
                    <th scope="col" class="px-6 py-3">Lượt xem</th>
                    <th scope="col" class="px-6 py-3">Tác giả</th>
                    <th scope="col" class="px-6 py-3">Thẻ</th>
                    <th scope="col" class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    v-for="post in posts"
                    :key="post.id"
                >
                    <th
                        scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        {{ post.title }}
                    </th>
                    <td class="px-6 py-4">{{ post.status.name }}</td>
                    <td class="px-6 py-4">{{ post.comments_count }}</td>
                    <td class="px-6 py-4">{{ post.likes_count ? post.likes_count : 0 }}</td>
                    <td class="px-6 py-4">{{ post.views_count ? post.views_count : 0 }}</td>
                    <td class="px-6 py-4">{{ post.user.name }}</td>
                    <td class="px-6 py-4">{{ post.tags.map(tag => tag.name).join(", ") }}</td>
                    <td class="flex items-center px-6 py-4 space-x-3">
                        <button
                            @click="removePost(post.id)"
                            type="button"
                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                        >
                            <i class="bx bx-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";

const posts = ref([])

onMounted(() => {
    fetchData()
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
}

const removePost = async (id) => {
    await axios
            .delete(`/api/dashboard/posts/${id}`)
            .then((response) => {
                posts.value = response.data.posts;
                // console.log(postStatuses);
            })
            .catch((error) => {
                console.log(error);
            });
};
</script>

<style lang="scss" scoped></style>
