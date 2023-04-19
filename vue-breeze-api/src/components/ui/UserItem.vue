<template>
    <div class="user-item flex items-center px-3">
        <img :src="data.avatar" alt="" class="user-image rounded-full">
        <router-link :to="{ name: 'User', params: {id: data.id} }" class="font-bold text-md text-gray-800 pl-2">{{ data.name }}</router-link>
    </div>
</template>
<script setup>
const props = defineProps({
    data: Object
})
const data = props.data
</script>
<style scoped>
.user-image {
    width: 50px;
    height: 50px;
    object-fit: contain;
}
</style>