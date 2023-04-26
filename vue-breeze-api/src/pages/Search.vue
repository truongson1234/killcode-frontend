<template>
    <div>

        <!-- This is an example component -->
        <div class="container">
            <div class="flex relative">
                <button @click="showDropdownSearch($event)" id="dropdown-button"
                    data-dropdown-toggle="dropdown-search"
                    class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                    type="button">
                    {{ visionTextSortBy }}
                    <svg aria-hidden="true" class="w-4 h-4 ml-1" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div id="dropdown-search"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 absolute left-0 top-12">
                    <ul class="text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdown-button">
                        <li>
                            <button @click="
                                changeSortBy(
                                    'latest',
                                    searchPayload
                                )
                            " type="button"
                                class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                Mới nhất
                            </button>
                        </li>
                        <li>
                            <button @click="
                                changeSortBy('likes', searchPayload)
                            " type="button"
                                class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                Lượt thích
                            </button>
                        </li>
                        <li>
                            <button @click="
                                changeSortBy('views', searchPayload)
                            " type="button"
                                class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                Lượt xem
                            </button>
                        </li>
                        <li>
                            <button @click="
                                changeSortBy(
                                    'comments',
                                    searchPayload
                                )
                            " type="button"
                                class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                Bình luận
                            </button>
                        </li>
                        <li>
                            <button @click="
                                changeSortBy(
                                    'interactions',
                                    searchPayload
                                )
                            " type="button"
                                class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                Tương tác
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="relative w-full">
                    <input v-model="searchPayload.keyword" type="search"
                        id="search-dropdown"
                        class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                        placeholder="Tìm kiếm Tags, Bài viết, Câu hỏi..."
                        required />
                    <button @click="handleSearch(searchPayload)" type="submit"
                        class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg aria-hidden="true" class="w-5 h-5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                            </path>
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </div>
            <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
                <ul class="flex flex-wrap -mb-px" id="myTab"
                    data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button
                            class="item-tab inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center  border-b-2 dark:text-gray-400 dark:hover:text-gray-300 "
                            id="post-tab" data-tabs-target="#post" type="button"
                            role="tab" aria-controls="post" aria-selected="true">Bài
                            viết</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button
                            class="item-tab inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center  border-b-2 dark:text-gray-400 dark:hover:text-gray-300"
                            id="question-tab" data-tabs-target="#question"
                            type="button" role="tab" aria-controls="question"
                            aria-selected="false">Câu hỏi</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button
                            class="item-tab inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center  border-b-2 dark:text-gray-400 dark:hover:text-gray-300"
                            id="tag-tab" data-tabs-target="#tag" type="button"
                            role="tab" aria-controls="tag" aria-selected="false">Chủ
                            đề</button>
                    </li>
                </ul>
            </div>
            <div id="myTabContent">
                <div class="pt-2 rounded-lg dark:bg-gray-800 hidden" id="post"
                    role="tabpanel" aria-labelledby="post-tab">
                    <div  v-if="dataSearch && dataSearch.posts && dataSearch.posts.length != 0">
                        <div class="flex items-center sort-data mb-2">
                            <label for="">Sắp xếp theo:</label>
                            <select id="countries" class="bg-gray-50 border-0 text-gray-900 text-sm rounded-lg focus:ring-transparent p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" @change="sortPost($event)">
                                <option selected value="new" class="form-select-option py-2">Mới nhất</option>
                                <option value="view" class="form-select-option py-2">Lượt xem nhiều nhất</option>
                                <option value="like" class="form-select-option py-2">Đánh giá nhiều nhất</option>
                                <option value="comment" class="form-select-option py-2">Bình luận nhiều nhất</option>
                            </select>
                        </div>
                        <div>
                            <div v-for="post in displayItemPost" :key="post.id">
                                <PostItem :data="post" :deletePost="deletePost" />
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <h5 class="font-bold text-lg text-gray-500">Không có bài
                            viết nào.</h5>
                    </div>
                    <div
                        v-if="dataSearch && dataSearch.posts && dataSearch.posts.length > itemPerPagePost">
                        <v-pagination v-model="pagePost" :pages="totalPagesPost"
                            :range-size="1" active-color="#0074FF" class="my-3"
                            @update:modelValue="onPageChangedPost" />
                    </div>
                </div>

                <div class="pt-2 rounded-lg dark:bg-gray-800" id="question"
                    role="tabpanel" aria-labelledby="question-tab">
                    <div v-if="dataSearch && dataSearch.questions && dataSearch.questions.length != 0">
                        <div class="flex items-center sort-data mb-2">
                            <label for="">Sắp xếp theo:</label>
                            <select id="countries" class="bg-gray-50 border-0 text-gray-900 text-sm rounded-lg focus:ring-transparent p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" @change="sortQuestion($event)">
                                <option selected value="new" class="form-select-option py-2">Mới nhất</option>
                                <option value="view" class="form-select-option py-2">Lượt xem nhiều nhất</option>
                                <option value="like" class="form-select-option py-2">Đánh giá nhiều nhất</option>
                                <option value="comment" class="form-select-option py-2">Bình luận nhiều nhất</option>
                            </select>
                        </div>
                        <div
                            >
                            <div v-for="question in displayItemQuestion"
                                :key="question.id">
                                <QuestionItem :data="question" :deleteQuestion="deleteQuestion"/>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <h5 class="font-bold text-lg text-gray-500">Không có câu hỏi
                            nào.</h5>
                    </div>
                    <div
                        v-if="dataSearch && dataSearch.questions && dataSearch.questions.length > itemPerPageQuestion">
                        <v-pagination v-model="pageQuestion"
                            :pages="totalPagesQuestion" :range-size="1"
                            active-color="#0074FF" class="my-3"
                            @update:modelValue="onPageChangedQuestion" />
                    </div>
                </div>
                <div class="pt-2 rounded-lg dark:bg-gray-800" id="tag"
                    role="tabpanel" aria-labelledby="tag-tab">
                    <div v-if="dataSearch && dataSearch.tags && dataSearch.tags.length != 0">
                        <div class="flex items-center sort-data mb-2">
                            <label for="">Sắp xếp theo:</label>
                            <select id="countries"
                                class="bg-gray-50 border-0 text-gray-900 text-sm rounded-lg focus:ring-transparent p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                @change="sortTag($event)">
                                <option selected value="new" class="form-select-option py-2">Mới
                                    nhất</option>
                                <option value="question" class="form-select-option py-2">Nhều câu hỏi nhất</option>
                                <option value="post" class="form-select-option py-2">Nhiều bài viết nhất</option>
                                <option value="follower" class="form-select-option py-2">Nhiều người theo dõi nhất</option>
                            </select>
                        </div>
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 grid-cols-1 gap-4 mb-5 list-tag"
                            >
                            <div v-for="tag in displayItemTag" :key="tag.id"
                                class="col-span-1 p-4 rounded item-tag">
                                <TagItem :data="tag" />
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <h5 class="font-bold text-lg text-gray-500">Không có chủ đề
                            nào.</h5>
                    </div>
                    <div
                        v-if="dataSearch && dataSearch.tags && dataSearch.tags.length > itemPerPageTag">
                        <v-pagination v-model="pageTag" :pages="totalPagesTag"
                            :range-size="1" active-color="#0074FF" class="my-3"
                            @update:modelValue="onPageChangedTag" />
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script setup>
import { ref, onMounted, computed } from 'vue'
import { useSearchStore } from '@/stores/search';
import { initFlowbite } from 'flowbite'
import axios from 'axios';
import PostItem from "@/components/ui/PostItem.vue";
import QuestionItem from '@/components/ui/QuestionItem.vue';
import TagItem from '@/components/ui/TagItem.vue';
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import "@/assets/admin/css/pagination-styles.css";
const searchStore = useSearchStore()

