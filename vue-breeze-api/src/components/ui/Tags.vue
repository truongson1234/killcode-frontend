<template>
  <div class="tagname p-3">
    <h4 class="tagname__title text-center mb-3">Tag phổ biến</h4>
    <div class="tagname__list">
      <div class="tagname__item">
        <a href="#">{{ data.name }}</a>
        <span> x {{ data.posts_count }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
const props = defineProps({
    data: Object,
});

const data = props.data;
onMounted(() => {
  console.log(data);
})
</script>

<style scoped>
.tagname{
    background: var(--color-dark-mode);
    border-radius: 4px;
}
.tagname__title{
    color: var(--color-light-mode);
}
.tagname__list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.tagname__item {
}
.tagname__item a {
    display: inline-block;
  padding: 3px 9px;
  color: var(--color-dark-mode);
  font-weight: 600;
  text-decoration: none;
  background: var(--color-light-mode);
  border-radius: 4px;
}
.tagname__item span {
  color: var(--color-light-mode);
  font-weight: 600;
}
</style>
