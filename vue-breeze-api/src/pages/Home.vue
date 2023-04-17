<template>
    <div class="wrapper container py-10">
        <div class="home row">
            <div class="col-12 col-md-9">
                <div>
                    <div class="flex relative">
                        <button
                            @click="showDropdownSearch($event)"
                            id="dropdown-button"
                            data-dropdown-toggle="dropdown"
                            class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                            type="button"
                        >
                            {{ visionTextSortBy }}
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
                            id="dropdown-search"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 absolute left-0 top-12"
                        >
                            <ul
                                class="text-sm text-gray-700 dark:text-gray-200"
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
                                type="search"
                                id="search-dropdown"
                                class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                                placeholder="Tìm kiếm Tags, Bài viết, Câu hỏi..."
                                required
                            />
                            <button @click="handleSearch(searchPayload, dataRes)"
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
import { ref, onMounted, onBeforeMount, computed } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useSearchStore } from "@/stores/search";
import { pageLoading, pageLoaded } from "@/assets/js/app.js";
import router from '@/router';
import { lowerFirst } from "lodash-es";

const authStore = useAuthStore();
const searchStore = useSearchStore();

const dataRes = ref({
    posts: [],
    questions: [],
    tags: [],
});
const searchPayload = ref({
    keyword: "",
    sort_by: "latest",
});
const visionTextSortBy = computed(() => {
    if(searchPayload.value.sort_by == "latest") return "Mới nhất"
    if(searchPayload.value.sort_by == "likes") return "Lượt thích"
    if(searchPayload.value.sort_by == "views") return "Lượt xem"
    if(searchPayload.value.sort_by == "comments") return "Bình luận"
    if(searchPayload.value.sort_by == "interactions") return "Tương tác"
})
const changeSortBy = (sortBy, payload) => {
    payload.sort_by = sortBy;
};

const showDropdownSearch = (event) => {
    event.stopPropagation();
    if ($('#dropdown-search').first().is(":hidden")) {
        $('#dropdown-search').slideDown(300);
    } else {
        $('#dropdown-search').slideUp(300);
    }
}
const handleSearch = async (payload, res) => {
    await axios
        .get("/api/search", { 
            params: {
                keyword: payload.keyword,
                sort_by: payload.payload
            }
        })
        .then((response) => {
            res.posts = response.data.posts;
            res.questions = response.data.questions;
            res.tags = response.data.tags;
            console.log(res);
            searchStore.handleGetDataSearch(res)
        })
        .catch((error) => {
            console.log(error);
        });
};

onBeforeMount(() => {
    pageLoading();
});

onMounted(async () => {
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.showDropdownSearch').length) {
            $('#dropdown-search').slideUp(300);
        }
    });
    pageLoaded();
});
</script>

<style scoped>
.home__tag-name {
    color: var(--color-dark-mode);
}
</style>
