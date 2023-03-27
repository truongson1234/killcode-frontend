<template>
  <div>
    <div class="upper-space"></div>
    <header class="navbar" :class="{ open: navbarEl }">
      <div class="container">
        <router-link class="navbar__logo"
          :to="{ name: 'Home' }">Killcode</router-link>
        <div class="navbar__group">
          <ul class="navbar__navigation">
            <li>
              <router-link :to="{ name: 'QuestionList' }">Câu hỏi</router-link>
            </li>
            <li>
              <router-link :to="{ name: 'Test' }">Test</router-link>
            </li>
            <li>
              <router-link :to="{ name: 'PostsList' }">Bài viết</router-link>
            </li>
          </ul>
          <div class="navbar__group-icon">
            <template v-if="!authStore.getInfoUser">
              <BtnLogin />
            </template>
            <template v-else>
              <!-- user -->
              <div class="navbar__dropdown dropdown">
                <button
                  class="navbar__dropdown-toggle btn btn-secondary dropdown-toggle"
                  type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <div class="navbar__logo-user">
                    <img class="navbar__logo-user"
                      src="https://scontent.fhan4-2.fna.fbcdn.net/v/t1.6435-9/149299062_232989691790324_2796829381264086336_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=09cbfe&_nc_ohc=xSgUwUshPDIAX_YWlPi&_nc_ht=scontent.fhan4-2.fna&oh=00_AfATcRKgKC6HOtrIudxtwXaQj0z7TlcyK_SPiDv43zMjSA&oe=6421D58C"
                      alt="user">
                  </div>
                </button>
                <ul class="navbar__dropdown-menu dropdown-menu"
                  aria-labelledby="dropdownMenuButton1">
                  <li><router-link class="navbar__ dropdown-item"
                      :to="{ name: 'User' }">Hồ sơ</router-link></li>
                  <li v-if="isAdmin.indexOf('admin') != -1"><router-link
                      class="navbar__ dropdown-item"
                      :to="{ name: 'Dashboard' }">Quản trị</router-link></li>
                  <li><router-link class="navbar__ dropdown-item"
                      :to="{ name: 'PostsCreate' }">Viết bài</router-link></li>
                  <li>
                    <BtnDarkMode />
                  </li>
                  <li><button class="navbar__ dropdown-item" href="#"
                      @click="authStore.handleLogout()">Đăng xuất</button></li>
                </ul>
              </div>
              <!--  -->
            </template>
            <i class="navbar__toggle-menu bx bx-menu" @click="showMenuRepon"></i>
          </div>
        </div>
      </div>
    </header>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import BtnDarkMode from "@/components/ui/BtnDarkMode.vue";
import BtnLogin from "@/components/ui/BtnLogin.vue";
import { useAuthStore } from '@/stores/auth'
const authStore = useAuthStore()
var navbarEl = ref(false);
const isAdmin = computed(() => {
  return authStore.getAuthRoles
})
const showMenuRepon = () => {
  navbarEl.value = !navbarEl.value;
};
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

.navbar .navbar__dropdown-toggle {
  padding: 5px 8px;
  border: 2px solid #333;
  background: var(--color-dark-mode);

}

.navbar .navbar__dropdown-toggle::after {
  display: none;
}

.navbar .navbar__logo-user {
  width: 20px;
  height: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
}

.navbar .navbar__logo-user img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.navbar .navbar__toggle-menu {
  position: relative;
  display: none;
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
