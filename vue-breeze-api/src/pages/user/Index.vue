<template>
    <div class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <div id="content" class="content content-full-width">
                    <!-- begin profile -->
                    <div class="profile">
                        <div class="profile-header">
                            <div class="profile-header-content">
                                <div class="profile-header-img">
                                    <img :src="inforUser.avatar" alt="" />
                                </div>
                                <!-- BEGIN profile-header-info -->
                                <div
                                    class="profile-header-info flex justify-between">
                                    <div>

                                        <h4 class="m-t-10 m-b-5">{{ inforUser.name
                                        }}</h4>
                                        <p class="inline-block mt-1 ">
                                            {{ inforUser.email }}</p>
                                    </div>
                                    <div>
                                        <!-- <a href="#"
                                            class="btn btn-sm btn-primary mb-2 inline-flex items-center text-base">
                                            <i class='bx bx-user-plus  pr-1'></i>
                                            <span>Theo dõi</span>
                                        </a> -->
                                        <button
                                            @click="showModalEditProfile(inforUser.id, inforUser.name, inforUser.email)"
                                            class="btn btn-sm btn-secondary mb-2 inline-flex items-center text-base">
                                            <i class='bx bxs-pencil pr-1'></i>
                                            <span>Chỉnh sửa thông tin cá nhân</span>
                                        </button>
                                        <div id="modal-edit-user-role"
                                            class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
                                            <div @click="closeModalEditProfile()"
                                                class="backdrop-modal-edit-role absolute z-10">
                                            </div>
                                            <div class="relative h-full border-0">
                                                <div class="absolute bg-white rounded-lg shadow z-20"
                                                    style="
                                                                                top: 50%;
                                                                                left: 50%;
                                                                                transform: translate(
                                                                                    -50%,
                                                                                    -50%
                                                                                );
                                                                            ">
                                                    <button type="button"
                                                        @click="closeModalEditProfile()"
                                                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                                                        <i
                                                            class="bx bx-x text-xl"></i>
                                                    </button>
                                                    <form
                                                        @submit.prevent="updateProfile(formUpdateProfile)">
                                                        <div class="px-4 py-4 lg:px-5"
                                                            style="width: 550px">
                                                            <h3
                                                                class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                                Chỉnh sửa thông tin
                                                                cá
                                                                nhân

                                                            </h3>

                                                            <div
                                                                class="avatar-profile-edit">
                                                                <div
                                                                    class="avatar-upload">
                                                                    <div
                                                                        class="avatar-edit">
                                                                        <input
                                                                            type='file'
                                                                            id="imageUpload"
                                                                            accept=".png, .jpg, .jpeg" />
                                                                        <label
                                                                            for="imageUpload"></label>
                                                                    </div>
                                                                    <div
                                                                        class="avatar-preview">
                                                                        <div id="imagePreview"
                                                                            :style="'background-image: url(' + inforUser.avatar + ')'">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <label
                                                                    for="">Tên:</label>
                                                                <input type="text"
                                                                    v-model="formUpdateProfile.name"
                                                                    class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md text-sm focus:border-black shadow-sm"
                                                                    maxlength="30">
                                                                <div v-if="formUpdateProfile.name == ''"
                                                                    class="mt-0 mb-0">
                                                                    <span
                                                                        class="text-red-400 text-sm p-2 pt-3 px-0">Vui
                                                                        lòng nhập
                                                                        tên!</span>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2">
                                                                <label
                                                                    for="">Email:</label>
                                                                <input type="email"
                                                                    v-model="formUpdateProfile.email"
                                                                    class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md text-sm focus:border-black shadow-sm"
                                                                    maxlength="30">
                                                                <div v-if="formUpdateProfile.email == ''"
                                                                    class="mt-0 mb-0">
                                                                    <span
                                                                        class="text-red-400 text-sm p-2 pt-3 px-0">Vui
                                                                        lòng nhập
                                                                        email!</span>
                                                                </div>
                                                                <div v-if="userStore.getUserError != 'success!'"
                                                                    class="mt-0 mb-0">
                                                                    <span
                                                                        class="text-red-400 text-sm p-2 pt-3 px-0">{{
                                                                            userStore.getUserError
                                                                        }}</span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="px-4 pb-2 lg:px-5"
                                                            style="width: 450px">
                                                            <button type="submit"
                                                                class="btn btn-primary bg-blue-600">Cập
                                                                nhật</button>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="profile-header-tab nav nav-tabs pl-0 bg-gray-100"
                                id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-post-tab"
                                    data-bs-toggle="tab" data-bs-target="#nav-post"
                                    type="button" role="tab"
                                    aria-controls="nav-post"
                                    aria-selected="true">Bài viết</button>
                                <button class="nav-link" id="nav-question-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#nav-question" type="button"
                                    role="tab" aria-controls="nav-question"
                                    aria-selected="false">Câu hỏi</button>
                            </div>
                        </div>
                    </div>
                    <!-- begin profile-content -->
                    <div class="profile-content">
                        <div class="tab-content p-0">
                            <!-- begin #profile-post tab -->
                            <div class="tab-pane fade show active" id="nav-post"
                                role="tabpanel" aria-labelledby="nav-post-tab">
                                <!-- begin timeline -->
                                <ul class="timeline">
                                    <li>
                                        <!-- begin timeline-time -->
                                        <div class="timeline-time">
                                            <span class="date">today</span>
                                            <span class="time">04:20</span>
                                        </div>
                                        <!-- begin timeline-icon -->
                                        <div class="timeline-icon">
                                            <a href="javascript:;">&nbsp;</a>
                                        </div>
                                        <!-- begin timeline-body -->
                                        <div class="timeline-body">
                                            <div class="timeline-header">
                                                <span class="userimage"><img
                                                        :src="inforUser.avatar"
                                                        alt="" /></span>
                                                <span class="username"><a
                                                        href="javascript:;">{{
                                                            inforUser.name }}</a>
                                                    <small></small></span>
                                            </div>
                                            <div class="timeline-content">
                                                <p>
                                                    Lorem ipsum dolor sit amet,
                                                    consectetur adipiscing elit.
                                                    Nunc faucibus turpis quis
                                                    tincidunt
                                                    luctus. Nam sagittis
                                                    dui in nunc consequat, in
                                                    imperdiet
                                                    nunc sagittis.
                                                </p>
                                            </div>
                                            <div class="timeline-likes">
                                                <div class="stats-right">
                                                    <span
                                                        class="stats-text">18 <i
                                                            class='fa fa-eye fa-fw fa-lg m-r-3'></i></span>
                                                    <span class="stats-text">21 <i
                                                            class="fa fa-comments fa-fw fa-lg m-r-3"></i></span>
                                                    <span class="stats-text">259 <i
                                                            class="fa fa-share fa-fw fa-lg m-r-3"></i></span>
                                                </div>
                                                <div class="stats" style="">
                                                    <!-- <span
                                                        class="fa-stack fa-fw stats-icon">
                                                        <i
                                                            class="fa fa-circle fa-stack-2x text-danger"></i>
                                                        <i
                                                            class="fa fa-heart fa-stack-1x fa-inverse t-plus-1"></i>
                                                    </span> -->
                                                    <span
                                                        class="fa-stack fa-fw stats-icon">
                                                        <i
                                                            class="fa fa-circle fa-stack-2x text-primary"></i>
                                                        <i
                                                            class="fa fa-thumbs-up fa-stack-1x fa-inverse"></i>
                                                    </span>
                                                    <span
                                                        class="stats-total">4.3k</span>
                                                </div>
                                            </div>
                                            <!-- <div class="timeline-footer">
                                                <a href="javascript:;"
                                                    class="m-r-15 text-inverse-lighter"><i
                                                        class="fa fa-thumbs-up fa-fw fa-lg m-r-3"></i>
                                                </a>
                                                <a href="javascript:;"
                                                    class="m-r-15 text-inverse-lighter"><i
                                                        class="fa fa-share fa-fw fa-lg m-r-3"></i>
                                                </a>
                                            </div> -->
                                            <div
                                                class="timeline-comment-box flex align-items-center w-100 rounded-sm focus:border-black mb-0">
                                                <div class="user" style="width:36px">
                                                    <img :src="inforUser.avatar" />
                                                </div>
                                                <div class="input w-full">
                                                    <form action="">
                                                        <div
                                                            class="box-cmt flex border-x-0 border-t-0">
                                                            <input type="text"
                                                                class="block py-1 text-sm border-none focus:border-transparent focus:ring-0 w-100"
                                                                maxlength="100"
                                                                placeholder="Nhập bình luận...">
                                                            <button type="submit"
                                                                class=""><i
                                                                    class='bx bxs-send text-lg'></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end timeline-body -->
                                    </li>
                                    <li>
                                        <!-- begin timeline-icon -->
                                        <div class="timeline-icon">
                                            <a href="javascript:;">&nbsp;</a>
                                        </div>
                                        <!-- begin timeline-body -->
                                        <div class="timeline-body">Loading...</div>
                                        <!-- begin timeline-body -->
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="nav-question"
                                role="tabpanel" aria-labelledby="nav-question-tab">
                                <h2>adu</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useAuthStore } from "@/stores/auth";
