<template>
    <div class="wrapper container py-10">
        <div class="home row">
            <div class="col-12 col-md-9">
                
            </div>
            <div class="d-none d-md-block col-md-3">
                <p style="color: var(--color-dark-mode)">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    Doloremque accusantium voluptate eligendi. Mollitia dolorem,
                    iusto cupiditate, omnis officia ratione itaque quae amet
                    asperiores, illo laborum at velit illum! Quod, quae! Lorem,
                    ipsum dolor sit amet consectetur adipisicing elit.
                    Doloremque accusantium voluptate eligendi. Mollitia dolorem,
                    iusto cupiditate, omnis officia ratione itaque quae amet
                    asperiores, illo laborum at velit illum! Quod, quae! Lorem,
                    ipsum dolor sit amet consectetur adipisicing elit.
                    Doloremque accusantium voluptate eligendi.
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeMount } from "vue";
import { useAuthStore } from "@/stores/auth";
import { pageLoading, pageLoaded } from "@/assets/js/app.js"
const authStore = useAuthStore();
onBeforeMount(() => {
    pageLoading()
})
onMounted(async () => {
    pageLoaded()
});

</script>

<style scoped>
.home__tag-name {
    color: var(--color-dark-mode);
}
</style>
