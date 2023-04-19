<template>
    <div class="p-3">
        <router-link :to="{ name: 'TagDetail', params: { id: data.id } }"
            class="text-xl font-bold mb-2 text-gray-800">{{ data.name }}</router-link>
        <p></p>
        <div class="" style="max-width: 25rem;">
            <p class="text-gray-500 text-sm"><span class="text-gray-900 text-lg">{{ data.posts_count }}</span> Bài viết
            </p>
            <p class="text-gray-500 text-sm"><span class="text-gray-900 text-lg">{{ data.questions_count }}</span>  Câu hỏi
            </p>
            <p class="text-gray-500 text-sm"><span class="text-gray-900 text-lg">{{ data.followers_count }}</span> Người theo dõi</p> 
        </div>
        <button @click="toggleFollow(data)"
            class="mt-1 text-sm rounded-sm py-0.5 px-2 text-blue-500 font-semibold hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-none focus:ring-blue-400 focus:ring-opacity-75 transition ease-in-out border-x border-y border-blue-500"
            :class="[data.is_following ? 'bg-blue-700 text-white' : '']">
            <div class="flex items-center justify-between space-x-1">
                <span class="text-lg" v-if="data.is_following"><i
                        class='bx bx-check'></i></span>
                <span class="text-lg" v-else><i class='bx bx-plus'></i></span>
                <span>
                    {{ data.is_following ? 'Đang theo dõi' : 'Theo dõi' }}
                </span>
            </div>
        </button>
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

const data = ref(props.data);
watch(() => props.data, (newValue) => {
    data.value = newValue
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

<style scoped></style>