import { useUserStore } from "@/stores/user";
import { pageLoading, pageLoaded } from "@/assets/js/app.js"
import { findProp } from '@vue/compiler-core';
const authStore = useAuthStore();
const userStore = useUserStore();
const formUpdateProfile = ref({
    idUser: '',
    name: '',
    image: '',
    nameImage: '',
    email: '',
    // about: ''
})
const inforUser = computed(() => {
    return authStore.getInfoUser ?? ''
})
onMounted(async () => {
    pageLoading()
    pageLoaded(1000)

    $("#imageUpload").change(function () {
        readURL(this);
    });
})
const showModalEditProfile = (idUser, nameUser, mailUser) => {
    formUpdateProfile.value.idUser = idUser
    formUpdateProfile.value.name = nameUser
    formUpdateProfile.value.email = mailUser
    userStore.userError = ''
    $('#modal-edit-user-role').removeClass('hidden')
}
const closeModalEditProfile = () => {
    $('#modal-edit-user-role').addClass('hidden')
}
const readURL = (input) => {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
            // Lấy tên file
            var fileName = input.files[0].name;
            var fileData = reader.result;
            console.log(fileName)
            formUpdateProfile.value.nameImage = fileName
            formUpdateProfile.value.image = fileData
        }
        reader.readAsDataURL(input.files[0]);
    }
}
const updateProfile = async (formData) => {

    if (formUpdateProfile.value.name !== '' && formUpdateProfile.value.email !== undefined) {
        pageLoading()
        await userStore.handleUpdateProfile(formData)
        await authStore.getUser()
        pageLoaded()
        if (userStore.getUserError == 'success!') {
            Swal.fire({
                icon: 'success',
                title: 'Cập nhật thông tin thành công!',
                confirmButtonText: 'Tiếp tục'
            })
        }
        // else {
        //     Swal.fire({
        //         icon: 'warning',
        //         title: "Đã xảy ra lỗi, vui lòng thử lại.",
        //         confirmButtonText: 'Đóng'
        //     })
        // }
    }
}
</script>
<style scoped>
.box-cmt {
    border-bottom: 1px solid #7bafd9;
}

