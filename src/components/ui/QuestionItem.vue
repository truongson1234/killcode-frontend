<template>
  <div class="question-card p-3">
    <div class="d-flex justify-content-between">
      <div class="question-card__user mb-3">
        <div class="question-card__userImage">
          <img
            src="https://scontent.fhan4-2.fna.fbcdn.net/v/t1.6435-9/149299062_232989691790324_2796829381264086336_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=09cbfe&_nc_ohc=xSgUwUshPDIAX_YWlPi&_nc_ht=scontent.fhan4-2.fna&oh=00_AfATcRKgKC6HOtrIudxtwXaQj0z7TlcyK_SPiDv43zMjSA&oe=6421D58C"
            alt="logo-user"
          />
        </div>
        <div class="question-card__userInfo">
          <a href="#">
            {{ question.author }}
          </a>
          <span>
            {{ question.created_at }}
          </span>
        </div>
      </div>
      <div class="question-card__tags mb-3">
        <a href="#" v-for="(data, index) in question.tags" :key="index">
          {{ data }}
        </a>
      </div>
    </div>
    <div class="question-card__text mb-3">
      <a href="#">
        {{ question.title }}
      </a>
    </div>

    <div class="question-card__overview">
      <p>
        <i class="bx bxs-star"></i>
        <span>{{ question.overview.rating }}</span>
      </p>
      <p>
        <i class="bx bxs-comment-dots"></i>
        <span>{{ question.overview.reply }}</span>
      </p>
      <p>
        <i class="bx bxs-file-find"></i>
        <span>{{ question.overview.view }}</span>
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
  text-align: justify;
  text-decoration: none;
  color: var(--color-light-mode);
  text-align: left;
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
