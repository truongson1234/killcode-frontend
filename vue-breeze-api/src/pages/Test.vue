<template>
<<<<<<< HEAD
    <div>
        <tag-input
            :initial-tags="tags"
            :api-url="'/api/tags/search'"
            @tags-updated="selectedTags = $event"
        ></tag-input>
        <div>Selected tags: {{ selectedTags }}</div>
    </div>
</template>

<script>
import axios from "axios";
import TagInput from "@/components/ui/TagInput.vue";
=======
  <div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Age</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in displayedItems" :key="index">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.age }}</td>
        </tr>
      </tbody>
    </table>
    <v-pagination
      v-model="page"
      :pages="totalPages"
      :range-size="1"
      active-color="#DCEDFF"
      @update:modelValue="onPageChanged"
    />
  </div>
</template>

<script>
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";

>>>>>>> 58c5b7fa3ea70407975e7994381ed19dcc4e8f08
export default {
  components: {
    VPagination,
  },
  data() {
    return {
      items: [
        { id: 1, name: "John", age: 23 },
        { id: 2, name: "Jane", age: 27 },
        { id: 3, name: "Tom", age: 21 },
        { id: 4, name: "Mary", age: 29 },
        { id: 5, name: "Peter", age: 31 },
        { id: 6, name: "Lucy", age: 25 },
        { id: 7, name: "Mike", age: 19 },
        { id: 8, name: "Lisa", age: 33 },
        { id: 9, name: "David", age: 37 },
        { id: 10, name: "Amy", age: 28 }
      ],
      currentPage: 1,
      page:1,
      itemsPerPage: 1,
    };
  },
  computed: {
    // Compute the total number of pages
    totalPages() {
      return Math.ceil(this.items.length / this.itemsPerPage);
    },
<<<<<<< HEAD
    data() {
        return {
            tags: [],
            apiUrl: '/api/tags/search',
            selectedTags: [],
        };
    },
=======
    // Compute the items to show on the current page
    displayedItems() {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.items.slice(startIndex, endIndex);
    },
  },
  methods: {
    onPageChanged(page) {
      this.currentPage = page;
    },
  },
>>>>>>> 58c5b7fa3ea70407975e7994381ed19dcc4e8f08
};
</script>

<style>
/* Table style */
.table {
  border-collapse: collapse;
  width: 100%;
}

.table td,
.table th {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.table th {
  background-color: #f2f2f2;
  font-weight: bold;
}
</style>
