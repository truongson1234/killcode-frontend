<template>
  <div as="nav" class="main relative overflow-hidden">
    <div class="main-background absolute"></div>
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center">
        <div
          class="flex flex-1 items-center justify-between sm:justify-normal  w-full relative">
          <div class="block sm:hidden xs-block sm-block">
            <button class="text-2xl" @click="showMenuMobile($event)">
              <i class='bx bx-menu text-white'></i>
            </button>
            <div class="menu-mobile absolute bg-white w-full rounded hidden">
              <ul class="flex flex-col text-center">
                <router-link :to="{ name: item.router }"
                  v-for="item in navigation"
                  class="py-2 text-gray-800 hover:text-gray-500"
                  :key="item.router">{{ item.name }}</router-link>
              </ul>
            </div>
          </div>
          <div>
            <router-link
              class="navbar__logo text-white block h-8 w-auto lg:hidden"
              :to="{ name: 'Home' }">Killcode</router-link>
            <router-link
              class="navbar__logo text-white hidden h-8 w-auto lg:block"
              :to="{ name: 'Home' }">Killcode</router-link>
          </div>
          <div v-if="infoAuth" class="flex items-center sm:hidden">
            <div class="relative">
              <button @click="showNotifications($event)"
                class="relative z-10 block rounded-md pl-3 pr-1 py-2 focus:outline-none">
                <i class='bx bxs-bell h-5 w-5 text-white'></i>
              </button>

              <div
                class="list-notification absolute right-0 mt-2 bg-white rounded-md shadow-lg overflow-hidden z-20 hidden"
                style="width:20rem;">
                <div class="flex items-center justify-between px-3 pt-2">
                  <h4 class="font-bold">Thông báo</h4>
                  <span class="cursor-pointer px-1 py-1 text-lg"
                    @click="readAllNotice(infoAuth.id)">
                    <i class='bx bx-check-double'></i>
                  </span>
                </div>
                <div class="">
                  <router-link
                    :to="{ name: 'PostDetail', params: { id: notification.route.params.id } }"
                    v-for="(notification, index) in notifications"
                    :key="notification.id"
                    @click="readNotice(notification.id, notification.post_id, index)"
                    class="flex items-center px-4 py-3 border-b  -mx-2 hover:bg-gray-100"
                    :class="[notification.read ? '' : 'bg-gray-100 ']">
                    <img class="h-8 w-8 rounded-full object-cover mx-1"
                      :src="notification.sender.avatar" alt="avatar">
                    <div class="flex flex-col">
                      <p class="text-gray-600 text-sm mx-2">
                        <span v-html="notification.content"></span>
                      </p>
                      <p class="text-xs mx-2 text-gray-400">{{
                        formatDateTimeFB(new Date(notification.created_at)) }}
                      </p>
                    </div>
                  </router-link>
                </div>
                <router-link
                  :to="{ name: 'ListAllNotice', params: { id: infoAuth.id } }"
                  class="block bg-gray-800 text-white text-center text-sm py-1.5 read-all-notification">Xem
                  tất cả thông báo</router-link>
              </div>
            </div>
            <div class="navbar__dropdown dropdown">
              <button class="navbar__dropdown-toggle" type="button"
                id="dropdownMenuButton1" @click="dropdownIconUser($event)">
                <div class="navbar__logo-user">
                  <img class="navbar__logo-user" :src="infoAuth.avatar"
                    alt="user" />
                </div>
              </button>
              <ul
                class="dropdownIconUserMenu navbar__dropdown-menu dropdown-menu hidden py-0"
                style="width: 17rem;">
                <li
                  class="flex items-center navbar__ dropdown-item bg-gray-100 py-2">
                  <img class="rounded-full w-14 h-14" :src="infoAuth.avatar"
                    alt="user" />
                  <div class="flex flex-col pl-1.5">
                    <span class="text-blue-500 text-md font-bold">{{
                      infoAuth.name }}</span>
                    <span class="text-gray-500 text-sm">{{ infoAuth.email
                    }}</span>
                  </div>
                </li>
                <li>
                  <router-link class="navbar__ dropdown-item flex items-center"
                    @click="hideItemDropdownIconUser"
                    :to="{ name: 'Profile', params: { id: infoAuth.id } }">
                    <i class='bx bxs-user pr-1.5'></i> Hồ sơ cá nhân
                  </router-link>
                </li>
                <li>
                  <router-link :to="{ name: 'PostCreate' }"
                    @click="hidePencilWrite"
                    class="px-3 py-2 flex items-center hover:bg-gray-100 hover:text-current">
                    <i class='bx bxs-pencil pr-1'></i>
                    Viết bài
                  </router-link>
                </li>
                <li>

                  <router-link :to="{ name: 'PostCreate' }"
                    @click="hidePencilWrite"
                    class="px-3 py-2 flex items-center hover:bg-gray-100 hover:text-current">
                    <i class='bx bx-question-mark pr-1'></i> Đặt câu hỏi
                  </router-link>
                </li>
                <li v-if="isAdmin.indexOf('admin') != -1">
                  <router-link class="navbar__ dropdown-item flex items-center"
                    @click="hideItemDropdownIconUser" :to="{ name: 'Dashboard' }">
                    <i class='bx bx-shield-quarter pr-1.5'></i> Quản trị hệ
                    thống
                  </router-link>
                </li>
                <li>
                  <router-link class="navbar__ dropdown-item flex items-center"
                    @click="hideItemDropdownIconUser"
                    :to="{ name: 'PostDrafts' }">
                    <i class='bx bxs-notepad pr-1.5'></i>
                    Quản lí nội dung
                  </router-link>
                </li>
                <li>
                  <button class="navbar__ dropdown-item flex items-center"
                    @click="authStore.handleLogout(), hideItemDropdownIconUser">
                    <i class='bx bxs-log-out pr-1.5'></i>
                    Đăng xuất
                  </button>
                </li>
              </ul>
            </div>
          </div>
          <div v-else class="sm:hidden">
            <BtnLogin />
          </div>
        </div>
        <div class="hidden sm:ml-6 sm:block flex">
          <div class="flex">
            <div class="flex space-x-4">
              <router-link :to="{ name: item.router }" v-for="item in navigation"
                :key="item.name"
                class="flex items-center"
                :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:text-white hover:bg-gray-700', 'block rounded-md px-3 py-2 text-base font-medium']"
                :aria-current="item.current ? 'page' : undefined">{{ item.name
                }}</router-link>
            </div>
            <div
              class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
              <div class="relative" v-if="infoAuth">
                <button @click="showNotifications($event)"
                  class="relative z-10 block rounded-md pl-3 pr-1 py-2 focus:outline-none">
                  <i class='bx bxs-bell h-5 w-5 text-white'></i>
                </button>

                <div
                  class="list-notification absolute right-0 mt-2 bg-white rounded-md shadow-lg overflow-hidden z-20 hidden"
                  style="width:20rem;">
                  <div class="flex items-center justify-between px-3 pt-2">
                    <h4 class="font-bold">Thông báo</h4>
                    <span class="cursor-pointer px-1 py-1 text-lg"
                      @click="readAllNotice(infoAuth.id)">
                      <i class='bx bx-check-double'></i>
                    </span>
                  </div>
                  <div class="">
                    <router-link
                      :to="{ name: 'PostDetail', params: { id: notification.route.params.id } }"
                      v-for="(notification, index) in notifications"
                      :key="notification.id"
                      @click="readNotice(notification.id, notification.post_id, index)"
                      class="flex items-center px-4 py-3 border-b  -mx-2 hover:bg-gray-100"
                      :class="[notification.read ? '' : 'bg-gray-100 ']">
                      <img class="h-8 w-8 rounded-full object-cover mx-1"
                        :src="notification.sender.avatar" alt="avatar">
                      <div class="flex flex-col">
                        <p class="text-gray-600 text-sm mx-2">
                          <span v-html="notification.content"></span>
                        </p>
                        <p class="text-xs mx-2 text-gray-400">{{
                          formatDateTimeFB(new Date(notification.created_at)) }}
                        </p>
                      </div>
                    </router-link>
                  </div>
                  <router-link
                    :to="{ name: 'ListAllNotice', params: { id: infoAuth.id } }"
                    class="block bg-gray-800 text-white text-center text-sm py-1.5 read-all-notification">Xem
                    tất cả thông báo</router-link>
                </div>
              </div>
              <div class="relative" v-if="infoAuth">
                <button @click="showPencilWrite($event)"
                  class="relative z-10 block rounded-md py-2 pr-3 pl-1 focus:outline-none">
                  <i class='bx bxs-edit-alt h-5 w-5 text-white'></i>
                </button>

                <div
                  class="pencil-write absolute right-0 mt-2 bg-white rounded-md shadow-lg overflow-hidden z-20 hidden"
                  style="width:10rem;">
                  <ul class="">
                    <router-link :to="{ name: 'PostCreate' }"
                      @click="hidePencilWrite"
                      class="px-3 py-2 flex items-center hover:bg-gray-100 hover:text-current">
                      <i class='bx bxs-pencil pr-1'></i>
                      Viết bài
                    </router-link>
                    <router-link :to="{ name: 'PostCreate' }"
                      @click="hidePencilWrite"
                      class="px-3 py-2 flex items-center hover:bg-gray-100 hover:text-current">
                      <i class='bx bx-question-mark pr-1'></i> Đặt câu hỏi
                    </router-link>
                  </ul>
                </div>
              </div>
              <div class="navbar__group-icon">
                <template v-if="!infoAuth">
                  <BtnLogin />
                </template>
                <template v-else>
                  <!-- user -->
                  <div class="navbar__dropdown dropdown">
                    <button class="navbar__dropdown-toggle" type="button"
                      id="dropdownMenuButton1" @click="dropdownIconUser($event)">
                      <div class="navbar__logo-user">
                        <img class="navbar__logo-user" :src="infoAuth.avatar"
                          alt="user" />
                      </div>
                    </button>
                    <ul
                      class="dropdownIconUserMenu navbar__dropdown-menu dropdown-menu hidden py-0"
                      style="width: 17rem;">
                      <li
                        class="flex items-center navbar__ dropdown-item bg-gray-100 py-2">
                        <img class="rounded-full w-14 h-14" :src="infoAuth.avatar"
                          alt="user" />
                        <div class="flex flex-col pl-1.5">
                          <span class="text-blue-500 text-md font-bold">{{
                            infoAuth.name }}</span>
                          <span class="text-gray-500 text-sm">{{ infoAuth.email
                          }}</span>
                        </div>
                      </li>
                      <li>
                        <router-link
                          class="navbar__ dropdown-item flex items-center"
                          @click="hideItemDropdownIconUser"
                          :to="{ name: 'Profile', params: { id: infoAuth.id } }">
                          <i class='bx bxs-user pr-1.5'></i> Hồ sơ cá nhân
                        </router-link>
                      </li>
                      <li v-if="isAdmin.indexOf('admin') != -1">
                        <router-link
                          class="navbar__ dropdown-item flex items-center"
                          @click="hideItemDropdownIconUser"
                          :to="{ name: 'Dashboard' }">
                          <i class='bx bx-shield-quarter pr-1.5'></i> Quản trị hệ
                          thống
                        </router-link>
                      </li>
                      <li>
                        <router-link
                          class="navbar__ dropdown-item flex items-center"
                          @click="hideItemDropdownIconUser"
                          :to="{ name: 'PostDrafts' }">
                          <i class='bx bxs-notepad pr-1.5'></i>
                          Quản lí nội dung
                        </router-link>
                      </li>
                      <li>
                        <button class="navbar__ dropdown-item flex items-center"
                          @click="authStore.handleLogout(), hideItemDropdownIconUser">
                          <i class='bx bxs-log-out pr-1.5'></i>
                          Đăng xuất
                        </button>
                      </li>
                    </ul>
                  </div>
                  <!--  -->
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="main-content absolute mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="text-center leading-6" style="min-width: 50rem;">
        <h1
          class="text-yellow-400 lg:text-4xl md:text-3xl sm:text-2xl text-2xl uppercase font-bold">
          Website chia sẻ kiến thức lập trình</h1>
        <p class="text-white lg:text-lg sm:text-md">Bạn đang gặp phải vấn đề cần
          được giải đáp? <br> Vậy thì đây sẽ là nơi sẽ giúp bạn giải quyết hết vấn
          đề của bạn.</p>
        <router-link :to="{ name: 'Home' }"
          class="mt-2 py-2 px-3 inline-flex justify-center items-center rounded-sm border font-semibold bg-gray-900 text-white focus:outline-none transition-all text-sm hover:bg-gray-800 leading-3">Xem
          ngay</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from 'axios'
