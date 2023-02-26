<template>
  <div class="home row">
    <div class="col-12 col-md-9">
      
      <h3 class="home__tag-name mb-3">Câu hỏi thường gặp</h3>
      <div class="row">
        <div class="col-12 col-md-6 pb-3" v-for="(data,index) in QuestionsData" :key="index">
          <QuestionItem :data="data"/>
        </div>
      </div>
    </div>
    <div class="d-none d-md-block col-md-3">
      <p style="color: var(--color-dark-mode);">
        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Doloremque
        accusantium voluptate eligendi. Mollitia dolorem, iusto cupiditate,
        omnis officia ratione itaque quae amet asperiores, illo laborum at velit
        illum! Quod, quae! Lorem, ipsum dolor sit amet consectetur adipisicing
        elit. Doloremque accusantium voluptate eligendi. Mollitia dolorem, iusto
        cupiditate, omnis officia ratione itaque quae amet asperiores, illo
        laborum at velit illum! Quod, quae! Lorem, ipsum dolor sit amet
        consectetur adipisicing elit. Doloremque accusantium voluptate eligendi.
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import QuestionItem from '@/components/ui/QuestionItem.vue';

const QuestionsData = ref([
  {
    title: "No1 Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni,doloribus?",
    author: 'Sonng Ngu',
    created_at: '26/02/2023',
    tags: [
      'tag1',
      'tag2',
      'tag3',
    ],
    overview: {
      view: 100,
      reply: 10,
      rating: 4
    }
  },
  {
    title: "No1 Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni,doloribus?",
    author: 'Sonng Ngu',
    created_at: '26/02/2023',
    tags: [
      'tag1',
      'tag2',
      'tag3',
    ],
    overview: {
      view: 100,
      reply: 10,
      rating: 4
    }
  },
  {
    title: "No1 Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni,doloribus?",
    author: 'Sonng Ngu',
    created_at: '26/02/2023',
    tags: [
      'tag1',
      'tag2',
      'tag3',
    ],
    overview: {
      view: 100,
      reply: 10,
      rating: 4
    }
  },
  {
    title: "No1 Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni,doloribus?",
    author: 'Sonng Ngu',
    created_at: '26/02/2023',
    tags: [
      'tag1',
      'tag2',
      'tag3',
    ],
    overview: {
      view: 100,
      reply: 10,
      rating: 4
    }
  },
])
</script>

<style scoped>
.home__tag-name{
  color: var(--color-dark-mode);
}
</style>
