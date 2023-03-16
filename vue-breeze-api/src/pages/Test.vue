<template>
  <div>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user, index) in paginatedUsers" :key="index">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.phone }}</td>
        </tr>
      </tbody>
    </table>

    <paginate :page-count="pageCount" :click-handler="changePage"
      :prev-text="'Prev'" :next-text="'Next'" :container-class="'pagination'"
      :page-class="'page-item'" :page-link-class="'page-link'"
      :prev-class="'page-item'" :prev-link-class="'page-link'"
      :next-class="'page-item'" :next-link-class="'page-link'"></paginate>
  </div>
</template>

<script>
import Paginate from 'vuejs-paginate';

export default {
  components: {
    Paginate,
  },
  data() {
    return {
      users: [
        { name: 'Alice', email: 'alice@example.com', phone: '555-1234' },
        { name: 'Bob', email: 'bob@example.com', phone: '555-5678' },
        { name: 'Charlie', email: 'charlie@example.com', phone: '555-9012' },
        { name: 'David', email: 'david@example.com', phone: '555-3456' },
        { name: 'Emily', email: 'emily@example.com', phone: '555-7890' },
        { name: 'Frank', email: 'frank@example.com', phone: '555-2345' },
        { name: 'Grace', email: 'grace@example.com', phone: '555-6789' },
        { name: 'Henry', email: 'henry@example.com', phone: '555-0123' },
        { name: 'Isabella', email: 'isabella@example.com', phone: '555-4567' },
        { name: 'Jacob', email: 'jacob@example.com', phone: '555-8901' },
      ],
      currentPage: 1,
      pageSize: 3,
    };
  },
  computed: {
    pageCount() {
      return Math.ceil(this.users.length / this.pageSize);
    },
    paginatedUsers() {
      const start = (this.currentPage - 1) * this.pageSize;
      const end = start + this.pageSize;
      return this.users.slice(start, end)
    }
  },
  methods: {
    changePage(page) {
      this.currentPage = page;
    },
  },

}
</script>
