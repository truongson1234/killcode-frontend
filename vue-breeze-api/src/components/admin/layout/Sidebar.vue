<script setup>
import { useRoute } from 'vue-router';
const route = useRoute();

console.log('Router name:', route.name);
</script>
<template>
    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 text-black" id="sidenav-main">
        <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex justify-content-center align-items-center" href="" target="_blank">
            <img src="@/assets/admin/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Argon Dashboard</span>
        </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
            <router-link :to="{ name: 'Dashboard' }" class="nav-link" :class="route.name == 'Dashboard' ? 'active' : ''" >
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Dashboard</span>
            </router-link>
            </li>
            <li class="nav-item">
            <router-link :to="{ name: 'Admin-Roles' }" class="nav-link " :class="route.name == 'Admin-Roles' ? 'active' : ''">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Quyền hạn</span>
            </router-link>
            </li>
            
            <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
            </li>
            <li class="nav-item">
            <a class="nav-link " href="">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Profile</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link " href="">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Sign In</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link " href="">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-collection text-info text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Sign Up</span>
            </a>
            </li>
            <!-- <li class="nav-item">
            <router-link :to="{ name: 'Home' }" class="nav-link " href="">
                <div class="icon-sm text-center me-2 d-flex align-items-center justify-content-center ">
                <i class='bx bxs-home text-lg' ></i>
                </div>
                <div class="h-full">
                    <span class="nav-link-text ms-1">Home</span>
                </div>
            </router-link>
            </li> -->
        </ul>
        </div>
    </aside>
</template>