<script setup>
// components
import Navbar from "@/components/layout/Navbar.vue";
import Footer from "@/components/layout/Footer.vue";
import LinkAuth from "@/components/ui/LinkAuth.vue";
</script>

<template>
  <Navbar />
  <LinkAuth/>
  <div class="wrapper container mb-4 py-3 px-3">
    <router-view />
  </div>
  <Footer />
</template>

<style scoped>
.wrapper{
  color: #000;
  background: var(--color-light-mode);
  border-radius: 4px;
  overflow: hidden;
}

</style>
