<template>
  <Disclosure as="nav" class="main relative" v-slot="{ open }">
    <div class="main-background absolute"></div>
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button-->
          <DisclosureButton
            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
            <span class="sr-only">Open main menu</span>
            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
          </DisclosureButton>
        </div>
        <div
          class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
          <div class="flex flex-shrink-0 items-center"></div>
          <router-link class="navbar__logo text-white block h-8 w-auto lg:hidden"
            :to="{ name: 'Home' }">Killcode</router-link>
          <router-link class="navbar__logo text-white hidden h-8 w-auto lg:block"
            :to="{ name: 'Home' }">Killcode</router-link>
        </div>
        <div class="hidden sm:ml-6 sm:block flex">
          <div class="flex">
            <div class="flex space-x-4">
              <a v-for="item in navigation" :key="item.name" :href="item.href"
                :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:text-white hover:bg-gray-700', 'block rounded-md px-3 py-2 text-base font-medium']"
                :aria-current="item.current ? 'page' : undefined">{{ item.name
                }}</a>
            </div>
            <div
              class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
              <button type="button"
                class="rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                <span class="sr-only">View notifications</span>
                <BellIcon class="h-6 w-6" aria-hidden="true" />
              </button>

              <!-- Profile dropdown -->
              <template v-if="!authStore.getInfoUser">
                <BtnLogin></BtnLogin>
              </template>
              <template v-else>
                <Menu as="div" class="relative ml-3">
                  <div>
                    <MenuButton
                      class="flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                      <span class="sr-only">Open user menu</span>
                      <img class="h-8 w-8 rounded-full"
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="" />
                    </MenuButton>
                  </div>
                  <transition
                    enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95">
                    <MenuItems
                      class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                      <MenuItem v-slot="{ active }">
                      <a href="#"
                        :class="[active ? 'bg-gray-100' : '', 'hover:text-black block px-4 py-2 text-sm text-gray-700']">Hồ
                        sơ</a>
                      </MenuItem>
                      <MenuItem v-slot="{ active }">
                      <a href="#"
                        :class="[active ? 'bg-gray-100' : '', 'hover:text-black block px-4 py-2 text-sm text-gray-700']">Cài
                        đặt</a>
                      </MenuItem>
                      <MenuItem v-slot="{ active }">
                      <button @click="authStore.handleLogout()"
                        :class="[active ? 'bg-gray-100' : '', 'hover:text-black inline-block px-4 py-2 text-sm text-gray-700 w-100 text-left']">Đăng
                        xuất</button>
                      </MenuItem>
                    </MenuItems>
                  </transition>
                </Menu>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="main-content absolute mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="text-center leading-6">
        <h1 class="text-yellow-400 text-2xl uppercase font-bold">Thư viện khóa học
          lập trình từ cơ bản đến nâng cao</h1>
        <p class="text-white">Python ? C++? C# hay Java? <br> Bạn lựa chọn ngôn
          ngữ nào để bắt đầu chặng đường trở thành lập trình viên của mình?</p>
        <router-link :to="{ name: 'Home' }"
          class="mt-2 py-2 px-3 inline-flex justify-center items-center rounded-sm border font-semibold bg-gray-900 text-white focus:outline-none transition-all text-sm hover:bg-gray-800 leading-3">Học
          ngay</router-link>
      </div>
    </div>

    <DisclosurePanel class="sm:hidden">
      <div class="space-y-1 px-2 pt-2 pb-3">
        <DisclosureButton v-for="item in navigation" :key="item.name" as="a"
          :href="item.href"
          :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:text-white hover:bg-gray-700', 'block rounded-md px-3 py-2 text-base font-medium']"
          :aria-current="item.current ? 'page' : undefined">{{ item.name }}
        </DisclosureButton>
      </div>
    </DisclosurePanel>
  </Disclosure>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { ref, onMounted } from "vue";
import { useAuthStore } from '@/stores/auth'
import BtnLogin from "@/components/ui/BtnLogin.vue";
const navigation = [
  { name: 'Trang chủ', href: '#', current: false },
  { name: 'Giới thiệu', href: '#', current: false },
  { name: 'Liên hệ', href: '#', current: false },
  { name: 'Bài viết', href: '#', current: false },
]
const authStore = useAuthStore()
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
</style>
