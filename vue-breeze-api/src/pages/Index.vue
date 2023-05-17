
<template>
    <div id="user">
        <main class="relative">
            <Navbar v-if="showNavBar"/>
            <Banner v-if="showBanner"/>
            <router-view />
            <Footer v-if="showFooter"/>
        </main>
    </div>
</template>
<script>
import Navbar from "@/components/layout/Navbar.vue";
import Footer from "@/components/layout/Footer.vue";
import Banner from "@/components/layout/Banner.vue";
// css
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '@/assets/css/style.css';

export default {
    components: {
        Navbar,
        Footer,
        Banner
    },
    computed: {
        showNavBar() {
            return this.$route.meta.showNavBar
        },
        showFooter() {
            return this.$route.meta.showFooter
        },
        showBanner() {
            return this.$route.meta.showBanner
        },
    }
}
</script>
