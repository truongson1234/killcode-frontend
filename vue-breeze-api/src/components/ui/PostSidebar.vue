<template>
    <div class="mb-2 border-b border-gray-300">
        <router-link :to="{ name: 'PostDetail', params: {id: data.id}}" class="text-gray-800 tile-post hover:text-blue-500">{{ data.title }}</router-link>
        <div class="engagements flex items-center text-xs py-1">
            <span class="engagements-text">10
                <i class='bx bx-like fa-fw fa-lg m-r-3'></i></span>
            <span class="engagements-text">21 <i
                    class='bx bx-show fa-fw fa-lg m-r-3'></i></span>
            <span class="engagements-text">21 <i
                    class="bx bx-comment-detail fa-fw fa-lg m-r-3"></i></span>
        </div>
        <router-link :to="{ name: 'User', params: {id: data.author.id}}" class="text-sm">{{ data.author.name }}</router-link>
    </div>
</template>
<script setup>
const props = defineProps({
  data: Object
});

const data = props.data;
</script>
<style scoped>
.tile-post {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>