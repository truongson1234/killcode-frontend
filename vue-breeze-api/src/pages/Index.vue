
<template>
    <main class="relative">
        <Navbar v-if="showNavBar"/>
        <router-view />
        <Footer v-if="showFooter"/>
    </main>
</template>
<script>
import Navbar from "@/components/layout/Navbar.vue";
import Footer from "@/components/layout/Footer.vue";
// css
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '@/assets/css/style.css';
export default {
    components: {
        Navbar,
        Footer
    },
    computed: {
        showNavBar() {
            return this.$route.meta.showNavBar
        },
        showFooter() {
            return this.$route.meta.showFooter
        },
    }
}
</script>
