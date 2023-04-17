<template>
    <div class="wrapper container">
        <div class="row">
            <div class="col-12 col-md-9">
                <div
                    class="pb-3"
                    v-for="(question) in questions"
                    :key="question.id"
                >
                    <QuestionItem :data="question" />
                </div>
            </div>
            <div class="d-none d-md-block col-md-3">
                <Tagsname />
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import QuestionItem from "@/components/ui/QuestionItem.vue";
import Tagsname from "@/components/ui/Tags.vue";
// import Ask from "@/components/article/AppAsk.vue";

const questions = ref([]);

const fetchData = () => {
    axios
        .get("/api/questions")
        .then((response) => {
            response.data.forEach(item => {
                item.author.avatar = 'http://localhost:8000/images/' + item.author.avatar
            });
            questions.value = response.data
            console.log('question', questions.value);
        })
        .catch((error) => {
            console.log(error);
        });
}

onMounted(() => {
    fetchData();
})

</script>

<style scoped></style>
