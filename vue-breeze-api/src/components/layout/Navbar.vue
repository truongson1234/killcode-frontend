<template>
    <div>
        <div class="upper-space"></div>
        <header class="navbar" :class="{ open: navbarEl }">
            <div class="container">
                <router-link class="navbar__logo" :to="{ name: 'Home' }"
                    >Killcode</router-link
                >
                <div class="navbar__group">
                    <ul class="navbar__navigation">
                        <li>
                            <router-link :to="{ name: 'QuestionList' }"
                                >Câu hỏi</router-link
                            >
                        </li>
                        <li>
                            <router-link :to="{ name: 'Test' }"
                                >Test</router-link
                            >
                        </li>
                        <li>
                            <router-link :to="{ name: 'PostsList' }"
                                >Bài viết</router-link
                            >
                        </li>
                        <div v-if="authStore.getInfoUser" class="navbar__notifications">
                            <i class="bx bx-bell"></i>
                            <div class="navbar__notifications-dropdown">
                                <ul>
                                    <li
                                        v-for="notification in notifications"
                                        :key="notification.id"
                                    >
                                        <h3>{{ notification.title }}</h3>
                                        <p>{{ notification.content }}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </ul>
                    <div class="navbar__group-icon">
                        <template v-if="!authStore.getInfoUser">
                            <BtnLogin />
                        </template>
                        <template v-else>
                            <!-- user -->
                            <div class="navbar__dropdown dropdown">
                                <button
                                    class="navbar__dropdown-toggle"
                                    type="button"
                                    id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    <div class="navbar__logo-user">
                                        <img
                                            class="navbar__logo-user"
                                            :src="infoAuth.avatar"
                                            alt="user"
                                        />
                                    </div>
                                </button>
                                <ul
                                    class="navbar__dropdown-menu dropdown-menu"
                                    aria-labelledby="dropdownMenuButton1"
                                >
                                    <li>
                                        <router-link
                                            class="navbar__ dropdown-item"
                                            :to="{ name: 'User' }"
                                            >Hồ sơ</router-link
                                        >
                                    </li>
                                    <li v-if="isAdmin.indexOf('admin') != -1">
                                        <router-link
                                            class="navbar__ dropdown-item"
                                            :to="{ name: 'Dashboard' }"
                                            >Quản trị</router-link
                                        >
                                    </li>
                                    <li>
                                        <router-link
                                            class="navbar__ dropdown-item"
                                            :to="{ name: 'PostsCreate' }"
                                            >Viết bài</router-link
                                        >
                                    </li>
                                    <li>
                                        <BtnDarkMode />
                                    </li>
                                    <li>
                                        <button
                                            class="navbar__ dropdown-item"
                                            href="#"
                                            @click="authStore.handleLogout()"
                                        >
                                            Đăng xuất
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <!--  -->
                        </template>
                        <i
                            class="navbar__toggle-menu bx bx-menu"
                            @click="showMenuRepon"
                        ></i>
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

const authStore = useAuthStore();

const data = () => ({
    pusher: null,
    channel: null,
});

var navbarEl = ref(false);
const isAdmin = computed(() => {
    return authStore.getAuthRoles;
});
const infoAuth = computed(() => {
    return authStore.getInfoUser;
});

const notifications = ref([]);

const showMenuRepon = () => {
    navbarEl.value = !navbarEl.value;
};

const fetchData = () => {
    axios
        .post('/api/notifications/my-notice')
        .then((response) => {
            notifications.value = response.data.data;
            notifications.value.reverse();
        })
        .catch((error) => {
            console.log(error);
        });
};

onMounted(async () => {
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
            notifications.value.push(notification);
        });

        data.channel.bind(`event-notification-${userId}`, (notification) => {
            notifications.value.push(notification);
        });
    }
});

onBeforeUnmount(() => {
    data.channel.unbind();
    data.pusher.disconnect();
});
</script>

<style scoped>
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
    background: #dee1e2;
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
    gap: 30px;
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
        position: absolute;
        opacity: 0;
        visibility: hidden;
        left: 100%;
    }

    .navbar.open .navbar__navigation {
        top: 70px;
        opacity: 1;
        visibility: visible;
        left: 0;
        display: flex;
        flex-direction: column;
        background: var(--color-dark-mode);
        width: 100%;
        height: calc(100vh - 70px);
        padding: 40px !important;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
}
</style>
