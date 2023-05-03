<template>
    <div class="container">
        <div class="flex items-center sort-data">
            <label for="">Sắp xếp theo:</label>
            <select id="countries" class="bg-gray-50 border-0 text-gray-900 text-sm rounded-lg focus:ring-transparent p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" @change="sortPost($event)">
                <option selected value="new" class="form-select-option py-2">Mới nhất</option>
                <option value="view" class="form-select-option py-2">Lượt xem nhiều nhất</option>
                <option value="like" class="form-select-option py-2">Đánh giá nhiều nhất</option>
                <option value="comment" class="form-select-option py-2">Bình luận nhiều nhất</option>
            </select>
        </div>
        <div class="grid grid-cols-4 gap-x-2 gap-y-5 mx-auto">
            <div class="col-span-4 row-span-1 lg:col-span-3 lg:row-span-3">
                <div class="" v-for="post in displayedItems" :key="post.id">
                    <PostItem :data="post" :deletePost="deletePost" />
                </div>
                <div v-if="posts.length > itemsPerPagePost">
                    <v-pagination v-model="pagePost" :pages="totalPagesPost"
                        :range-size="1" active-color="#0074FF" class="my-3"
                        @update:modelValue="onPageChanged" />
                </div>
            </div>
            <div
                class="col-span-4 p-3 box-popular_tags h-100 row-span-1 lg:col-span-1 lg:row-span-1">
                <h5 class="text-center pb-3 font-bold text-blue-500 ">Chủ đề phổ biến</h5>
                <div v-for="item in popular_tags" :key="item.id">
                    <div class="mb-2">
                        <a
                            class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ">{{ item.name }}</a>
                        <span>{{ item.posts_count }} bài viết</span>
                    </div>
                </div>
            </div>
            <div
                class="col-span-4 p-3 box-popular_tags h-100 row-span-1 lg:col-span-1 lg:row-span-1" v-if="related_posts && related_posts.length != 0">
                <h5 class="text-center pb-3 font-bold text-blue-500">Bài viết liên quan</h5>
                <div v-for="item in related_posts" :key="item.id">
                    <PostSidebar :data="item"/>
                </div>
            </div>
            <div
                class="col-span-4 p-3 box-popular_tags h-100 row-span-1 lg:col-span-1 lg:row-span-1" v-if="new_posts && new_posts.length != 0">
                <h5 class="text-center pb-3 font-bold text-blue-500">Bài viết mới nhất</h5>
                <div v-for="item in new_posts" :key="item.id">
                    <PostSidebar :data="item"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import PostItem from "@/components/ui/PostItem.vue";
import PostSidebar from '@/components/ui/PostSidebar.vue'
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import "@/assets/admin/css/pagination-styles.css";
export default {
    components: {
        PostItem,
        VPagination,
        PostSidebar
    },
    data() {
        return {
            posts: [], // danh sách bài viết
            popular_tags: [], //*Danh sách tag phổ biến
            currentPage: 1,
            related_posts: [], //Danh sách các bài viết liên quan
            new_posts: [], //Danh sách các bài viết mới nhất
            pagePost: 1,
            itemsPerPagePost: 5,
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
            if (this.posts != null) {
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
        sortPost(event){
            var key = event.target.value
            if(key == 'view') {
                return this.posts.sort((a,b) => b.views_count - a.views_count)
            }
            if(key == 'new') {
                return this.posts.sort((a,b) => new Date(b.created_at) - new Date(a.created_at))
            }
            if(key == 'like') {
                return this.posts.sort((a,b) => b.likes_count - a.likes_count)
            }
            if(key == 'comment') {
                return this.posts.sort((a,b) => b.comments_count - a.comments_count)
            }
        },
        deletePost(id_post) {
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
                            this.posts = this.posts.filter((post) => post.id !== id_post);
                        })
                        .catch(err => {
                            console.log(err);
                        })
                }
            })
        },
        fetchData() {
            axios
                .get("/api/posts")
                .then((response) => {
                    this.posts = response.data.data;
                    this.popular_tags = response.data.popular_tags;
                    this.related_posts = response.data.related_posts;
                    this.new_posts = response.data.new_posts;
                    // console.log(this.related_posts);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        onPageChanged(page) {
            this.currentPage = page;
        },
    },
};
</script>
<style scoped>
.box-popular_tags {
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    border-radius: 6px;
}</style>
