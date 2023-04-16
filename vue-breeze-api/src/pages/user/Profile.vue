<template>
    <div>
        <li v-for="(item, index) in postsToShow" :key="listPost[index]">
            <div v-if="index < listPost.length">
                <div style="min-width:50rem">
                    <div>
                        <p>
                            {{
                                formatDateTimeHours(listPost[index].created_at)
                            }}</p>
                        <p>
                            {{
                                formatDateTime(listPost[index].created_at)
                            }}</p>
                    </div>
                    <PostItem :data="listPost[index]" :statusDate="false"
                        :deletePost="deletePost" />
                </div>
            </div>
        </li>
    </div>
</template>