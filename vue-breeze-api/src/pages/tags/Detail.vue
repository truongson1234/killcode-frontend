<template>
    <div class="container">
        <div class="head" v-if="detailTag != null">
            <TagItemDetail :data="detailTag" />
        </div>
        <div class="grid grid-cols-4 gap-x-2 gap-y-5 mx-auto">
            <div
                class="col-span-4 row-span-1 md:col-span-2 lg:col-span-3 lg:row-span-3">
                <div class="border-b border-gray-200 dark:border-gray-700 mb-2">
                    <ul class="flex flex-wrap -mb-px" id="myTab"
                        data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button
                                class="item-tab inline-block text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-sm font-medium text-center  border-b-2 dark:text-gray-400 dark:hover:text-gray-300 "
                                id="post-tab" data-tabs-target="#post" type="button"
                                role="tab" aria-controls="post"
                                aria-selected="true">Bài
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
                                id="followed-tab" data-tabs-target="#followed"
                                type="button" role="tab" aria-controls="followed"
                                aria-selected="false">Người theo dõi</button>
                        </li>
                    </ul>
                </div>
                <div id="myTabContent">
                    <div class="pt-2 rounded-lg dark:bg-gray-800 hidden" id="post"
                        role="tabpanel" aria-labelledby="post-tab">
                        <div class="flex items-center sort-data mb-1.5" v-if="posts && posts.length != 0">
                            <label for="">Sắp xếp theo:</label>
                            <select id="countries"
                                class="bg-gray-50 border-0 text-gray-900 text-sm rounded-lg focus:ring-transparent p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                @change="sortPost($event)">
                                <option selected value="new"
                                    class="form-select-option py-2">Mới
                                    nhất</option>
                                <option value="view"
                                    class="form-select-option py-2">Lượt xem nhiều
                                    nhất</option>
                                <option value="like"
                                    class="form-select-option py-2">Đánh giá nhiều
                                    nhất</option>
                                <option value="comment"
                                    class="form-select-option py-2">Bình luận
                                    nhiều nhất</option>
                            </select>
                        </div>
                        <div v-if="posts && posts.length != 0">
                            <div v-for="post in displayItemPost" :key="post.id">
                                <PostItem :data="post" :deletePost="deletePost" />
                            </div>
                        </div>
                        <div v-else>
                            <h5 class="font-bold text-lg text-gray-500">Không có bài
                                viết
                                nào.</h5>
                        </div>
                        <div v-if="posts && posts.length > itemPerPagePost">
                            <v-pagination v-model="pagePost" :pages="totalPagesPost"
                                :range-size="1" active-color="#0074FF" class="my-3"
                                @update:modelValue="onPageChangedPost" />
                        </div>
                    </div>
                    <div class="pt-2 rounded-lg dark:bg-gray-800 hidden"
                        id="question" role="tabpanel"
                        aria-labelledby="question-tab">
                        <div class="flex items-center sort-data mb-1.5" v-if="questions && questions.length != 0">
                            <label for="">Sắp xếp theo:</label>
                            <select id="countries"
                                class="bg-gray-50 border-0 text-gray-900 text-sm rounded-lg focus:ring-transparent p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                @change="sortQuestion($event)">
                                <option selected value="new"
                                    class="form-select-option py-2">Mới
                                    nhất</option>
                                <option value="view"
                                    class="form-select-option py-2">Lượt xem nhiều
                                    nhất</option>
                                <option value="like"
                                    class="form-select-option py-2">Đánh giá nhiều
                                    nhất</option>
                                <option value="comment"
                                    class="form-select-option py-2">Bình luận
                                    nhiều nhất</option>
                            </select>
                        </div>
                        <div v-if="questions && questions.length != 0">
                            <div v-for="question in displayItemQuestion"
                                :key="question.id">
                                <QuestionItem :data="question"
                                    :deleteQuestion="deleteQuestion" />
                            </div>
                        </div>
                        <div v-else>
                            <h5 class="font-bold text-lg text-gray-500">Không có câu
                                hỏi
                                nào.</h5>
                        </div>
                        <div>
                            <div
                                v-if="questions && questions.length > itemPerPageQuestion">
                                <v-pagination v-model="pageQuestion"
                                    :pages="totalPagesQuestion" :range-size="1"
                                    active-color="#0074FF" class="my-3"
                                    @update:modelValue="onPageChangedQuestion" />
                            </div>
                        </div>
                    </div>
                    <div class="pt-2 rounded-lg dark:bg-gray-800 hidden"
                        id="followed" role="tabpanel"
                        aria-labelledby="followed-tab">
                        <div class="grid grid-cols-4 gap-y-5"
                            v-if="followeds && followeds.length != 0">
                            <div v-for="followed in displayItemUser"
                                :key="followed.id" class="col-span-1 ">
                                <UserItem :data="followed" />
                            </div>
                        </div>
                        <div v-else>
                            <h5 class="font-bold text-lg text-gray-500">Không có
                                người
                                dùng
                                nào.</h5>
                        </div>
                        <div v-if="followeds && followeds.length > itemPerPageUser"
                            class="mt-2">
                            <v-pagination v-model="pageUser" :pages="totalPagesUser"
                                :range-size="1" active-color="#0074FF" class="my-3"
                                @update:modelValue="onPageChangedUser" />
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="col-span-4 p-3 box-popular_tags h-100 row-span-1 md:col-span-2 lg:col-span-1 lg:row-span-1">
                <h3 class="uppercase relative text-tag-sidebar">tag phổ biến
                </h3>
                <ul v-if="popularTags != null" class="flex flex-wrap mt-3">
                    <router-link :to="{ name: 'TagDetail', params: { id: tag.id } }"
                        v-for="tag in popularTags" :key="tag.id"
                        @click="fetchData(tag.id)" class="mb-2 mr-2  flex">
                        <span class="px-2 py-1 bg-gray-200 rounded-l text-sm">{{
                            tag.name }} </span>
                        <span
                            class="px-2 bg-blue-500 text-white rounded-r text-center text-sm flex items-center">{{
                                tag.posts_count > tag.questions_count ? tag.posts_count
                                : tag.questions_count }}</span>
                    </router-link>
                </ul>

            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from "vue-router";
