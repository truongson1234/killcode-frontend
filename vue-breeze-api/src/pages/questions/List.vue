<template>
    <div class="container">
        <div class="grid grid-cols-4 gap-x-2 gap-y-5 mx-auto">
            <div class="col-span-4 row-span-1 lg:col-span-3 lg:row-span-3">
                <div v-for="question in displayQuesitons"
                    :key="question.id">
                    <QuestionItem :data="question"
                        :deleteQuestion="deleteQuestion" />
                </div>
                <div v-if="questions && questions.length > itemPerPage">
                    <v-pagination v-model="pageQuestion" :pages="totalPages"
                    :range-size="1" active-color="#0074FF" class="my-3"
                    @update:modelValue="onPageChanged" />
                </div>
            </div>
            <div
                class="col-span-4 p-3 box-popular_tags h-100 row-span-1 lg:col-span-1 lg:row-span-1">
                <h5 class="text-center pb-3 font-bold text-blue-500 ">Chủ đề phổ biến</h5>
                <div v-for="item in popular_tags" :key="item.id">
                    <div class="mb-2">
                        <a
                            class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ">{{ item.name }}</a>
                        <span>{{ item.questions_count }} câu hỏi</span>
                    </div>
                </div>
            </div>
            <div
                class="col-span-4 p-3 box-popular_tags h-100 row-span-1 lg:col-span-1 lg:row-span-1" v-if="new_questions && new_questions.length != 0">
                <h5 class="text-center pb-3 font-bold text-blue-500">Câu hỏi mới nhất</h5>
                <div v-for="item in new_questions" :key="item.id">
                    <QuestionSidebar :data="item"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, computed } from "vue";
import QuestionItem from "@/components/ui/QuestionItem.vue";
import QuestionSidebar from "@/components/ui/QuestionSidebar.vue";
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import "@/assets/admin/css/pagination-styles.css"
const questions = ref([]);
const popular_tags = ref([]);
const new_questions = ref([]);
const itemPerPage = ref(5), pageQuestion = ref(1), currentPage = ref(1)
const fetchData = () => {
    axios
        .get("/api/questions")
        .then((response) => {
            response.data.data.forEach((item) => {
                item.author.avatar = 'http://localhost:8000/images/' + item.author.avatar
            });
            questions.value = response.data.data
            popular_tags.value = response.data.popular_tags
            new_questions.value = response.data.new_questions
        })
        .catch((error) => {
            console.log(error);
        });
}
const deleteQuestion = async (id_question) => {
    await axios.delete(`api/questions/${id_question}`)
        .then(res => {
            questions.value = questions.value.filter((post) => post.id !== id_question);
            // console.log('ayeah', questions.value);
        })
        .catch(err => {
            console.log(err);
        })
}
const displayQuesitons = computed(() => {
    if (questions.value != null) {
        var startIndex = (currentPage.value - 1) * itemPerPage.value
        var endIndex = startIndex + itemPerPage.value
        if (endIndex > questions.value.length) {
            endIndex = questions.value.length
        }
        return questions.value.slice(startIndex, endIndex)
    }
})
const totalPages = computed(() => {
    if (questions.value != null) {
        return Math.ceil(questions.value.length / itemPerPage.value)
    }
})
const onPageChanged = (page) => {
    return currentPage.value = page
}
onMounted(() => {
    fetchData();
})

</script>

<style scoped>
.box-popular_tags {
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    border-radius: 6px;
}</style>
