<template>
    <div class="space-y-2 box-cmt-detail-post relative">
        <div class="absolute tool-comment right-0 top-0" v-if="comment.author.id == authStore.getInfoUser.id">
            <button><i class='bx bx-dots-horizontal-rounded' @click="showToolComment($event,comment.id)"></i></button>
            <ul :id="`drop-down-comment-${comment.id}`"
                class="bg-white shadow-[0_3px_10px_rgb(0,0,0,0.2)] rounded w-28 absolute z-20 hidden drop-down-comment-container">
                <button
                    @click="deletecomment(comment.id)"
                    class="w-full text-left py-2 px-2 hover:bg-blue-100 flex items-center text-sm"><i class='bx bxs-trash-alt pr-1' ></i> Xóa</button>
                <button
                    class="w-full text-left py-2 px-2 hover:bg-blue-100 flex items-center text-sm"><i class='bx bxs-edit-alt pr-1' ></i> Sửa</button>
            </ul>
        </div>
        <div class="flex space-x-2 items-center">
            <div class="userimage">
                <img :src="author.avatar" alt="">
            </div>
            <div class="flex-1">
                <div class="font-bold text-blue-600">{{ comment.author.name }}</div>
                <div class="text-gray-500 text-sm">
                    {{ formatdate(new Date(comment.created_at)) }}
                </div>
            </div>
        </div>
        <div class="prose" v-html="comment.content"></div>
    </div>
</template>

<script>
import { useAuthStore } from '@/stores/auth'
export default({
    props: {
        comment: Object,
        author: Object,
        deletecomment: Function,
        formatdate: Function,
    },
    data() {
        return {
            authStore: useAuthStore()
        }
    },
    mounted() {
        $(document).on('click', function (event) {
            if (!$(event.target).closest('.showToolComment').length) {
                $(`.drop-down-comment-container`).slideUp(300);
            }
        });
    },
    methods: {
        showToolComment(event, id) {
            event.stopPropagation();
            if ($(`#drop-down-comment-${id}`).first().is(":hidden")) {
                $(`#drop-down-comment-${id}`).slideDown(300);
            } else {
                $(`#drop-down-comment-${id}`).slideUp(300);
            }
        },
    }
});
</script>
<style scoped>
.box-cmt-detail-post {
    padding-bottom: 10px;
    border-bottom: 1px solid #e2e7eb;
    margin-bottom: 10px;
}
.box-cmt-detail-post .userimage {
    width: 40px;
    height: 40px;
    margin-right: 0;
}
</style>
