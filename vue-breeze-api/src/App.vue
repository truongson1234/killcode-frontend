<template>
  <div>
    <div class="flex items-center justify-center hidden" id="loading">
      <div
        class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite] text-white"
        role="status" style="z-index:102">
        <span
          class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
      </div>
    </div>
    <router-view name="other" />
    <router-view name="admin" />
    <router-view name="user" />
  </div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
const authStore = useAuthStore();
onMounted(async () => {
  await authStore.getToken();
  await authStore.getUser();
});
</script>
<style scoped>
.wrapper {
    color: #000;
    border-radius: 4px;
}

#loading {
    height: 100vh;
    width: 100vw;
    position: absolute;
    z-index: 101;
}

#loading::after {
    content: '';
    position: absolute;
    background-color: rgba(0,0,0,0.5);
    height: 100%;
    width: 100%;
}
</style>