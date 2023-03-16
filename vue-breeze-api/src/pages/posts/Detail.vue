<template>
    <div class="wrapper container">
        <h1 class="text-xl font-bold">
            {{ post.title }}
        </h1>
        <div v-html="post.body"></div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    components: {
    },
    data() {
        return {
            post: {}, // danh sách bài viết
        };
    },
    mounted() {
        // gọi API để lấy danh sách bài viết và thông tin phân trang
        // sau đó cập nhật giá trị của posts, currentPage và totalPages
        this.fetchData(this.$route.params.id);
    },
    methods: {
        fetchData(id) {
            axios.get(`/api/posts/${id}`)
                .then((response) => {
                    this.post = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
