<template>
    <div class="wrapper container py-5">
        <div class="row">
            <div class="col-12 col-md-9">
                <div class="" v-for="post in displayedItems" :key="post.id">
                    <PostItem :data="post" />
                </div>
            </div>
            <div class="d-none d-md-block col-md-3">
                <Tagsname />
            </div>
        </div>
        <v-pagination v-model="pagePost" :pages="totalPagesPost" :range-size="1"
            active-color="#0074FF" class="my-3"
            @update:modelValue="onPageChanged" />
    </div>
</template>

<script>
import axios from "axios";
// import Pagination from "@/components/ui/MyPagination.vue";
import PostItem from "@/components/ui/PostItem.vue";
import Tagsname from "@/components/ui/Tags.vue";
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import "@/assets/admin/css/pagination-styles.css";
export default {
    components: {
        PostItem,
        Tagsname,
        VPagination
    },
    data() {
        return {
            posts: [], // danh sách bài viết
            currentPage: 1,
            pagePost: 1,
            itemsPerPagePost: 3,
        };
    },
    mounted() {
        // gọi API để lấy danh sách bài viết và thông tin phân trang
        // sau đó cập nhật giá trị của posts, currentPage và totalPages
        this.fetchData();
    },
    computed: {
        totalPagesPost() {
            if (this.posts != null) {
                return Math.ceil(this.posts.length / this.itemsPerPagePost);
            }
        },
        displayedItems() {
            if(this.posts != null) {
                var startIndex = (this.currentPage - 1) * this.itemsPerPagePost;
                var endIndex = startIndex + this.itemsPerPagePost;
                if (endIndex > this.posts.length) {
                    endIndex = this.posts.length
                }
                return this.posts.slice(startIndex, endIndex);
            }
        }
    },  
    methods: {
        fetchData() {
            axios
                .get("/api/posts")
                .then((response) => {
                    response.data.data.forEach(item => {
                        item.author.avatar = 'http://localhost:8000/images/' +  item.author.avatar
                    });
                    this.posts = response.data.data;
                    // this.currentPage = response.data.currentPage;
                    // this.totalPages = response.data.totalPages;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        onPageChanged(page) {
            this.currentPage = page;
            // axios
            //     .get("/api/posts", {
            //         params: {
            //             page: this.currentPage,
            //             perPage: this.totalPages,
            //         },
            //     })
            //     .then((response) => {
            //         this.posts = response.data.data;
            //         this.currentPage = response.data.currentPage;
            //     })
            //     .catch((error) => {
            //         console.log(error);
            //     });
        },
    },
};
</script>
