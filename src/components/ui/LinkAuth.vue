<template>
    <div class="link-auth">
        <ul class="link-auth__group">
            <li class="link-auth__item">
                <router-link :to="{ name: 'authLogin' }">Đăng nhập</router-link>
            </li>
            <li class="link-auth__item">
                <router-link :to="{ name: 'authRegister' }">Đăng kí</router-link>
            </li>
        </ul>
    </div>
</template>

<script setup>

</script>

<style scoped>
.link-auth{
    position: fixed;
    top: 5.25rem;
    right: 20px;
    width: 220px;
    border-radius: 20px;
    overflow: hidden;
    background: var(--color-light-mode);
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
}
.link-auth__group{
    display: flex;
    position: relative;
}
.link-auth__group::after{
    content: "/";
    position: absolute;
    top: 20%;
    left: 50%;
}
.link-auth__item{
    width: 50%;
    text-align: center;
}
.link-auth__item > a{
    display: block;
    padding: 10px;
    color: var(--color-dark-mode);
    text-decoration: none;
}
</style>