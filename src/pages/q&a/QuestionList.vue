<template>
  <div class="row">
    <div class="col-12 col-md-9">
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
</template>

<script setup>
import { ref } from "vue";
import QuestionItem from "@/components/ui/QuestionItem.vue";
import Tagsname from "@/components/ui/Tags.vue";

const QuestionsData = ref([
  {
    title:
      "No1 Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni,doloribus?",
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
    title:
      "No1 Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni,doloribus?",
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
    title:
      "No1 Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni,doloribus?",
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
    title:
      "No1 Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni,doloribus?",
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
