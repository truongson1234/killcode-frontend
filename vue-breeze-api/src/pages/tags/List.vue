<template>
    <div class="wrapper container py-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
            <div v-for="tag in tags" :key="tag.id" class="col-span-1 bg-gray-200 p-4">
                <TagItem :data="tag" />
            </div>
        </div>
        <pagination
            :current-page="currentPage"
            :total-pages="totalPages"
            @page-changed="onPageChanged"
        />
    </div>
</template>

<script>
import axios from "axios";
import Pagination from "@/components/ui/MyPagination.vue";
import TagItem from "@/components/ui/TagItem.vue";

export default {
    components: {
        TagItem,
        Pagination
    },
    data() {
        return {
            tags: [], // danh sách bài viết
            currentPage: 1,
            totalPages: 3,
        };
    },
    mounted() {
        // gọi API để lấy danh sách bài viết và thông tin phân trang
        // sau đó cập nhật giá trị của posts, currentPage và totalPages
        this.fetchData();
    },
    methods: {
        fetchData() {
            axios
                .get("/api/followed-tags")
                .then((response) => {
                    this.tags = response.data.data;
                    this.currentPage = response.data.currentPage;
                    this.totalPages = response.data.totalPages - 1;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        onPageChanged(page) {
            this.currentPage = page;
            axios
                .get("/api/followed-tags", {
                    params: {
                        page: this.currentPage,
                        perPage: this.totalPages,
                    },
                })
                .then((response) => {
                    this.tags = response.data.data;
                    this.currentPage = response.data.currentPage;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>


