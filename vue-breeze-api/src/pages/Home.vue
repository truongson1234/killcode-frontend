<template>
    <div class="wrapper container py-10">
        <div class="home row">
            <div class="col-12 col-md-9">
                <h3 class="home__tag-name mb-3 text-center">
                    Câu hỏi thường gặp
                </h3>
                <div class="row">
                    <div v-if="authStore.user">
                        <h1>{{ authStore.user.name }}</h1>
                        <h1>{{ authStore.user.email }}</h1>
                        <h1>{{ authStore.user.email_verified_at }}</h1>
                    </div>
                    <div v-else>
                        <h1>Go and Login</h1>
                    </div>
                    <div class="col-12 col-md-6 pb-3"
                        v-for="(data, index) in QuestionsData" :key="index">
                        <QuestionItem :data="data" />
                    </div>
                </div>
                <h3 class="home__tag-name mb-3 text-center">
                    Bài viết nổi bật nổi bật
                </h3>
            </div>
            <div class="d-none d-md-block col-md-3">
                <p style="color: var(--color-dark-mode)">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    Doloremque accusantium voluptate eligendi. Mollitia dolorem,
                    iusto cupiditate, omnis officia ratione itaque quae amet
                    asperiores, illo laborum at velit illum! Quod, quae! Lorem,
                    ipsum dolor sit amet consectetur adipisicing elit.
                    Doloremque accusantium voluptate eligendi. Mollitia dolorem,
                    iusto cupiditate, omnis officia ratione itaque quae amet
                    asperiores, illo laborum at velit illum! Quod, quae! Lorem,
                    ipsum dolor sit amet consectetur adipisicing elit.
                    Doloremque accusantium voluptate eligendi.
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import QuestionItem from "@/components/ui/QuestionItem.vue";
import { useAuthStore } from "@/stores/auth";
const authStore = useAuthStore();
onMounted(async () => {
    await $('#loading').removeClass('hidden')
    await authStore.getUser();
    await setTimeout(() => {
        $('#loading').addClass('hidden')
    }, 1000)

});
const QuestionsData = ref([
    {
        id: 1,
        title: "No1 Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni,doloribus?",
        author: "Sonng Ngu",
        created_at: "26/02/2023",
        tags: ["tag1", "tag2", "tag3"],
        overview: {
            view: 100,
            reply: 10,
            rating: 4,
        },
    },
    {
        id: 2,
        title: "No1 Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni,doloribus?",
        author: "Sonng Ngu",
        created_at: "26/02/2023",
        tags: ["tag1", "tag2", "tag3"],
        overview: {
            view: 100,
            reply: 10,
            rating: 4,
        },
    },
    {
        id: 3,
        title: "No1 Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni,doloribus?",
        author: "Sonng Ngu",
        created_at: "26/02/2023",
        tags: ["tag1", "tag2", "tag3"],
        overview: {
            view: 100,
            reply: 10,
            rating: 4,
        },
    },
    {
        id: 4,
        title: "No1 Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni,doloribus?",
        author: "Sonng Ngu",
        created_at: "26/02/2023",
        tags: ["tag1", "tag2", "tag3"],
        overview: {
            view: 100,
            reply: 10,
            rating: 4,
        },
    },
]);
</script>

<style scoped>
.home__tag-name {
    color: var(--color-dark-mode);
}
</style>
