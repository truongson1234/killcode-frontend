<script setup>
import { ref } from 'vue'
import { darkMode, sidebarColor, sidebarType } from "@/assets/admin/js/argon-dashboard.js"

var inputDarkMode = ref(null)

function darkModeClick() {
    darkMode(inputDarkMode.value)
}
function sidebarColorClick(event) {
    sidebarColor(event.target)
}

function sidebarTypeClick(event) {
    sidebarType(event.target)
}
</script>
<template>
    <div class="fixed-plugin">
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3 ">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Argon Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button
                        class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0 overflow-auto">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)"
                    class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active"
                            data-color="primary"
                            @click="sidebarColorClick($event)"></span>
                        <span class="badge filter bg-gradient-dark"
                            data-color="dark"
                            @click="sidebarColorClick($event)"></span>
                        <span class="badge filter bg-gradient-info"
                            data-color="info"
                            @click="sidebarColorClick($event)"></span>
                        <span class="badge filter bg-gradient-success"
                            data-color="success"
                            @click="sidebarColorClick($event)"></span>
                        <span class="badge filter bg-gradient-warning"
                            data-color="warning"
                            @click="sidebarColorClick($event)"></span>
                        <span class="badge filter bg-gradient-danger"
                            data-color="danger"
                            @click="sidebarColorClick($event)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between 2 different sidenav types.
                    </p>
                </div>
                <div class="d-flex">
                    <button
                        class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2"
                        data-class="bg-white"
                        @click="sidebarTypeClick($event)">White</button>
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2"
                        data-class="bg-default"
                        @click="sidebarTypeClick($event)">Dark</button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">You can change the
                    sidenav type just on desktop view.</p>
                <!-- Navbar Fixed -->
                <!-- <div class="d-flex my-3">
                    <h6 class="mb-0">Navbar Fixed</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto"
                            type="checkbox" id="navbarFixed"
                            onclick="navbarFixed(this)">
                    </div>
                </div> -->
                <hr class="horizontal dark my-sm-4">
                <div class="mt-2 mb-5 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto"
                            type="checkbox" id="dark-version"
                            @click="darkModeClick" ref="inputDarkMode">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>