<template>
    <div class="p-3">
        <h3 class="text-xl font-bold mb-2">{{ data.name }}</h3>
        <p class="text-gray-500"><span>{{ data.followers_count }} bài viết</span></p>
        <p class="text-gray-500"><span>{{ data.followers_count }} câu hỏi</span></p>
        <p class="text-gray-500"><span>{{ data.followers_count }} người theo dõi</span></p>
        <button @click="toggleFollow(data)" class="mt-1 text-sm rounded-sm py-0.5 px-2 text-blue-500 font-semibold hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-none focus:ring-blue-400 focus:ring-opacity-75 transition ease-in-out border-x border-y border-blue-500" :class="[ data.is_following ? 'bg-blue-700 text-white' : '']">
            <div class="flex items-center justify-between space-x-1">
                <span v-html="renderIcon" class="text-lg"></span>
                <span>
                    {{ data.is_following ? 'Đang theo dõi' : 'Theo dõi' }}
                </span>
            </div>
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

const renderIcon = computed(() => {
    return data.is_following
    ? "<i class='bx bx-check'></i>"
    : "<i class='bx bx-plus'></i>";
})
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
            // Swal.fire(response.data.message, "UwU <3", "success");
        }
    } catch (error) {
        console.log(error);
    }
};
</script>

<style scoped>

</style>
