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
                                    <div class="pl-3">

                                        <h4 class="m-t-10 m-b-5 font-bold">{{
                                            inforUser.name
                                        }}</h4>
                                        <p class="inline-block mt-1 text-gray-600">
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
                                <div class="flex flex-col items-center">
                                    <ol class="list-post-user">
                                        <li class="border-l-2 border-blue-600"
                                            v-for="(item, index) in postsToShow"
                                            :key="listPost[index]">
                                            <div class="md:flex flex-start"
                                                v-if="index < listPost.length">
                                                <div
                                                    class="bg-blue-600 w-6 h-6 flex items-center justify-center rounded-full -ml-3.5">
                                                    <svg aria-hidden="true"
                                                        focusable="false"
                                                        data-prefix="fas"
                                                        class="text-white w-3 h-3"
                                                        role="img"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 448 512">
                                                        <path fill="currentColor"
                                                            d="M0 464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V192H0v272zm64-192c0-8.8 7.2-16 16-16h288c8.8 0 16 7.2 16 16v64c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16v-64zM400 64h-48V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H160V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H48C21.5 64 0 85.5 0 112v48h448v-48c0-26.5-21.5-48-48-48z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div class="block p-6 rounded-lg bg-gray-100 max-w-md ml-6 mb-10"
                                                    style="min-width:50rem">
                                                    <div
                                                        class="flex justify-between mb-1">
                                                        <p href="#!"
                                                            class="font-medium text-blue-600 focus:text-purple-800 duration-300 transition ease-in-out text-sm">
                                                            {{
                                                                formatDateTimeHours(listPost[index].created_at)
                                                            }}</p>
                                                        <p href="#!"
                                                            class="font-medium text-blue-600 focus:text-purple-800 duration-300 transition ease-in-out text-sm">
                                                            {{
                                                                formatDateTime(listPost[index].created_at)
                                                            }}
                                                            </p>
                                                    </div>
                                                    <PostItem
                                                        :data="listPost[index]"
                                                        :statusDate="false" :deletePost="deletePost" />
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                    <div v-if="postsToShow < listPost.length || listPost.length > postsToShow"
                                        class="">
                                        <button @click="postsToShow += 1"
                                            class="bg-blue-600 text-sm py-1 px-2.5 text-white hover:bg-blue-700"
                                            style="border-radius: 3px;">Xem
                                            thêm</button>
                                    </div>
                                </div>
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
import axios from 'axios';
import { ref, onMounted, computed } from 'vue';
import { useAuthStore } from "@/stores/auth";
import { useUserStore } from "@/stores/user";
import { pageLoading, pageLoaded, formatDateTimeHours, formatDateTime } from "@/assets/js/app.js"
import PostItem from "@/components/ui/PostItem.vue";
import { useRoute } from "vue-router";
const route = useRoute();
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
const postsToShow = ref(2)
const inforUser = computed(() => {
    return dataUser.value || ''
})
const listPost = ref([])
const dataUser = ref([])
const userId = route.params.id;
const fetchData = () => {
    axios
        .get(`/api/posts/list-post-user/${userId}`)
        .then((response) => {
            response.data.posts.forEach(item => {
                item.author.avatar = 'http://localhost:8000/images/' + item.author.avatar
            });
            listPost.value = response.data.posts;
            response.data.user.avatar = 'http://localhost:8000/images/' + response.data.user.avatar
            dataUser.value = response.data.user;
            // console.log(dataUser.value);
        })
        .catch((error) => {
            console.log(error);
        });
}
const deletePost = async (id_post, index) => {
    await axios.delete(`api/posts/${id_post}`)
        .then(res => {
            listPost.value = listPost.value.filter((post) => post.id !== id_post);
        })
        .catch(err => {
            console.log(err);
        })
}
onMounted(async () => {
    pageLoading()
    $("#imageUpload").change(function () {
        readURL(this);
    });
    fetchData()
    pageLoaded(1000)
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
        await userStore.getUserById(userId)
        .then(() => {
            dataUser.value = userStore.getUserById
        })
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

.profile-content {
    padding: 25px;
    border-radius: 4px
}</style>
<style>.list-post-user .box-post {
    background: #ffff;
}</style>