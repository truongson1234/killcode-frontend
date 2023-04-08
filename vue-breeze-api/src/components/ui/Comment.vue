<template>
    <div class="space-y-2">
        <div class="flex space-x-2">
            <div class="h-8 w-8 rounded-full bg-gray-300"></div>
            <div class="flex-1">
                <div class="font-bold">{{ comment.author.name }}</div>
                <div class="text-gray-500 text-sm">
                    {{ comment.created_at }}
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
    },
};
</script>
