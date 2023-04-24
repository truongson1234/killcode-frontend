<template>
    <div>
        <div class="upper-space"></div>
        <header class="navbar relative" :class="{ open: navbarEl }">
            <div class="navbar-navigation-mobile hidden absolute left-0 top-16 p-4 bg-white w-full">
                <ul class="text-center text-gray-900">
                    <li class="py-2 hover:bg-gray-600 hover:text-white">
                        <router-link :to="{ name: 'TagsList' }" class="hover:text-inherit">Chủ
                            đề</router-link>
                    </li>
                    <li class="py-2 hover:bg-gray-600 hover:text-white">
                        <router-link :to="{ name: 'QuestionsList' }" class="hover:text-inherit">Câu
                            hỏi</router-link>
                    </li>
                    <li class="py-2 hover:bg-gray-600 hover:text-white">
                        <router-link :to="{ name: 'PostsList' }" class="hover:text-inherit">Bài
                            viết</router-link>
                    </li>
                </ul>
            </div>
            <div class="container">
                <router-link class="navbar__logo"
                    :to="{ name: 'Home' }">Killcode</router-link>
                <div class="navbar__group">
                    <ul class="navbar__navigation flex items-center">
                        <li>
                            <router-link :to="{ name: 'TagsList' }">Chủ
                                đề</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'QuestionsList' }">Câu
                                hỏi</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'Test' }">Test</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'PostsList' }">Bài
                                viết</router-link>
                        </li>
                    </ul>
                    
                    <div class="relative" v-if="authStore.getInfoUser">
                        <button @click="showNotifications($event)"
                            class="relative z-10 block rounded-md bg-white pl-3 pr-1 py-2 focus:outline-none">
                            <i class='bx bxs-bell h-5 w-5 text-gray-800'></i>
                            <div class="icon-unique-bell"
                                :class="[!statusDotBell ? 'hidden' : '']"></div>
                        </button>

                        <div class="list-notification absolute right-0 mt-2 bg-white rounded-md shadow-lg overflow-hidden z-20 hidden"
                            style="width:20rem;">
                            <div
                                class="flex items-center justify-between px-3 pt-2">
                                <h4 class="font-bold">Thông báo</h4>
                                <span class="cursor-pointer px-1 py-1 text-lg"
                                    @click="readAllNotice(authStore.getInfoUser.id)">
                                    <i class='bx bx-check-double'></i>
                                </span>
                            </div>
                            <div class="">
                                <router-link
                                    :to="{ name: notification.route.name, params: { id: notification.route.params.id } }"
                                    v-for="(notification, index) in notifications"
                                    :key="notification.id"
                                    @click="readNotice(notification.id, notification.post_id, index)"
                                    class="flex items-center px-4 py-3 border-b  -mx-2 hover:bg-gray-100"
                                    :class="[notification.read ? '' : 'bg-gray-100 ']">
                                    <img class="h-8 w-8 rounded-full object-cover mx-1"
                                        :src="notification.sender.avatar"
                                        alt="avatar">
                                    <div class="flex flex-col">
                                        <p class="text-gray-600 text-sm mx-2">
                                            <span
                                                v-html="notification.content"></span>
                                        </p>
                                        <p class="text-xs mx-2 text-gray-400">{{
                                            formatDateTimeFB(new
                                                Date(notification.created_at)) }}</p>
                                    </div>
                                </router-link>
                            </div>
                            <router-link
                                :to="{ name: 'ListAllNotice', params: { id: authStore.getInfoUser.id } }"
                                class="block bg-gray-800 text-white text-center text-sm py-1.5 read-all-notification">Xem
                                tất cả thông báo</router-link>
                        </div>
                        <!-- <div v-else class="list-notification absolute right-0 mt-2 bg-white rounded-md shadow-lg overflow-hidden z-20 hidden" style="width:20rem;">
                            <span class="text-center py-2 block font-bold text-gray-400">Hiện tại không có thông báo nào.</span>
                        </div> -->
                    </div>
                    <div class="relative" v-if="authStore.getInfoUser">
                        <button @click="showPencilWrite($event)"
                            class="relative z-10 block rounded-md bg-white py-2 pr-3 pl-1 focus:outline-none">
                            <i class='bx bxs-edit-alt h-5 w-5 text-gray-800'></i>
                        </button>

                        <div class="pencil-write absolute right-0 mt-2 bg-white rounded-md shadow-lg overflow-hidden z-20 hidden"
                            style="width:10rem;">
                            <ul class="">
                                <router-link :to="{ name: 'PostCreate' }"
                                    @click="hidePencilWrite"
                                    class="px-3 py-2 flex items-center hover:bg-gray-100 hover:text-current">
                                    <i class='bx bxs-pencil pr-1'></i>
                                    Viết bài
                                </router-link>
                                <router-link :to="{ name: 'QuestionCreate' }"
                                    @click="hidePencilWrite"
                                    class="px-3 py-2 flex items-center hover:bg-gray-100 hover:text-current">
                                    <i class='bx bx-question-mark pr-1'></i> Đặt câu
                                    hỏi
                                </router-link>
                            </ul>
                        </div>
                    </div>
                    <div class="navbar__group-icon">
                        <template v-if="!authStore.getInfoUser">
                            <BtnLogin />
                        </template>
                        <template v-else>
                            <!-- user -->
                            <div class="navbar__dropdown dropdown">
                                <button class="navbar__dropdown-toggle"
                                    type="button" id="dropdownMenuButton1"
                                    @click="dropdownIconUser($event)">
                                    <div class="navbar__logo-user">
                                        <img class="navbar__logo-user"
                                            :src="infoAuth.avatar" alt="user" />
                                    </div>
                                </button>
                                <ul class="dropdownIconUserMenu navbar__dropdown-menu dropdown-menu hidden py-0"
                                    style="width: 17rem;">
                                    <li
                                        class="flex items-center navbar__ dropdown-item bg-gray-100 py-2">
                                        <img class="rounded-full w-14 h-14"
                                            :src="infoAuth.avatar" alt="user" />
                                        <div class="flex flex-col pl-1.5">
                                            <span
                                                class="text-blue-500 text-md font-bold">{{
                                                    infoAuth.name }}</span>
                                            <span class="text-gray-500 text-sm">{{
                                                infoAuth.email }}</span>
                                        </div>
                                    </li>
                                    <li>
                                        <router-link
                                            class="navbar__ dropdown-item flex items-center"
                                            @click="hideItemDropdownIconUser"
                                            :to="{ name: 'User', params: { id: infoAuth.id } }">
                                            <i class='bx bxs-user pr-1.5'></i> Hồ sơ
                                            cá nhân
                                        </router-link>
                                    </li>
                                    <li v-if="isAdmin.indexOf('admin') != -1">
                                        <router-link
                                            class="navbar__ dropdown-item flex items-center"
                                            @click="hideItemDropdownIconUser"
                                            :to="{ name: 'Dashboard' }">
                                            <i
                                                class='bx bx-shield-quarter pr-1.5'></i>
                                            Quản trị hệ thống
                                        </router-link>
                                    </li>
                                    <li>
                                        <BtnDarkMode
                                            @click="hideItemDropdownIconUser" />
                                    </li>
                                    <li>
                                        <button
                                            class="navbar__ dropdown-item flex items-center"
                                            @click="authStore.handleLogout(), hideItemDropdownIconUser">
                                            <i class='bx bxs-log-out pr-1.5'></i>
                                            Đăng xuất
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <!--  -->
                        </template>
                        <i class="navbar__toggle-menu bx bx-menu text-gray-800"
                            @click="showMenuRepon($event)"></i>
                    </div>
                </div>
            </div>
        </header>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import Pusher from "pusher-js";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import BtnDarkMode from "@/components/ui/BtnDarkMode.vue";
