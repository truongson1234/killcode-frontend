<template>
  <div class="row">
    <div class="col-12 col-md-9">
      
      <h3 class="text-light mb-3">Câu hỏi thường gặp</h3>
      <div class="row">
        <PostItem/>
        <PostItem/>
        <PostItem/>

        <PostItem/>
        <PostItem/>
        <PostItem/>
      </div>
    </div>
    <div class="d-none d-md-block col-md-3">
      <p>
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
import PostItem from '@/components/ui/PostItem.vue';
</script>

<style scoped></style>
