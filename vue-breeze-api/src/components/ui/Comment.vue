<template>
    <div class="space-y-2 box-cmt-detail-post relative">
        <div class="absolute tool-comment right-0 top-0"
            v-if="authStore.getInfoUser != null && comment.author.id == authStore.getInfoUser.id">
            <button @click="showToolComment($event, comment.id)"><i class='bx bx-dots-horizontal-rounded'></i></button>
            <ul :id="`drop-down-comment-${comment.id}`"
                class="bg-white shadow-[0_3px_10px_rgb(0,0,0,0.2)] rounded w-28 absolute z-20 hidden drop-down-comment-container">
                <button @click="deletecomment(comment.id)"
                    class="w-full text-left py-2 px-2 hover:bg-blue-100 flex items-center text-sm"><i
                        class='bx bxs-trash-alt pr-1'></i> Xóa</button>
                <button @click="showFormEditComment(comment.id)"
                    class="w-full text-left py-2 px-2 hover:bg-blue-100 flex items-center text-sm"><i
                        class='bx bxs-edit-alt pr-1'></i> Sửa</button>
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
        <div class="prose-container" :class="`prose-${comment.id}`" v-if="!isEditing">
            {{ comment.content }}
        </div>
        <div class="form-edit-comment-container"
            :class="`form-edit-comment-${comment.id}`" v-else>
            <form @submit.prevent="editcomment(comment.id, comment.content), changeOldValue(comment.id)">
                <div class="relative">
                    <input type="text" :id="`default-comment-${comment.id}`"
                        @focus="getOldValue(comment.content)"
                        class="block pl-3 py-3 pr-40 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Nhập tiêu đề bài viết" v-model="comment.content">
                    <button @click="hideFormEditComment(comment.id)"
                        class="text-white absolute right-24 mr-2 bottom-2.5 bg-gray-500 hover:bg-gray-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Hủy</button>
                    <button type="submit"
                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cập
                        nhật</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { useAuthStore } from '@/stores/auth'
export default ({
    props: {
        comment: Object,
        author: Object,
        deletecomment: Function,
        formatdate: Function,
        editcomment: Function,
    },
    data() {
        return {
            authStore: useAuthStore(),
            oldValueComment: '',
            isEditing: false,

        }
    },
    mounted() {
        $(document).on('click', function (event) {
            if (!$(event.target).closest('.showToolComment').length) {
                $(`.drop-down-comment-container`).slideUp(300);
            }
        });
    },
    computed: {
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
        showFormEditComment(id) {
            $(`#default-comment-${id}`).removeClass('focus:ring-red-500 focus:border-red-500 ring-red-500 border-red-500')
            $('.tool-comment').each(function() {
                $(this).addClass('hidden')
            })

            if (this.oldValueComment != '') {
                this.comment.content = this.oldValueComment
            }
            this.isEditing = true;
        },
        hideFormEditComment(id) {
            if (this.oldValueComment != '') {
                this.comment.content = this.oldValueComment
            }
            console.log(this.oldValueComment);
            $('.tool-comment').each(function() {
                $(this).removeClass('hidden')
            })
            this.isEditing = false;
        },
        getOldValue(content) {
            this.oldValueComment = content
        },
        changeOldValue(id) {
            if($(`#default-comment-${id}`).val() != '') {
                this.oldValueComment = $(`#default-comment-${id}`).val()
                this.isEditing = false;
            }
        }
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
