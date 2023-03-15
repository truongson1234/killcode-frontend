<template>
    <div class="wrapper container">
        <div v-if="data">
            <h1 class="text-xl font-bold">
                {{ data.title }}
            </h1>
            <div v-html="data.body"></div>
        </div>
        
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, computed } from 'vue';
import { useRoute } from 'vue-router'
import { usePostStore } from "@/stores/posts";

const route = useRoute();

const post = ref({})

const fetchPost = async (id) => {
    const response = await axios.get(`/api/posts/${id}`)
    this.post = response.data
}

fetchPost(route.params.id)
</script>

<style scoped>

</style>