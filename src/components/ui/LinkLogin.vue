<template>
    <!-- Button trigger modal -->
    <button type="button" class="link-login btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
        Đăng nhập
    </button>
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