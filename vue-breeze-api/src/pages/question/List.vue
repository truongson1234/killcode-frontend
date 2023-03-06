<template>
    <div class="wrapper container">
        <div class="row">
            <div class="col-12 col-md-9">
                <ask/>
                <div
                    class="pb-3"
                    v-for="(data, index) in QuestionsData"
                    :key="index"
                >
                    <QuestionItem :data="data" />
                </div>
            </div>
            <div class="d-none d-md-block col-md-3">
                <Tagsname />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import QuestionItem from "@/components/ui/QuestionItem.vue";
import Tagsname from "@/components/ui/Tags.vue";
import Ask from "@/components/article/AppAsk.vue";

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
        title: "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corrupti quod molestias nam reiciendis expedita quam reprehenderit, harum ea ex! Aut mollitia ipsa dignissimos at repellendus, commodi incidunt nam vero. Aspernatur.",
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

<style scoped></style>
