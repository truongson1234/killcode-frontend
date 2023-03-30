<template>
  <div class="post-card p-3">
    <div class="d-flex justify-content-between">
      <div class="post-card__user mb-3">
        <div class="post-card__userImage">
          <img
            src="https://scontent.fhan4-2.fna.fbcdn.net/v/t39.30808-1/258867188_422634896159135_6359898657562207559_n.jpg?stp=c0.0.160.160a_dst-jpg_p160x160&_nc_cat=108&ccb=1-7&_nc_sid=7206a8&_nc_ohc=9QfNSos32BoAX-WYCLq&_nc_ht=scontent.fhan4-2.fna&oh=00_AfBTvEQkSH8MeoiaX9n-l7O4fdgIWM618ET2u967p2vZrQ&oe=642B1761"
            alt="logo-user"
          />
        </div>
        <div class="post-card__userInfo">
          <a href="#">
            {{ data.author.name }}
          </a>
          <span>
            {{ createdAt }}
          </span>
        </div>
      </div>
      <div class="post-card__tags mb-3">
        <a href="#" v-for="(data, index) in data.tags" :key="index">
          {{ data.name }}
        </a>
      </div>
    </div>
    <div class="post-card__text mb-3">
      <router-link :to="{ name: 'PostsDetail', params: { id: data.id } }">
        {{ data.title }}
      </router-link>
    </div>

    <div class="post-card__overview">
      <p>
        <i class="bx bxs-star"></i>
        <span>{{ data.likes }}</span>
      </p>
      <p>
        <i class="bx bxs-comment-dots"></i>
        <span>{{ 0 }}</span>
      </p>
      <p>
        <i class="bx bxs-file-find"></i>
        <span>{{ data.views }}</span>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref,computed } from "vue";
import { useAuthStore } from "@/stores/auth";

const props = defineProps({
  data: Object,
});

const data = props.data;

const createdAt = computed(() => {
  const currentDate = new Date(data.created_at);

  const day = currentDate.getDate().toString().padStart(2, '0');
  const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
  const year = currentDate.getFullYear().toString();

  return `${day}/${month}/${year}`;
});
</script>

<style scoped>
.post-card {
  background: var(--color-dark-mode);
  color: var(--color-light-mode);
  border-radius: 4px;
}
.post-card__tags {
  display: flex;
  align-items: center;
  gap: 10px;
}
.post-card__tags a {
  padding: 2px 12px;
  color: var(--color-dark-mode);
  font-weight: 600;
  text-decoration: none;
  background: var(--color-light-mode);
  border-radius: 4px;
}
.post-card__text a {
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

.post-card__text a::after {
  content: "\201D";
  display: inline;
  color: #999;
}

.post-card__text a::before {
  content: "\201C";
  display: inline;
  color: #999;
}

.post-card__user {
  display: flex;
  flex-direction: row;
  /* border-top: 1px solid #c1c1c1; */
  align-items: center;
}
.post-card__userImage {
  width: 42px;
  height: 42px;
  overflow: hidden;
  border-radius: 50%;
}

.post-card__userInfo {
  display: flex;
  flex-direction: column;
  margin-left: 16px;
}

.post-card__userInfo a {
  color: var(--color-light-mode);
}

.post-card__userInfo span:nth-child(1) {
  font-weight: bold;
  font-size: 14px;
  color: #3f3f55;
}
.post-card__userInfo span:nth-child(2) {
  color: #adada6;
  font-family: sans-serif;
  font-size: 12px;
  margin-top: 2px;
}
.post-card__overview {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px;
}
.post-card__overview p {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 0;
}
.post-card__overview i {
  margin-right: 3px;
}
.post-card__overview span {
  font-size: 13px;
  font-weight: bold;
}
</style>
