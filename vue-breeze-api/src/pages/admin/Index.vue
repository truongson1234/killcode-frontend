<script setup>
import "@/assets/admin/css/nucleo-icons.css"
import "@/assets/admin/css/nucleo-svg.css"
import "https://kit.fontawesome.com/42d5adcbca.js"
import "https://buttons.github.io/buttons.js"
import "@/assets/admin/css/argon-dashboard.css"
import Sidebar from '@/components/admin/layout/Sidebar.vue'
import Navbar from '@/components/admin/layout/Navbar.vue'
import Footer from '@/components/admin/layout/Footer.vue'
import FixedPlugin from '@/components/admin/ui/FixedPlugin.vue'
import { onMounted } from 'vue'
import { configDOM } from "@/assets/admin/js/argon-dashboard.js"
import "@/assets/admin/js/plugins/chartjs.min.js";
import "@/assets/admin/js/argon-dashboard.js";

onMounted(() => {
    configDOM()

})
</script>
<template>
    <body class="g-sidenav-show abow-container bg-gray-100">
        <div class="min-height-300 under-container bg-primary position-absolute w-100"></div>
        <Sidebar />
        <main class="main-content position-relative border-radius-lg ">
            <Navbar />
            <div class="container-fluid py-4">
                <router-view></router-view>
                <Footer />
            </div>
            <FixedPlugin />
        </main>
    </body>
</template>