.box-cmt:focus-within {
    border-bottom: 1px solid #0067bb;
}
.box-cmt input {
    padding-left: 5px;
    padding-right: 5px;
}
.timeline-body .stats {
    padding-bottom: 10px;
    border-bottom: 1px solid #e2e7eb;
}

#modal-edit-user-role .backdrop-modal-edit-role {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.2);
}

.avatar-profile-edit {
    max-width: 960px;
    margin: auto;
    padding: 20px;
}

.avatar-profile-edit h1 {
    font-size: 20px;
    text-align: center;
    margin: 20px 0 20px;
}

.avatar-profile-edit h1 small {
    display: block;
    font-size: 15px;
    padding-top: 8px;
    color: gray;
}

.avatar-profile-edit .avatar-upload {
    position: relative;
    max-width: 205px;
    margin: auto;
}

.avatar-profile-edit .avatar-upload .avatar-edit {
    position: absolute;
    right: 30px;
    z-index: 1;
    top: 10px;
}

.avatar-profile-edit .avatar-upload .avatar-edit input {
    display: none;
}

.avatar-profile-edit .avatar-upload .avatar-edit input+label {
    display: inline-block;
    width: 34px;
    height: 34px;
    margin-bottom: 0;
    border-radius: 100%;
    background: #FFFFFF;
    border: 1px solid transparent;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
    cursor: pointer;
    font-weight: normal;
    transition: all 0.2s ease-in-out;
}