import { initFlowbite } from 'flowbite';
import axios from 'axios'
import PostItem from '@/components/ui/PostItem.vue'
import QuestionItem from '@/components/ui/QuestionItem.vue'
import UserItem from '@/components/ui/UserItem.vue'
import TagItemDetail from '@/components/ui/TagItemDetail.vue'
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import "@/assets/admin/css/pagination-styles.css";
import { pageLoading, pageLoaded } from '@/assets/js/app'
const route = useRoute();
const tagId = route.params.id;
const detailTag = ref(null), posts = ref(null), questions = ref(null), followeds = ref(null), countPost = ref(0), countQuestion = ref(0), countFollower = ref(0), popularTags = ref(null)
const currentPagePost = ref(1), currentPageQuestion = ref(1), currentPageUser = ref(1)
const itemPerPagePost = ref(5), itemPerPageQuestion = ref(5), itemPerPageUser = ref(10)
const pagePost = ref(1), pageQuestion = ref(1), pageUser = ref(1)

const onPageChangedPost = (page) => {
    currentPagePost.value = page
}
const onPageChangedQuestion = (page) => {
    currentPageQuestion.value = page
}
const onPageChangedUser = (page) => {
    currentPageUser.value = page
}
const displayItemPost = computed(() => {
    if (posts.value && posts.value != null) {
        var startIndex = (currentPagePost.value - 1) * itemPerPagePost.value
        var endIndex = startIndex + itemPerPagePost.value
        if (endIndex > posts.value.length) {
            endIndex = posts.value.length
        }
        return posts.value.slice(startIndex, endIndex)
    }
})
const displayItemUser = computed(() => {
    if (followeds.value && followeds.value != null) {
        var startIndex = (currentPageUser.value - 1) * itemPerPageUser.value
        var endIndex = startIndex + itemPerPageUser.value
        if (endIndex > followeds.value.length) {
            endIndex = followeds.value.length
        }

        return followeds.value.slice(startIndex, endIndex)
    }
})
const displayItemQuestion = computed(() => {
    if (questions.value && questions.value != null) {
        var startIndex = (currentPageQuestion.value - 1) * itemPerPageQuestion.value
        var endIndex = startIndex + itemPerPageQuestion.value
        if (endIndex > questions.value.length) {
            endIndex = questions.value.length
        }
        return questions.value.slice(startIndex, endIndex)
    }
})
const totalPagesPost = computed(() => {
    if (posts.value && posts.value && posts.value != null) {
        return Math.ceil(posts.value.length / itemPerPagePost.value)
    }
})
const totalPagesQuestion = computed(() => {
    if (questions.value && questions.value && questions.value != null) {
        return Math.ceil(questions.value.length / itemPerPageQuestion.value)
    }
})
const totalPagesUser = computed(() => {
    if (followeds.value && followeds.value && followeds.value != null) {
        return Math.ceil(followeds.value.length / itemPerPageUser.value)
    }
})
const fetchData = async (id = tagId) => {
    await axios.get(`api/followed-tags/${id}`)
        .then(res => {
            detailTag.value = res.data.data[0]
            // console.log(detailTag.value);
            detailTag.value.thumbnail = 'http://localhost:8000/images/tags/' + detailTag.value.thumbnail
        })
        .catch(err => {
            console.log(err);
        })
    await axios.get(`api/tags/${id}`)
        .then((res) => {
            popularTags.value = res.data.popular_tags
            posts.value = res.data.posts
            questions.value = res.data.questions
            followeds.value = res.data.followeds
            countPost.value = res.data.post_count
            countQuestion.value = res.data.question_count
            countFollower.value = res.data.followers
            console.log(popularTags.value);
        })
        .catch((err) => {
            console.log(err);
        })
}

