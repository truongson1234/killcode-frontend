<template>
    <div class="py-3 flex items-start">
        <div class="pr-3 flex-thumbnail pt-1">
            <router-link :to="{ name: 'TagDetail', params: { id: data.id } }">
                <img :src="data.thumbnail" alt="" class="thumbnail-tag">
            </router-link>
        </div>
        <div class="flex-content">
            <router-link :to="{ name: 'TagDetail', params: { id: data.id } }"
                class="text-xl font-bold mb-2">{{ data.name }}</router-link>
            <p class="text-gray-500"><span>{{ data.posts_count }} bài viết</span>
            </p>
            <p class="text-gray-500"><span>{{ data.questions_count }} câu hỏi</span>
            </p>
            <p class="text-gray-500"><span>{{ data.followers_count }} người theo
                    dõi</span></p>

            <button @click="toggleFollow(data)"
                class="mt-1 text-sm rounded-sm py-0.5 px-2 text-blue-500 font-semibold hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-none focus:ring-blue-400 focus:ring-opacity-75 transition ease-in-out border-x border-y border-blue-500"
                :class="[data.is_following ? 'bg-blue-700 text-white' : '']">
                <div class="flex items-center justify-between space-x-1">
                    <span class="text-lg" v-html="renderIcon"></span>
                    <span>
                        {{ data.is_following ? 'Đang theo dõi' : 'Theo dõi' }}
                    </span>
                </div>
            </button>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, computed, watch } from "vue";
import router from '@/router';
import { useAuthStore } from "@/stores/auth";
const authStore = useAuthStore();
const props = defineProps({
    data: Object
});

const data = props.data;
const renderIcon = computed(() => {
    return data.is_following
        ? "<i class='bx bx-check'></i>"
        : "<i class='bx bx-plus'></i>";
})
const toggleFollow = async (tag) => {
    try {
        if (authStore.getInfoUser != null) {
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

        } else {
            Swal.fire({
                title: "",
                text: 'Vui lòng đăng nhập để có thể theo dõi chủ đề!',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#aaa8a5",
                confirmButtonText: "Đăng nhập",
                cancelButtonText: "Hủy",
            }).then(result => {
                if (result.isConfirmed) {
                    router.push({ name: 'Login' })
                        .then(() => { router.go() })
                }
            })
        }
    } catch (error) {
        console.log(error);
    }
};
</script>

<style scoped>
.thumbnail-tag {
    width: 60px;
    height: 60px;
    object-fit: contain;
}

</style>
