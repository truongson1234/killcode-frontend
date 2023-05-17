<template>
    <div class="wrapper container py-5">
        <div class="mb-4 flex items-center justify-between">
            <h1 class="text-uppercase">Chủ đề ({{ tags.length }})</h1>
            <div class="flex items-center sort-data">
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
        </div>
        <div
            class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 grid-cols-1 gap-4 mb-5 list-tag">
            <div v-for="tag in displayedItems" :key="tag.id"
                class="col-span-1 p-4 rounded item-tag">
                <TagItem :data="tag" />
            </div>
        </div>
        <div v-if="tags.length > itemsPerPageTag">
            <v-pagination v-model="pageTag" :pages="totalPagesTag" :range-size="1"
                active-color="#0074FF" class="my-3"
                @update:modelValue="onPageChanged" />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import TagItem from "@/components/ui/TagItem.vue";
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import "@/assets/admin/css/pagination-styles.css";
import { pageLoading, pageLoaded } from '@/assets/js/app.js'
export default {
    components: {
        TagItem,
        VPagination
    },
    data() {
        return {
            tags: [],
            currentPage: 1,
            pageTag: 1,
            itemsPerPageTag: 8
        };
    },
    created() {
        pageLoading(2000)
    },
    mounted() {
        this.fetchData();
        pageLoaded()
    },
    computed: {
        totalPagesTag() {
            if (this.tags != null) {
                return Math.ceil(this.tags.length / this.itemsPerPageTag);
            }
        },
        displayedItems() {
            if (this.tags != null) {
                var startIndex = (this.currentPage - 1) * this.itemsPerPageTag;
                var endIndex = startIndex + this.itemsPerPageTag;
                if (endIndex > this.tags.length) {
                    endIndex = this.tags.length
                }
                return this.tags.slice(startIndex, endIndex);
            }
        }
    },
    methods: {
        sortTag(event) {
            var key = event.target.value
            if (key == 'new') {
                return this.tags.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
            }
            if (key == 'post') {
                return this.tags.sort((a, b) => b.posts_count - a.posts_count)
            }
            if (key == 'question') {
                return this.tags.sort((a, b) => b.questions_count - a.questions_count)
            }
            if (key == 'follower') {
                return this.tags.sort((a, b) => b.followers_count - a.followers_count)
            }
        },
        fetchData() {
            axios
                .get("/api/followed-tags")
                .then((response) => {
                    this.tags = response.data.data;
                    this.tags.map((tag) => {
                        tag.thumbnail = 'http://localhost:8000/images/tags/' + tag.thumbnail
                    })
                    console.log(this.tags);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        onPageChanged(page) {
            this.currentPage = page;
            // axios
            //     .get("/api/followed-tags", {
            //         params: {
            //             page: this.currentPage,
            //             perPage: this.totalPages,
            //         },
            //     })
            //     .then((response) => {
            //         this.tags = response.data.data;
            //         this.currentPage = response.data.currentPage;
            //     })
            //     .catch((error) => {
            //         console.log(error);
            //     });
        },

    },
};
</script>
<style scoped>
.list-tag .item-tag {
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}</style>