const currentPagePost = ref(1), currentPageQuestion = ref(1), currentPageTag = ref(1)
const itemPerPagePost = ref(4), itemPerPageQuestion = ref(4), itemPerPageTag = ref(8)
const pagePost = ref(1), pageQuestion = ref(1), pageTag = ref(1)

const onPageChangedPost = (page) => {
    currentPagePost.value = page
}
const onPageChangedQuestion = (page) => {
    currentPageQuestion.value = page
}
const onPageChangedTag = (page) => {
    currentPageTag.value = page
}
const sortPost = (event) => {
    var key = event.target.value
    if(key == 'view') {
        return dataSearch.value.posts.sort((a,b) => b.views_count - a.views_count)
    }
    if(key == 'new') {
        return dataSearch.value.posts.sort((a,b) => new Date(b.created_at) - new Date(a.created_at))
    }
    if(key == 'like') {
        return dataSearch.value.posts.sort((a,b) => b.likes_count - a.likes_count)
    }
    if(key == 'comment') {
        return dataSearch.value.posts.sort((a,b) => b.comments_count - a.comments_count)
    }
}
const sortQuestion = (event) => {
    var key = event.target.value
    if (key == 'view') {
        return dataSearch.value.questions.sort((a, b) => b.views_count - a.views_count)
    }
    if (key == 'new') {
        return dataSearch.value.questions.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
    }
    if (key == 'like') {
        return dataSearch.value.questions.sort((a, b) => b.likes_count - a.likes_count)
    }
    if (key == 'comment') {
        return dataSearch.value.questions.sort((a, b) => b.comments_count - a.comments_count)
    }
}
const sortTag = (event) => {
    var key = event.target.value
    if (key == 'new') {
        return dataSearch.value.tags.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
    }
    if (key == 'post') {
        return dataSearch.value.tags.sort((a, b) => b.posts_count - a.posts_count)
    }
    if (key == 'question') {
        return dataSearch.value.tags.sort((a, b) => b.questions_count - a.questions_count)
    }
    if (key == 'follower') {
        return dataSearch.value.tags.sort((a, b) => b.followers_count - a.followers_count)
    }
}
const displayItemPost = computed(() => {
    if (dataSearch.value && dataSearch.value.posts && dataSearch.value.posts != null) {
        var startIndex = (currentPagePost.value - 1) * itemPerPagePost.value
        var endIndex = startIndex + itemPerPagePost.value
        if (endIndex > dataSearch.value.posts.length) {
            endIndex = dataSearch.value.posts.length
        }
        return dataSearch.value.posts.slice(startIndex, endIndex)
    }
})
const displayItemTag = computed(() => {
    if (dataSearch.value && dataSearch.value.tags && dataSearch.value.tags != null) {
        var startIndex = (currentPageTag.value - 1) * itemPerPageTag.value
        var endIndex = startIndex + itemPerPageTag.value
        if (endIndex > dataSearch.value.tags.length) {
            endIndex = dataSearch.value.tags.length
        }
        return dataSearch.value.tags.slice(startIndex, endIndex)
    }
})
const displayItemQuestion = computed(() => {
    if (dataSearch.value && dataSearch.value.questions && dataSearch.value.questions != null) {
        var startIndex = (currentPageQuestion.value - 1) * itemPerPageQuestion.value
        var endIndex = startIndex + itemPerPageQuestion.value
        if (endIndex > dataSearch.value.questions.length) {
            endIndex = dataSearch.value.questions.length
        }
        return dataSearch.value.questions.slice(startIndex, endIndex)
    }
})
const totalPagesPost = computed(() => {
    if (dataSearch.value && dataSearch.value.posts && dataSearch.value.posts != null) {
        return Math.ceil(dataSearch.value.posts.length / itemPerPagePost.value)
    }
})
const totalPagesQuestion = computed(() => {
    if (dataSearch.value && dataSearch.value.questions && dataSearch.value.questions != null) {
        return Math.ceil(dataSearch.value.questions.length / itemPerPageQuestion.value)
    }
})
const totalPagesTag = computed(() => {
    if (dataSearch.value && dataSearch.value.tags && dataSearch.value.tags != null) {
        return Math.ceil(dataSearch.value.tags.length / itemPerPageTag.value)
    }
})
const searchPayload = ref({
    keyword: "",
    sort_by: "latest",
});
const dataSearch = ref([])
const visionTextSortBy = computed(() => {
    if (searchPayload.value.sort_by == "latest") return "Mới nhất"
    if (searchPayload.value.sort_by == "likes") return "Lượt thích"
    if (searchPayload.value.sort_by == "views") return "Lượt xem"
    if (searchPayload.value.sort_by == "comments") return "Bình luận"
    if (searchPayload.value.sort_by == "interactions") return "Tương tác"
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
const handleSearch = async (payload) => {
    await searchStore.handleSearch(payload)
    dataSearch.value = searchStore.getDataSearch
};
const deletePost = async (id_post) => {
    await axios.delete(`api/posts/${id_post}`)
        .then(res => {
            dataSearch.value.posts = dataSearch.value.posts.filter((post) => post.id !== id_post);
        })
        .catch(err => {
            console.log(err);
        })
}
const deleteQuestion = async (id_question) => {
    await axios.delete(`api/questions/${id_question}`)
        .then(res => {
            dataSearch.value.questions = dataSearch.value.questions.filter((question) => question.id !== id_question);
        })
        .catch(err => {
            console.log(err);
        })
}
onMounted(() => {
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.showDropdownSearch').length) {
            $('#dropdown-search').slideUp(300);
        }
    });
    initFlowbite()
    dataSearch.value = searchStore.getDataSearch
})
</script>
<style scoped>
.item-tab:not(.text-blue-600) {
    border-color: transparent;
}

.list-tag .item-tag {
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}
</style>