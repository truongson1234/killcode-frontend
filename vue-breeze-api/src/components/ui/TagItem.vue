<template>
    <div class="bg-gray-200 p-3 flex flex-col items-center">
        <h3 class="text-xl font-bold mb-3">{{ data.name }}</h3>
        <p><span>{{ data.followers_count }} followers</span></p>
        <button @click="toggleFollow(data)" class="py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
            {{ data.is_following ? 'Unfollow' : 'Follow' }}
        </button>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, computed } from "vue";

const props = defineProps({
    data: Object,
});

const data = props.data;

const toggleFollow = async (tag) => {
    try {
        const response = await axios({
            method: tag.is_following ? 'delete' : 'post',
            url: "/api/followed-tags",
            data: {
                tag_id: tag.id,
            },
        });
        if (response.data.status === 1) {
            data.is_following = !tag.is_following;
            data.followers_count = !tag.is_following ? tag.followers_count - 1 : tag.followers_count + 1;
            Swal.fire(response.data.message, "UwU <3", "success");
        }
    } catch (error) {
        console.log(error);
    }
};
</script>

<style scoped></style>