import BtnLogin from "@/components/ui/BtnLogin.vue";
import { formatDateTimeFB } from '@/assets/js/app.js'
const authStore = useAuthStore();

const data = () => ({
    pusher: null,
    channel: null,
});

var navbarEl = ref(true);
const statusDotBell = ref(false)
const isAdmin = computed(() => {
    return authStore.getAuthRoles;
});
const infoAuth = computed(() => {
    return authStore.getInfoUser;
});
const notifications = ref([]);

const showMenuRepon = (event) => {
    event.stopPropagation();
    if ($('.navbar-navigation-mobile').first().is(":hidden")) {
        $('.navbar-navigation-mobile').slideDown(300);
    } else {
        $('.navbar-navigation-mobile').slideUp(300);
    }
};
const showNotifications = (event) => {
    event.stopPropagation();
    if ($('.list-notification ').first().is(":hidden")) {
        $('.list-notification ').slideDown(300);
    } else {
        $('.list-notification').slideUp(300);
    }
}
const dropdownIconUser = (event) => {
    event.stopPropagation();
    if ($('.dropdownIconUserMenu').first().is(":hidden")) {
        $('.dropdownIconUserMenu').slideDown(300);
    } else {
        $('.dropdownIconUserMenu').slideUp(300);
    }
}
const showPencilWrite = (event) => {
    event.stopPropagation();
    if ($('.pencil-write').first().is(":hidden")) {
        $('.pencil-write').slideDown(300);
    } else {
        $('.pencil-write').slideUp(300);
    }
}
const hidePencilWrite = () => {
    $('.pencil-write').slideUp(300);
}
const hideItemDropdownIconUser = () => {
    $('.dropdownIconUserMenu').slideUp(300);
}
const readNotice = async (id_notice, id_, index) => {
    await axios.put(`api/notifications/read-notice/${id_notice}`)
        .then(res => {
            notifications.value[index].read = true
            notifications.value.some((item) => {
                if (item.read === false) {
                    statusDotBell.value = true
                    return true;
                }
                statusDotBell.value = false
            });
            // console.log(res)
        })
        .catch(err => {
            console.log(err)
        })
    $('.list-notification ').slideUp(300);
}
const readAllNotice = async (user_id) => {
    await axios.put(`api/notifications/read-all-notice/${user_id}`)
        .then(res => {
            notifications.value.forEach(function (item) {
                item.read = true
            })
            statusDotBell.value = false
            // console.log(res)
        })
        .catch(err => {
            console.log(err)
        })
}
const fetchData = () => {
    axios
        .post('/api/notifications/my-notice')
        .then((response) => {
            notifications.value = response.data.data;
            notifications.value.forEach(function (item) {
                if (item.read == false) {
                    statusDotBell.value = true
                    // console.log(item,statusDotBell.value);
                    return
                }
            })
            notifications.value.map(function (item) {
                if (item.sender.avatar.indexOf('http://localhost:8000/images/') == -1) {
                    return item.sender.avatar = 'http://localhost:8000/images/' + item.sender.avatar
                }
            })
            // console.log('thong baooooo',notifications.value)
        })
        .catch((error) => {
            console.log(error);
        });
};

