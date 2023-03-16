<template>
  <div>
    <ul>
      <li v-for="post in posts" :key="post.id">
        {{ post.title }}
      </li>
    </ul>
    <pagination :current-page="currentPage" :total-pages="totalPages"
      @page-changed="onPageChanged" />
  </div>
</template>

<script>
import Pagination from '@/components/ui/MyPagination.vue'
import axios from "axios";

export default {
  components: {
    Pagination
  },
  data() {
    return {
      posts: [], // danh sách bài viết
      currentPage: 1,
      totalPages: 3
    }
  },
  mounted() {
    // gọi API để lấy danh sách bài viết và thông tin phân trang
    // sau đó cập nhật giá trị của posts, currentPage và totalPages
    this.fetchData()
  },
  methods: {
    fetchData() {
      axios.get('/api/posts', {
        params: {
          page: this.currentPage,
          perPage: this.totalPages
        }
      })
        .then(response => {
          this.posts = response.data.data
          this.currentPage = response.data.currentPage
          this.totalPages = response.data.totalPages
        })
        .catch(error => {
          console.log(error)
        })
    },
    onPageChanged(page) {
      this.currentPage = page
      this.fetchData()
    }
  }
}
</script>
