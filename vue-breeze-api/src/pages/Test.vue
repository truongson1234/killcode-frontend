<<<<<<< HEAD
<template>
  <div>
    <ul>
      <li v-for="post in posts" :key="post.id">
        {{ post.title }}
      </li>
    </ul>
    <pagination :current-page="currentPage" :total-pages="totalPages" @page-changed="onPageChanged" />
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
=======
<script setup>
import { ref, watch, onMounted, computed } from 'vue'
import { useRolesStore } from '@/stores/roles.js'
import "bootstrap-table/dist/bootstrap-table.min.css";
import "bootstrap-table/dist/bootstrap-table.min.js";
const data_ = [
    {
        id: 1,
        name: 'John',
        price: '123-456-7890'
    },
    {
        id: 2,
        name: 'AD',
        price: '456-789-1230'
    },
]
onMounted(() => {
    $("#table123").bootstrapTable({
        data: data_,
    });
})
</script>
<template>
    <div>
        <table id="table123" data-toggle="table" >
            <thead>
                <tr>
                    <th data-field="id" data-sortable="true">ID</th>
                    <th data-field="name" data-sortable="true">Item Name</th>
                    <th data-field="price" data-sortable="true">Item Price</th>
                </tr>
            </thead>
        </table>
    </div>
</template>
>>>>>>> 9f7b871dd300de59b0e112419475c276443606d3