onMounted(async () => {
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.dropdownIconUser').length) {
            $('.dropdownIconUserMenu').slideUp(300);
        }
        if (!$(event.target).closest('.showNotifications').length) {
            $('.list-notification').slideUp(300);
        }
        if (!$(event.target).closest('.showMenuRepon').length) {
            $('.navbar-navigation-mobile').slideUp(300);
        }
        if (!$(event.target).closest('.showPencilWrite').length) {
            $('.pencil-write').slideUp(300);
        }
    });
    $('.read-all-notification').click(function () {
        $('.list-notification').slideDown(300);
    })
    $('.list-notification').click(function (event) {
        event.stopPropagation()
        $(this).slideDown(300);
    })
    await authStore.getToken();
    await authStore.getUser();

    if (infoAuth.value) {
        const userId = infoAuth.value.id;

        fetchData()

        data.pusher = new Pusher("100f9f72ec40accb9c52", {
            cluster: "ap1",
            encrypted: true,
        });

        data.channel = data.pusher.subscribe("chanel-notification");

        data.channel.bind('general-announcement', (notification) => {
            notifications.value.unshift(notification);
            statusDotBell.value = true
            if (notifications.value.length > 5) {
                notifications.value.pop();
            }
        });

        data.channel.bind(`event-notification-${userId}`, (notification) => {
            notifications.value.unshift(notification);
            statusDotBell.value = true
            if (notifications.value.length > 5) {
                notifications.value.pop();
            }
            notifications.value.map(function (item) {
                if (item.sender.avatar.indexOf('http://localhost:8000/images/') == -1) {
                    return item.sender.avatar = 'http://localhost:8000/images/' + item.sender.avatar
                }
            })
            // console.log('cc',notifications.value);
        });
    }
});

