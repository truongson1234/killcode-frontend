<template>
  <div class="question-card p-3">
    <div class="d-flex justify-content-between">
      <div class="question-card__user mb-3">
        <div class="question-card__userImage">
          <img
            src=""
            alt="logo-user"
          />
        </div>
        <div class="question-card__userInfo">
          <a href="#">
            {{ question.author.name }}
          </a>
          <span>
            {{ question.created_at }}
          </span>
        </div>
      </div>
      <div class="question-card__tags mb-3">
        <a href="#" v-for="(tag) in question.tags" :key="tag.pivot.tag_id">
          {{ tag.name }}
        </a>
      </div>
    </div>
    <div class="question-card__text mb-3">
      <router-link :to="{ name: 'QuestionDetail', params: { id: question.id } }">
        {{ question.title }}
      </router-link>
    </div>

    <div class="question-card__overview">
      <p>
        <i class="bx bxs-star"></i>
        <span>{{ question.likes }}</span>
      </p>
      <!-- <p>
        <i class="bx bxs-comment-dots"></i>
        <span>{{ question.overview.reply }}</span>
      </p> -->
      <p>
        <i class="bx bxs-file-find"></i>
        <span>{{ question.views }}</span>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
  data: Object,
});

const question = props.data;
</script>

<style scoped>
.question-card {
  background: var(--color-dark-mode);
  color: var(--color-light-mode);
  border-radius: 4px;
}
.question-card__tags {
  display: flex;
  align-items: center;
  gap: 10px;
}
.question-card__tags a {
  padding: 2px 12px;
  color: var(--color-dark-mode);
  font-weight: 600;
  text-decoration: none;
  background: var(--color-light-mode);
  border-radius: 4px;
}
.question-card__text a {
  font-size: 20px;
  font-family: "Vollkorn", serif;
  font-weight: 400;
  text-decoration: none;
  color: var(--color-light-mode);
  text-align: left;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.question-card__text a::after {
  content: "\201D";
  display: inline;
  color: #999;
}

.question-card__text a::before {
  content: "\201C";
  display: inline;
  color: #999;
}

.question-card__user {
  display: flex;
  flex-direction: row;
  /* border-top: 1px solid #c1c1c1; */
  align-items: center;
}
.question-card__userImage {
  width: 42px;
  height: 42px;
  overflow: hidden;
  border-radius: 50%;
}

.question-card__userInfo {
  display: flex;
  flex-direction: column;
  margin-left: 16px;
}

.question-card__userInfo a {
  color: var(--color-light-mode);
}

.question-card__userInfo span:nth-child(1) {
  font-weight: bold;
  font-size: 14px;
  color: #3f3f55;
}
.question-card__userInfo span:nth-child(2) {
  color: #adada6;
  font-family: sans-serif;
  font-size: 12px;
  margin-top: 2px;
}
.question-card__overview {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px;
}
.question-card__overview p {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 0;
}
.question-card__overview i {
  margin-right: 3px;
}
.question-card__overview span {
  font-size: 13px;
  font-weight: bold;
}
</style>
