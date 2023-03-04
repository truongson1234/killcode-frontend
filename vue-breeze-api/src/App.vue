<script setup> 
  // components
  import Navbar from "@/components/layout/Navbar.vue";
  import Footer from "@/components/layout/Footer.vue";
</script>
<template>
  <main class="relative">
    <div class="flex items-center justify-center hidden" id="loading">
      <div
      class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
      role="status">
        <span
        class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
        >Loading...</span
        >
      </div>
    </div>
    <Navbar />
    <div class="wrapper container mb-4 py-3 px-3">
      <router-view />
    </div>
    <Footer />
  </main>
</template>
<style scoped>
.wrapper{
  color: #000;
  background: var(--color-light-mode);
  border-radius: 4px;
}
#loading {
  height: 100%;
  width: 100%;
  position: absolute;
  z-index: 1000;
}
#loading::after {
  content: '';
  position: absolute;
  background-color: rgba(0,0,0,0.2);
  height: 100%;
  width: 100%;
}
</style>