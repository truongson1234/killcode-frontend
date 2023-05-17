<template>
    <div class="user-item px-3 text-center">
        <div class="user-image">
            <img :src="data.avatar" alt="" class="">
        </div>
        <router-link :to="{ name: 'Profile', params: {id: data.id} }"
            class="font-bold text-md text-gray-800 pl-2">{{ data.name
                        }}</router-link>
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
    object-fit: cover;
    display: flex;
    align-items: center;
    overflow: hidden;
    border-radius: 50%;
    margin: auto;
}
.user-image img {
    max-width: 100%;
    height: auto;
}
</style>