<template>
    <div class="container">
        <div class="grid grid-cols-4 gap-x-2 gap-y-5 mx-auto" aria-label="Sidebar">
            <div
                class="px-3 py-1 overflow-y-auto rounded bg-gray-50 dark:bg-gray-800 col-span-4 p-3 h-100 row-span-1 lg:col-span-1 lg:row-span-1 border-r">
                <ul class="space-y-2" id="myTab" data-tabs-toggle="#myTabContent"
                    role="tablist">
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-example"
                            data-collapse-toggle="dropdown-example">
                            <i
                                class='bx bxs-pencil flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white text-lg'></i>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap"
                                sidebar-toggle-item>Bài viết
                                <span
                                    class="inline-flex items-center justify-center w-2 h-2 p-2.5 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">{{
                                        draftPost.length }}</span>
                            </span>
                            <i class='bx bx-chevron-down text-2xl'
                                sidebar-toggle-item></i>
                        </button>
                        <ul id="dropdown-example" class="py-2 space-y-2 ml-7">
                            <li>
                                <button href="#" id="draft-post-tab"
                                    data-tabs-target="#post" type="button"
                                    role="tab" aria-controls="post"
                                    aria-selected="true"
                                    class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11"><i
                                        class="bx bxs-lock-alt text-md pr-3"></i>
                                    Bản nháp <span
                                        class="inline-flex items-center justify-center w-2 h-2 p-2.5 ml-1 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">{{
                                            draftPost.length }}</span>
                                </button>
                            </li>
                            <li>
                                <button href="#" id="draft-post-tab"
                                    data-tabs-target="#post" type="button"
                                    role="tab" aria-controls="post"
                                    aria-selected="true"
                                    class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11"><i
                                        class="bx bx-block text-md pr-3"></i>
                                    Vi phạm
                                </button>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div id="myTabContent"
                class="col-span-4 row-span-1 lg:col-span-3 lg:row-span-3 px-3 py-1">
                <div class="pt-2 rounded-lg dark:bg-gray-800 hidden" id="post"
                    role="tabpanel" aria-labelledby="draft-post-tab">
                    <h2 class="text-gray-800 font-medium text-lg border-b pb-2">Bản
                        nháp</h2>
                    <div v-if="draftPost && draftPost.length > 0" class="mt-3">
                        <div class="py-2 border-b" v-for="post in displayDraftPost"
                            :key="post.id">
                            <div class="flex items-center ">
                                <router-link
                                    :to="{ name: 'PostDetail', params: { id: post.id } }"
                                    class="text-gray-800 text-lg">
                                    <i
                                        class='bx bxs-lock-alt text-emerald-500 text-lg'></i>
                                    {{ post.title }}
                                </router-link>
                                <div class="ml-2">
                                    <router-link
                                        :to="{ name: 'TagDetail', params: { id: tag.pivot.tag_id } }"
                                        class="inline-flex items-center bg-blue-100 text-blue-800 text-xs md:text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 "
                                        v-for="tag in post.tags" :key="tag.slug">{{
                                            tag.name }}</router-link>
                                </div>
                            </div>
                            <div
                                class="mt-1.5 text-sm text-gray-500 flex items-center">
                                <span>Sửa lần cuối: {{ formatDateTime(new
                                    Date(post.updated_at)) }}</span>
                                <div class="relative">
                                    <button class="text-lg ml-1 flex items-center"
                                        @click="showDropDownDraft($event, post.id)">
                                        <i class='bx bx-chevron-down'></i>
                                    </button>
                                    <ul :id="`drop-down-draft-${post.id}`"
                                        class="bg-white shadow-[0_3px_10px_rgb(0,0,0,0.2)] rounded w-28 absolute hidden z-20 drop-down-container">
                                        <router-link
                                            :to="{ name: 'PostEdit', params: { id: post.id } }"
                                            class="py-2 block px-2 hover:bg-blue-100">Sửa</router-link>
                                        <button
                                            @click="deleteDraftPost(post.id, post)"
                                            class="w-full text-left py-2 px-2 hover:bg-blue-100">Xóa</button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="draftPost && draftPost != null && draftPost.length > itemPerPagePost">
                            <v-pagination v-model="pagePost" :pages="totalPagesPost"
                                :range-size="1" active-color="#0074FF"
                                class="my-3 pl-0"
                                @update:modelValue="onPageChanged" />
                        </div>
                    </div>
                    <div v-else>
                        <h4 class="font-semibold text-center text-gray-500 mt-3">
                            Không có gì ở đây cả</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { initFlowbite } from 'flowbite'
import { formatDateTimeFB } from '@/assets/js/app.js'
import axios from 'axios'
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import "@/assets/admin/css/pagination-styles.css";
export default {
    components: {
        VPagination
    },
    data() {
        return {
            draftPost: [],
            itemPerPagePost: 5,
            currentPagePost: 1,
            pagePost: 1
        }
    },
    computed: {
        displayDraftPost() {
            if (this.draftPost && this.draftPost != null) {
                var startIndex = (this.currentPagePost - 1) * this.itemPerPagePost
                var endIndex = startIndex + this.itemPerPagePost
                if (endIndex > this.draftPost.length) {
                    endIndex = this.draftPost.length
                }
                return this.draftPost.slice(startIndex, endIndex)
            }
        },
        totalPagesPost() {
            if (this.draftPost && this.draftPost != null) {
                return Math.ceil(this.draftPost.length / this.itemPerPagePost)
            }
        }
    },
    methods: {
        onPageChanged(page) {
            return this.currentPagePost = page
        },
        fetchData() {
            axios.get(`api/posts/draft/${this.$route.params.id}`)
                .then(res => {
                    // console.log(res.data);
                    this.draftPost = res.data.data
                })
                .catch(err => {
                    console.log(err);
                })
        },
        formatDateTime(date) {
            return formatDateTimeFB(date)
        },
        showDropDownDraft(event, id) {
            event.stopPropagation();
            if ($(`#drop-down-draft-${id}`).first().is(":hidden")) {
                $(`#drop-down-draft-${id}`).slideDown(300);
            } else {
                $(`#drop-down-draft-${id}`).slideUp(300);
            }
        },
        deleteDraftPost(id, item) {
            axios.delete(`api/posts/${id}`)
                .then(res => {
                    this.draftPost = this.draftPost.filter((post) => post.id !== id);
                    if (this.displayDraftPost.length <= 1) {
                        this.currentPagePost = this.totalPagesPost
                        this.pagePost = this.totalPagesPost
                    }
                })
                .catch(err => {
                    console.log(err);
                })
        }
    },
    mounted() {
        initFlowbite()
        this.fetchData()
        $(document).on('click', function (event) {
            if (!$(event.target).closest('.showDropDownDraft').length) {
                $(`.drop-down-container`).slideUp(300);
            }
        });
    }
}
</script>
<style scoped></style>