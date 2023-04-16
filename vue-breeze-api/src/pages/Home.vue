<template>
    <div class="wrapper container py-10">
        <div class="home row">
            <div class="col-12 col-md-9">
                <div>
                    <div class="flex">
                        <label
                            for="search-dropdown"
                            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
                            >Your</label
                        >
                        <button
                            id="dropdown-button"
                            data-dropdown-toggle="dropdown"
                            class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                            type="button"
                        >
                            {{ searchPayload.sort_by }}
                            <svg
                                aria-hidden="true"
                                class="w-4 h-4 ml-1"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </button>
                        <div
                            id="dropdown"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700"
                        >
                            <ul
                                class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdown-button"
                            >
                                <li>
                                    <button
                                        @click="
                                            changeSortBy(
                                                'latest',
                                                searchPayload
                                            )
                                        "
                                        type="button"
                                        class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                    >
                                        Mới nhất
                                    </button>
                                </li>
                                <li>
                                    <button
                                        @click="
                                            changeSortBy('likes', searchPayload)
                                        "
                                        type="button"
                                        class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                    >
                                        Lượt thích
                                    </button>
                                </li>
                                <li>
                                    <button
                                        @click="
                                            changeSortBy('views', searchPayload)
                                        "
                                        type="button"
                                        class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                    >
                                        Lượt xem
                                    </button>
                                </li>
                                <li>
                                    <button
                                        @click="
                                            changeSortBy(
                                                'comments',
                                                searchPayload
                                            )
                                        "
                                        type="button"
                                        class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                    >
                                        Bình luận
                                    </button>
                                </li>
                                <li>
                                    <button
                                        @click="
                                            changeSortBy(
                                                'interactions',
                                                searchPayload
                                            )
                                        "
                                        type="button"
                                        class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                    >
                                        Tương tác
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="relative w-full">
                            <input
                                v-model="searchPayload.keyword"
                                @keyup="handleSearch(searchPayload, dataRes)"
                                type="search"
                                id="search-dropdown"
                                class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                                placeholder="Tìm kiếm Tags, Bài viết, Câu hỏi..."
                                required
                            />
                            <button
                                type="submit"
                                class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    ></path>
                                </svg>
                                <span class="sr-only">Search</span>
                            </button>
                        </div>
                    </div>
                </div>

                <h1>POSTS</h1>
                <div class="" v-for="post in dataRes.posts" :key="post.id">
                    <h3>{{ post.title }}</h3>
                </div>
                <h1>QUESTIONS</h1>
                <div
                    class=""
                    v-for="question in dataRes.questions"
                    :key="question.id"
                >
                    <h3>{{ question.title }}</h3>
                </div>
                <h1>TAGS</h1>
                <div class="" v-for="tag in dataRes.tags" :key="tag.id">
                    <h3>{{ tag.name }}</h3>
                </div>
            </div>
            <div class="d-none d-md-block col-md-3">
                <p style="color: var(--color-dark-mode)">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    Doloremque accusantium voluptate eligendi. Mollitia dolorem,
                    iusto cupiditate, omnis officia ratione itaque quae amet
                    asperiores, illo laborum at velit illum! Quod, quae! Lorem,
                    ipsum dolor sit amet consectetur adipisicing elit.
                    Doloremque accusantium voluptate eligendi. Mollitia dolorem,
                    iusto cupiditate, omnis officia ratione itaque quae amet
                    asperiores, illo laborum at velit illum! Quod, quae! Lorem,
                    ipsum dolor sit amet consectetur adipisicing elit.
                    Doloremque accusantium voluptate eligendi.
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, onBeforeMount } from "vue";
import { useAuthStore } from "@/stores/auth";
import { pageLoading, pageLoaded } from "@/assets/js/app.js";
import { initFlowbite } from "flowbite";

const authStore = useAuthStore();

const dataRes = ref({
    posts: [],
    questions: [],
    tags: [],
});
const searchPayload = ref({
    keyword: "",
    sort_by: "latest",
});

const changeSortBy = (sortBy, payload) => {
    payload.sort_by = sortBy;
};

const handleSearch = async (payload, res) => {
    await axios
        .get("/api/search", { 
            params: {
                keyword: payload.keyword,
                sort_by: payload.payload
            }
        })
        .then((response) => {
            console.log(response.data);
            res.posts = response.data.posts;
            res.questions = response.data.questions;
            res.tags = response.data.tags;
        })
        .catch((error) => {
            console.log(error);
        });
};

onBeforeMount(() => {
    pageLoading();
});

onMounted(async () => {
    pageLoaded();
    initFlowbite();
});
</script>

<style scoped>
.home__tag-name {
    color: var(--color-dark-mode);
}
</style>