import { ref, onMounted, computed, onBeforeUnmount } from "vue";
import { useAuthStore } from '@/stores/auth'
import BtnLogin from "@/components/ui/BtnLogin.vue";
import { formatDateTimeFB } from '@/assets/js/app.js'
const navigation = [
  { name: 'Chủ đề', router: 'TagsList', current: false },
  { name: 'Bài viết', router: 'PostsList', current: false },
  { name: 'Câu hỏi', router: 'QuestionsList', current: false },
]
const data = () => ({
  pusher: null,
  channel: null,
});
const authStore = useAuthStore()
const isAdmin = computed(() => {
  return authStore.getAuthRoles;
});
const infoAuth = computed(() => {
  return authStore.getInfoUser;
});
const notifications = ref([]);

const showNotifications = (event) => {
  event.stopPropagation();
  let allHidden = true;
  $('.list-notification').each(function () {
    if (!$(this).is(':hidden')) {
      allHidden = false;
      return false; // thoát khỏi vòng lặp khi tìm thấy một phần tử không bị ẩn
    }
  });
  if (allHidden) {
    $('.list-notification').slideDown(300);
  } else {
    $('.list-notification').slideUp(300);
  }
}
const showMenuMobile = (event) => {
  event.stopPropagation();
  if ($('.menu-mobile').first().is(":hidden")) {
    $('.menu-mobile').slideDown(300);
  } else {
    $('.menu-mobile').slideUp(300);
  }
}
const dropdownIconUser = (event) => {
  event.stopPropagation();
  let allHidden = true;
  $('.dropdownIconUserMenu').each(function () {
    if (!$(this).is(':hidden')) {
      allHidden = false;
      return false; // thoát khỏi vòng lặp khi tìm thấy một phần tử không bị ẩn
    }
  });
  if (allHidden) {
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
      notifications.value.map(function (item) {
        if (item.sender.avatar.indexOf('http://localhost:8000/images/') == -1) {
          return item.sender.avatar = 'http://localhost:8000/images/' + item.sender.avatar
        }
      })
      // console.log('thong baooooo',response.data.data)
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
    if (!$(event.target).closest('.showPencilWrite').length) {
      $('.pencil-write').slideUp(300);
    }
    if (!$(event.target).closest('.showMenuMobile').length) {
      $('.menu-mobile').slideUp(300);
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
      notifications.value.pop();
    });

    data.channel.bind(`event-notification-${userId}`, (notification) => {
      notifications.value.unshift(notification);
      notifications.value.pop();
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
  // data.channel?.unbind?.();
  // data.pusher?.disconnect?.();
});
</script>

<style scoped>
.main {
  width: 100vw;
  height: 100vh;
  z-index: 99;
}

.main-background {
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-image: url("@/assets/img/luxfon.com-18586.jpg");
  background-size: cover;
  background-position: center center;
  filter: brightness(0.3);
  z-index: -1;
}

.main-nav {
  background-color: transparent;
}

.main-nav .main-nav__logo {
  color: var(--color-light-mode);
  text-decoration: none;
  font-size: 1.25rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
}

.main-content {
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

/* a:hover {
    color: black
} */
.navbar__logo {
  color: var(--color-dark-mode);
  text-decoration: none;
  font-size: 1.25rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
}

.upper-space {
  padding-bottom: 6rem;
  /* background: #dee1e2; */
}

.navbar__logo {
  color: var(--color-dark-mode);
  text-decoration: none;
  font-size: 1.25rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
}

.navbar__group {
  display: flex;
  align-items: center;
}

.navbar__navigation {
  position: relative;
  display: flex;
  gap: 30px;
}

.navbar__navigation li {
  list-style: none;
}

.navbar__navigation li a {
  position: relative;
  text-decoration: none;
  font-size: 1em;
  color: var(--color-dark-mode);
  text-transform: uppercase;
  letter-spacing: 0.2em;
}

.navbar__navigation li a::before {
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

.navbar__navigation li a:hover::before {
  transform: scale(1);
  transform-origin: left;
}

.navbar__group-icon {
  display: flex;
  align-items: center;
  margin-left:15px;
  gap: 20px;
}

.navbar__dropdown-menu {
  left: auto;
  right: 0;
}

.navbar__dropdown-toggle {
  border: 2px solid black;
  border-radius: 50%;
}

.navbar__logo-user img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.navbar__logo-user {
  width: 35px;
  height: 35px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
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

  .navbar__navigation {
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
