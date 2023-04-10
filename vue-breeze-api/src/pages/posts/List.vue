<template>
    <div class="wrapper container py-5">
        <div class="row">
            <div class="col-12 col-md-9">
                <div class="pb-3" v-for="post in posts" :key="post.id">
                    <PostItem :data="post" />
                </div>
            </div>
            <div class="d-none d-md-block col-md-3">
                <Tagsname />
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
import PostItem from "@/components/ui/PostItem.vue";
import Tagsname from "@/components/ui/Tags.vue";

export default {
    components: {
        Pagination,
        PostItem,
        Tagsname
    },
    data() {
        return {
            posts: [], // danh sách bài viết
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
                .get("/api/posts", {
                    params: {
                        page: this.currentPage,
                        perPage: this.totalPages,
                    },
                })
                .then((response) => {
                    response.data.data.forEach(item => {
                        item.author.avatar = 'http://localhost:8000/images/' +  item.author.avatar
                        console.log(item);
                    });
                    this.posts = response.data.data;
                    this.currentPage = response.data.currentPage;
                    this.totalPages = response.data.totalPages;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        onPageChanged(page) {
            this.currentPage = page;
            axios
                .get("/api/posts", {
                    params: {
                        page: this.currentPage,
                        perPage: this.totalPages,
                    },
                })
                .then((response) => {
                    this.posts = response.data.data;
                    this.currentPage = response.data.currentPage;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
