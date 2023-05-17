<template>
    <footer class="footer pt-3">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <a class="text-center text-sm text-muted text-lg-start">
                    © 2023
                    copyright
                    <span class="font-weight-bold">killcode</span>.
                </a>
            </div>
            <div class="col-lg-6">
                <ul
                    class="nav nav-footer justify-content-center justify-content-lg-end">
                    <li class="nav-item pr-2.5">
                        <router-link :to="{ name: 'Dashboard' }"
                            class="pe-0 text-muted" target="_blank">Tổng quan</router-link>
                    </li>
                    <li class="nav-item pr-2.5">
                        <router-link :to="{ name: 'AdminRoles' }"
                            class="pe-0 text-muted" target="_blank">Quyền hạn</router-link>
                    </li>
                    <li class="nav-item pr-2.5">
                        <router-link :to="{ name: 'AdminTags' }"
                            class="pe-0 text-muted" target="_blank">Chủ đề</router-link>
                    </li>
                    <li class="nav-item pr-2.5">
                        <router-link :to="{ name: 'AdminPosts' }"
                            class="pe-0 text-muted" target="_blank">Bài viết</router-link>
                    </li>
                    <li class="nav-item pr-2.5">
                        <router-link :to="{ name: 'AdminReports' }"
                            class="pe-0 text-muted" target="_blank">Báo cáo</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
</template>