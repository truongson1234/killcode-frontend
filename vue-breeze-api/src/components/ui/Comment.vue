<template>
    <div class="space-y-2 box-cmt-detail-post">
        <div class="flex space-x-2 items-center">
            <div class="userimage">
                <img :src="author.avatar" alt="">
            </div>
            <div class="flex-1">
                <div class="font-bold text-blue-600">{{ comment.author.name }}</div>
                <div class="text-gray-500 text-sm">
                    {{ formatdate(comment.created_at) }}
                </div>
            </div>
        </div>
        <div class="prose" v-html="comment.content"></div>
    </div>
</template>

<script>
export default {
    props: {
        comment: Object,
        author: Object,
        formatdate: Function
    },
};
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
