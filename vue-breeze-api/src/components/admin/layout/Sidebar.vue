<script setup>
import { useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth.js';
const authStore = useAuthStore();
const route = useRoute()
</script>
<template>
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 text-black"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <router-link :to="{ name: 'Home' }"
                class="navbar-brand m-0 d-flex justify-content-center align-items-center cursor-pointer">
                <img src="@/assets/admin/img/logo-ct-dark.png"
                    class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold tracking-widest">KILLCODE</span>
            </router-link>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link :to="{ name: 'Dashboard' }" class="nav-link"
                        :class="route.name == 'Dashboard' ? 'active' : ''">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i
                                class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Tổng quan</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{ name: 'AdminRoles' }" class="nav-link "
                        :class="route.name == 'AdminRoles' ? 'active' : ''">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i
                                class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quyền hạn</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{ name: 'AdminTags' }" class="nav-link "
                        :class="route.name == 'AdminTags' ? 'active' : ''">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class='bx bxs-purchase-tag text-success text-sm opacity-10'
                                style="padding-bottom: 6px"></i>
                        </div>
                        <span class="nav-link-text ms-1">Thẻ</span>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link :to="{ name: 'AdminPosts' }" class="nav-link "
                        :class="route.name == 'AdminPosts' ? 'active' : ''">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class='bx bx-book-bookmark text-success text-sm opacity-10'></i>
                        </div>
                        <span class="nav-link-text ms-1">Bài viết</span>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link :to="{ name: 'AdminReports' }" class="nav-link "
                        :class="route.name == 'AdminReports' ? 'active' : ''">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class='bx bxs-flag-alt text-success text-sm opacity-10'></i>
                        </div>
                        <span class="nav-link-text ms-1">Reports</span>
                    </router-link>
                </li>

                <li class="nav-item mt-3">
                    <h6
                        class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                        Tài khoản</h6>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link "
                        :to="{ name: 'Profile', params: {id: authStore.getInfoUser.id} }">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i
                                class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Hồ sơ</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <button class="nav-link" @click="authStore.handleLogout()">
                        <div
                            class="icon icon-shape icon-sm text-center me-2 d-flex align-items-center justify-content-center">
                            <i class='bx bxs-log-out text-dark text-sm opacity-10'
                            style="padding-bottom: 6px"></i>
                    </div>
                    <span class="nav-link-text ms-1">Đăng xuất</span>
                </button>
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
</aside></template>