onBeforeUnmount(() => {
    data.channel?.unbind?.();
    data.pusher?.disconnect?.();
});
</script>

<style scoped>
.navbar .navbar-navigation-mobile {
    box-shadow: 0px 8px 16px 0px rgba(146, 146, 146, 0.2);
}
.icon-unique-bell:after {
    position: absolute;
    content: '';
    top: 20%;
    right: 15%;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: red;
}

.navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    height: 70px;
    background: var(--color-light-mode);
    padding: 10px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 15px 15px rgba(0, 0, 0, 0.05);
    z-index: 100;
}

.upper-space {
    padding-bottom: 6rem;
    /* background: #dee1e2; */
}

.navbar .navbar__logo {
    color: var(--color-dark-mode);
    text-decoration: none;
    font-size: 1.25rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

.navbar .navbar__group {
    display: flex;
    align-items: center;
}

.navbar .navbar__navigation {
    position: relative;
    display: flex;
    gap: 30px;
}

.navbar .navbar__navigation li {
    list-style: none;
}

.navbar .navbar__navigation li a {
    position: relative;
    text-decoration: none;
    font-size: 1em;
    color: var(--color-dark-mode);
    text-transform: uppercase;
    letter-spacing: 0.2em;
}

.navbar .navbar__navigation li a::before {
    content: "";
    position: absolute;
    bottom: -2px;
    width: 100%;
    height: 2px;
    background: var(--color-dark-mode);
    transform: scaleX(0);
    transition: transform 0.5s ease-in-out;
    transform-origin: right;
}

.navbar .navbar__navigation li a:hover::before {
    transform: scale(1);
    transform-origin: left;
}

.navbar .navbar__group-icon {
    display: flex;
    align-items: center;
    gap: 20px;
}

.navbar .navbar__dropdown-menu {
    left: auto;
    right: 0;
}

/* .navbar .navbar__dropdown-toggle {
  padding: 5px 8px;
  border: 2px solid #333;
  background: var(--color-dark-mode);

}

.navbar .navbar__dropdown-toggle::after {
  display: none;
} */
.navbar .navbar__dropdown-toggle {
    border: 2px solid black;
    border-radius: 50%;
}

.navbar .navbar__logo-user img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.navbar .navbar__logo-user {
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
}

.navbar .navbar__toggle-menu {
    position: relative;
    display: none;
}

.navbar__notifications {
    position: relative;
    display: flex;
    align-items: center;
    cursor: pointer;
}

.navbar__notifications-dropdown {
    position: absolute;
    top: 50px;
    right: 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    min-width: 200px;
    display: none;
}

.navbar__notifications-dropdown ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.navbar__notifications-dropdown li {
    padding: 10px;
    border-bottom: 1px solid #ccc;
    font-size: 14px;
}

.navbar__notifications:hover .navbar__notifications-dropdown {
    display: block;
}

/* reponsive */
@media (max-width: 767px) {
    .navbar .navbar__toggle-menu {
        display: block;
        font-size: 2em;
        cursor: pointer;
        z-index: 10;
    }

    .navbar .navbar__navigation {
        display: none;
    }
}</style>