const deletePost = (id_post) => {
    Swal.fire({
        title: "",
        text: `Bạn có chắc muốn xóa bài viết này?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy",
    }).then(res => {
        if (res.isConfirmed) {
            axios.delete(`api/posts/${id_post}`)
                .then(res => {
                    posts.value = posts.value.filter((post) => post.id !== id_post);
                    if (displayItemPost.value.length <= 1) {
                        currentPagePost.value = totalPagesPost.value
                        pagePost.value = totalPagesPost.value
                    }
                })
                .catch(err => {
                    console.log(err);
                })
        }
    })
}
const deleteQuestion = (id_question) => {
    Swal.fire({
        title: "",
        text: `Bạn có chắc muốn xóa câu hỏi này?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy",
    }).then(res => {
        if (res.isConfirmed) {
            axios.delete(`api/questions/${id_question}`)
                .then(res => {
                    questions.value = questions.value.filter((question) => question.id !== id_question);
                    if (displayItemQuestion.value.length <= 1) {
                        currentPageQuestion.value = totalPagesQuestion.value
                        pageQuestion.value = totalPagesQuestion.value
                    }
                })
                .catch(err => {
                    console.log(err);
                })
        }
    })
}
const sortQuestion = (event) => {
    var key = event.target.value
    if (key == 'view') {
        return questions.value.sort((a, b) => b.views_count - a.views_count)
    }
    if (key == 'new') {
        return questions.value.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
    }
    if (key == 'like') {
        return questions.value.sort((a, b) => b.likes_count - a.likes_count)
    }
    if (key == 'comment') {
        return questions.value.sort((a, b) => b.comments_count - a.comments_count)
    }
}
const sortPost = (event) => {
    var key = event.target.value
    if (key == 'view') {
        return posts.value.sort((a, b) => b.views_count - a.views_count)
    }
    if (key == 'new') {
        return posts.value.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
    }
    if (key == 'like') {
        return posts.value.sort((a, b) => b.likes_count - a.likes_count)
    }
    if (key == 'comment') {
        return posts.value.sort((a, b) => b.comments_count - a.comments_count)
    }
}
onMounted(async () => {
    pageLoading()
    initFlowbite()
    await fetchData()
    pageLoaded()
})
</script>

<style scoped>
.text-tag-sidebar:after {
    position: absolute;
    content: '';
    width: 48%;
    bottom: 0;
    right: 0;
    height: 1px;
    background-color: #e2e7eb;
}

.item-tab:not(.text-blue-600) {
    border-color: transparent;
}

.list-tag .item-tag {
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}</style>