.avatar-profile-edit .avatar-upload .avatar-edit input+label:hover {
    background: #f1f1f1;
    border-color: #d6d6d6;
}

.avatar-profile-edit .avatar-upload .avatar-edit input+label:after {
    content: "\f040";
    font-family: "FontAwesome";
    color: #757575;
    position: absolute;
    top: 6px;
    left: 0;
    right: 0;
    text-align: center;
    margin: auto;
}

.avatar-profile-edit .avatar-upload .avatar-preview {
    width: 192px;
    height: 192px;
    position: relative;
    border-radius: 100%;
    border: 6px solid #f3f3f3;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}

.avatar-profile-edit .avatar-upload .avatar-preview>div {
    width: 100%;
    height: 100%;
    border-radius: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}

.content {
    border-radius: 4px;
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
}

.profile-header {
    position: relative;
    overflow: hidden
}

.profile-header .profile-header-cover {
    border-radius: 4px;
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0
}

.profile-header .profile-header-content {
    color: var(--color-dark-mode);
    padding: 25px
}

.profile-header-img img {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    border-radius: 50%;
}

.profile-header-img {
    float: left;
    height: 100px;
    width: 100px;
    overflow: hidden;
    position: relative;
    z-index: 10;
    margin: 0 0 -20px;
    border-radius: 4px;
    background: var(--color-light-mode)
}


.profile-header-info h4 {
    font-weight: 500;
    color: var(--color-dark-mode)
}

.profile-header-img+.profile-header-info {
    margin-left: 110px
}

.profile-header .profile-header-content,
.profile-header .profile-header-tab {
    position: relative
}

.b-minus-1,
.b-minus-10,
.b-minus-2,
.b-minus-3,
.b-minus-4,
.b-minus-5,
.b-minus-6,
.b-minus-7,
.b-minus-8,
.b-minus-9,
.b-plus-1,
.b-plus-10,
.b-plus-2,
.b-plus-3,
.b-plus-4,
.b-plus-5,
.b-plus-6,
.b-plus-7,
.b-plus-8,
.b-plus-9,
.l-minus-1,
.l-minus-2,
.l-minus-3,
.l-minus-4,
.l-minus-5,
.l-minus-6,
.l-minus-7,
.l-minus-8,
.l-minus-9,
.l-plus-1,
.l-plus-10,
.l-plus-2,
.l-plus-3,
.l-plus-4,
.l-plus-5,
.l-plus-6,
.l-plus-7,
.l-plus-8,
.l-plus-9,
.r-minus-1,
.r-minus-10,
.r-minus-2,
.r-minus-3,
.r-minus-4,
.r-minus-5,
.r-minus-6,
.r-minus-7,
.r-minus-8,
.r-minus-9,
.r-plus-1,
.r-plus-10,
.r-plus-2,
.r-plus-3,
.r-plus-4,
.r-plus-5,
.r-plus-6,
.r-plus-7,
.r-plus-8,
.r-plus-9,
.t-minus-1,
.t-minus-10,
.t-minus-2,
.t-minus-3,
.t-minus-4,
.t-minus-5,
.t-minus-6,
.t-minus-7,
.t-minus-8,
.t-minus-9,
.t-plus-1,
.t-plus-10,
.t-plus-2,
.t-plus-3,
.t-plus-4,
.t-plus-5,
.t-plus-6,
.t-plus-7,
.t-plus-8,
.t-plus-9 {
    position: relative !important
}

.profile-header .profile-header-tab {
    /* background: var(--color-light-mode); */
    list-style-type: none;
    margin: -15px 0 0 135px;
    white-space: nowrap;
    border-top: none;
    border-bottom: none;
    border-radius: 0;
    margin-bottom: 3px;
}

.text-ellipsis,
.text-nowrap {
    white-space: nowrap !important
}

.profile-header .profile-header-tab>li {
    display: inline-block;
    margin: 0
}

.profile-header .profile-header-tab>li>a {
    display: block;
    color: var(--color-dark-mode);
    line-height: 20px;
    padding: 10px 20px;
    text-decoration: none;
    font-size: 12px;
    border: none
}

.profile-header .profile-header-tab>li.active>a,
.profile-header .profile-header-tab>li>a.active {
    /* color: var(--color-light-mode); */
    /* font-weight: bold; */
}

.profile-content {
    padding: 25px;
    border-radius: 4px
}

.profile-content:after,
.profile-content:before {
    content: '';
    display: table;
    clear: both
}

.profile-content .tab-content,
.profile-content .tab-pane {
    background: 0 0
}

.profile-left {
    width: 200px;
    float: left
}

.profile-right {
    margin-left: 240px;
    padding-right: 20px
}

.profile-image {
    height: 175px;
    line-height: 175px;
    text-align: center;
    font-size: 72px;
    margin-bottom: 10px;
    border: 2px solid #E2E7EB;
    overflow: hidden;
    border-radius: 4px
}

.profile-image img {
    display: block;
    max-width: 100%
}

.profile-highlight {
    padding: 12px 15px;
    background: #FEFDE1;
    border-radius: 4px
}

.profile-highlight h4 {
    margin: 0 0 7px;
    font-size: 12px;
    font-weight: 700
}

.table.table-profile>thead>tr>th {
    border-bottom: none !important
}

.table.table-profile>thead>tr>th h4 {
    font-size: 20px;
    margin-top: 0
}

.table.table-profile>thead>tr>th h4 small {
    display: block;
    font-size: 12px;
    font-weight: 400;
    margin-top: 5px
}

.table.table-profile>tbody>tr>td,
.table.table-profile>thead>tr>th {
    border: none;
    padding-top: 7px;
    padding-bottom: 7px;
    color: #242a30;
    background: 0 0
}

.table.table-profile>tbody>tr>td.field {
    width: 20%;
    text-align: right;
    font-weight: 600;
    color: #2d353c
}

.table.table-profile>tbody>tr.highlight>td {
    border-top: 1px solid #b9c3ca;
    border-bottom: 1px solid #b9c3ca
}

.table.table-profile>tbody>tr.divider>td {
    padding: 0 !important;
    height: 10px
}

.profile-section+.profile-section {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #b9c3ca
}

.profile-section:after,
.profile-section:before {
    content: '';
    display: table;
    clear: both
}

.profile-section .title {
    font-size: 20px;
    margin: 0 0 15px
}

.profile-section .title small {
    font-weight: 400
}

body.flat-black {
    background: #E7E7E7
}

.flat-black .navbar.navbar-inverse {
    background: #212121
}

.flat-black .navbar.navbar-inverse .navbar-form .form-control {
    background: #4a4a4a;
    border-color: #4a4a4a
}

.flat-black .sidebar,
.flat-black .sidebar-bg {
    background: #3A3A3A
}

.flat-black .page-with-light-sidebar .sidebar,
.flat-black .page-with-light-sidebar .sidebar-bg {
    background: var(--color-light-mode)
}

.flat-black .sidebar .nav>li>a {
    color: #b2b2b2
}

.flat-black .sidebar.sidebar-grid .nav>li>a {
    border-bottom: 1px solid #474747;
    border-top: 1px solid #474747
}

.flat-black .sidebar .active .sub-menu>li.active>a,
.flat-black .sidebar .nav>li.active>a,
.flat-black .sidebar .nav>li>a:focus,
.flat-black .sidebar .nav>li>a:hover,
.flat-black .sidebar .sub-menu>li>a:focus,
.flat-black .sidebar .sub-menu>li>a:hover,
.sidebar .nav>li.nav-profile>a {
    color: var(--color-light-mode)
}

.flat-black .sidebar .sub-menu>li>a,
.flat-black .sidebar .sub-menu>li>a:before {
    color: #999
}

.flat-black .page-with-light-sidebar .sidebar .active .sub-menu>li.active>a,
.flat-black .page-with-light-sidebar .sidebar .active .sub-menu>li.active>a:focus,
.flat-black .page-with-light-sidebar .sidebar .active .sub-menu>li.active>a:hover,
.flat-black .page-with-light-sidebar .sidebar .nav>li.active>a,
.flat-black .page-with-light-sidebar .sidebar .nav>li.active>a:focus,
.flat-black .page-with-light-sidebar .sidebar .nav>li.active>a:hover {
    color: #000
}

.flat-black .page-sidebar-minified .sidebar .nav>li.has-sub:focus>a,
.flat-black .page-sidebar-minified .sidebar .nav>li.has-sub:hover>a {
    background: #323232
}

.flat-black .page-sidebar-minified .sidebar .nav li.has-sub>.sub-menu,
.flat-black .sidebar .nav>li.active>a,
.flat-black .sidebar .nav>li.active>a:focus,
.flat-black .sidebar .nav>li.active>a:hover,
.flat-black .sidebar .nav>li.nav-profile,
.flat-black .sidebar .sub-menu>li.has-sub>a:before,
.flat-black .sidebar .sub-menu>li:before,
.flat-black .sidebar .sub-menu>li>a:after {
    background: #2A2A2A
}

.flat-black .page-sidebar-minified .sidebar .sub-menu>li:before,
.flat-black .page-sidebar-minified .sidebar .sub-menu>li>a:after {
    background: #3e3e3e
}

.flat-black .sidebar .nav>li.nav-profile .cover.with-shadow:before {
    background: rgba(42, 42, 42, .75)
}

.bg-white {
    background-color: var(--color-light-mode) !important;
}

.p-10 {
    padding: 10px !important;
}

.media.media-xs .media-object {
    width: 32px;
}

.m-b-2 {
    margin-bottom: 2px !important;
}

.media>.media-left,
.media>.pull-left {
    padding-right: 15px;
}

.media-body,
.media-left,
.media-right {
    display: table-cell;
    vertical-align: top;
}

select.form-control:not([size]):not([multiple]) {
    height: 34px;
}

.form-control.input-inline {
    display: inline;
    width: auto;
    padding: 0 7px;
}


.timeline {
    list-style-type: none;
    margin: 0;
    padding: 0;
    position: relative
}

.timeline:before {
    content: '';
    position: absolute;
    top: 5px;
    bottom: 5px;
    width: 5px;
    background: #2d353c;
    left: 20%;
    margin-left: -2.5px
}

.timeline>li {
    position: relative;
    min-height: 50px;
    padding: 20px 0
}

.timeline .timeline-time {
    position: absolute;
    left: 0;
    width: 18%;
    text-align: right;
    top: 30px
}

.timeline .timeline-time .date,
.timeline .timeline-time .time {
    display: block;
    font-weight: 600
}

.timeline .timeline-time .date {
    line-height: 16px;
    font-size: 12px
}

.timeline .timeline-time .time {
    line-height: 24px;
    font-size: 20px;
    color: #242a30
}

.timeline .timeline-icon {
    left: 15%;
    position: absolute;
    width: 10%;
    text-align: center;
    top: 40px
}

.timeline .timeline-icon a {
    text-decoration: none;
    width: 20px;
    height: 20px;
    display: inline-block;
    border-radius: 20px;
    background: #d9e0e7;
    line-height: 10px;
    color: var(--color-light-mode);
    font-size: 14px;
    border: 5px solid #2d353c;
    transition: border-color .2s linear
}

.timeline .timeline-body {
    margin-left: 23%;
    margin-right: 17%;
    background: var(--color-light-mode);
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    position: relative;
    padding: 20px 25px;
    border-radius: 6px
}

.timeline .timeline-body:before {
    content: '';
    display: block;
    position: absolute;
    border: 10px solid transparent;
    border-right-color: var(--color-light-mode);
    left: -20px;
    top: 20px
}

.timeline .timeline-body>div+div {
    margin-top: 15px
}

.timeline .timeline-body>div+div:last-child {
    margin-bottom: 10px;
    /* padding-bottom: 20px; */
    border-radius: 0 0 6px 6px
}

.timeline-header {
    padding-bottom: 10px;
    border-bottom: 1px solid #e2e7eb;
    line-height: 30px
}

.timeline-header .userimage {
    float: left;
    width: 34px;
    height: 34px;
    border-radius: 40px;
    overflow: hidden;
    margin: -2px 10px -2px 0
}

.timeline-header .username {
    font-size: 16px;
    font-weight: 600;
    margin-right: 5px;
}

.timeline-header .username,
.timeline-header .username a {
    color: #2d353c
}

.timeline img {
    max-width: 100%;
    display: block
}

.timeline-content {
    color: var(--color-dark-mode);
    text-align: justify;
}

.timeline-content:after,
.timeline-content:before {
    content: '';
    display: table;
    clear: both
}

.timeline-title {
    margin-top: 0
}

.timeline-footer {
    background: var(--color-light-mode);
    border-top: 1px solid #e2e7ec;
    padding-top: 15px
}

.timeline-footer a:not(.btn) {
    color: #575d63
}

.timeline-footer a:not(.btn):focus,
.timeline-footer a:not(.btn):hover {
    color: #2d353c
}

.timeline-likes {
    color: #6d767f;
    font-weight: 600;
    font-size: 12px
}

.timeline-likes .stats-right {
    float: right
}

.timeline-likes .stats-total {
    display: inline-block;
    line-height: 20px
}

.timeline-likes .stats-icon {
    float: left;
    margin-right: 5px;
    font-size: 9px
}

.timeline-likes .stats-icon+.stats-icon {
    margin-left: -2px
}

.timeline-likes .stats-text {
    line-height: 20px
}

.timeline-likes .stats-text+.stats-text {
    margin-left: 15px
}

.timeline-comment-box {
    /* background: var(--color-dark-mode); */
    /* margin-left: -25px;
    margin-right: -25px;
    padding: 20px 25px */
}

.timeline-comment-box .user {
    float: left;
    width: 34px;
    height: 34px;
    overflow: hidden;
    border-radius: 30px
}

.timeline-comment-box .user img {
    max-width: 100%;
    max-height: 100%
}

.timeline-comment-box .user+.input {
    margin-left: 5px
}

.lead {
    margin-bottom: 20px;
    font-size: 21px;
    font-weight: 300;
    line-height: 1.4;
}
</style>
