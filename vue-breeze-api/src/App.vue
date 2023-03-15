<script setup> 
  import { useRoute } from 'vue-router';
  // components
  import Navbar from "@/components/layout/Navbar.vue";
  import Footer from "@/components/layout/Footer.vue";

  const router = useRoute();
  const showNavbar = () => {
    const list = [
      'Main',
      'Login',
      'Register',
      'ForgotPassword',
      'PasswordReset',
      'SendVerifyEmail',
      'Dashboard'
    ]
    return !list.includes(router.name);
  }
  const showFooter = () => {
    const list = [
      'Main',
      'Login',
      'Register',
      'ForgotPassword',
      'PasswordReset',
      'SendVerifyEmail',
      'Dashboard'
    ]
    return !list.includes(router.name);
  }
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
    <Navbar v-if="showNavbar()" />
    <router-view />
    <Footer v-if="showFooter()" />
  </main>
</template>
<style scoped>
#loading {
  height: 100vh;
  width: 100vw;
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