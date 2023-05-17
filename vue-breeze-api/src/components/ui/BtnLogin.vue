<template>
    <!-- Button trigger modal -->
    <router-link :to="{ name: 'Login' }" class="link-login btn btn-primary ml-2.5">
        Đăng nhập
    </router-link>
</template>

<script setup>

</script>

<style scoped>
.link-login,
.link-login:active
{
    padding: 5px 10px;
    color: var(--color-light-mode);
    background: var(--color-dark-mode);
    border-radius: 4px;
    border: none !important;
    outline: none !important;
}
</style>