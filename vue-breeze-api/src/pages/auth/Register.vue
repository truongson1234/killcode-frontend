<script setup>
    import { ref, onMounted } from 'vue'
    import { useAuthStore } from '@/stores/auth'
    const authStore = useAuthStore()
    onMounted(async () => {
        authStore.authErrors = []
    });
    const form = ref({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    })
    
</script>
<template>
    <div class="flex flex-col h-screen bg-gray-100 realative">
        <!-- BUTTON BACK HOME  -->
        <router-link :to="{name: 'Home'}" class="absolute top-3.5 left-3.5 py-1 px-2.5 bg-slate-800 rounded-sm hover:bg-slate-700 font-medium text-white text-lg">
            <i class='bx bxs-home'></i>
        </router-link>
        <!-- Auth Card Container -->
        <div class="grid place-items-center mx-2 my-20 sm:my-auto">
            <!-- Auth Card -->
            <div class="w-11/12 p-12 sm:w-8/12 md:w-6/12 lg:w-5/12 2xl:w-4/12 
                px-6 py-10 sm:px-10 sm:py-6 
                bg-white rounded-lg shadow-md lg:shadow-lg">

                <!-- Card Title -->
                <!-- <h2 class="text-center font-semibold text-3xl lg:text-4xl text-gray-800">
                    Register
                </h2> -->

                <form class="mt-10" @submit.prevent="authStore.handleRegister(form)">
                    <label for="name" class="block text-xs font-semibold text-gray-600 uppercase">Tên</label>
                    <input id="name" type="text" name="name" v-model="form.name" placeholder="Nhập tên của bạn..."
                        class="block w-full py-2 px-1 mt-1 mb-2
                        text-gray-800 appearance-none 
                        border-t-0 border-r-0 border-l-0 border-b-2 border-gray-100
                        focus:text-gray-500 focus:outline-none focus:border-gray-200" />
                    <div v-if="authStore.errors.name">
                        <span class="text-red-400 text-sm p-2 px-0">{{ authStore.errors.name[0] }}</span>
                    </div>

                    <!-- Email Input -->
                    <label for="email" class="block text-xs font-semibold text-gray-600 uppercase mt-4">E-mail</label>
                    <input id="email" type="email" name="email" v-model="form.email" placeholder="Nhập e-mail của bạn..." autocomplete="email"
                        class="block w-full py-2 px-1 mt-1 mb-2
                        text-gray-800 appearance-none 
                        border-t-0 border-r-0 border-l-0 border-b-2 border-gray-100
                        focus:text-gray-500 focus:outline-none focus:border-gray-200" />
                    <div v-if="authStore.errors.email">
                        <span class="text-red-400 text-sm p-2 px-0">{{ authStore.errors.email[0] }}</span>
                    </div>

                    <!-- Password Input -->
                    <label for="password" class="block text-xs font-semibold text-gray-600 uppercase mt-4">Mật khẩu</label>
                    <input id="password" type="password" name="password" v-model="form.password" placeholder="Nhập mật khẩu của bạn..." autocomplete="password"
                        class="block w-full py-2 px-1 mt-1 mb-2
                        text-gray-800 appearance-none 
                        border-t-0 border-r-0 border-l-0 border-b-2 border-gray-100
                        focus:text-gray-500 focus:outline-none focus:border-gray-200" />
                    <div v-if="authStore.errors.password">
                        <span class="text-red-400 text-sm p-2 px-0">{{ authStore.errors.password[0] }}</span>
                    </div>

                    <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 uppercase mt-4">Xác nhận mật khẩu</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" v-model="form.password_confirmation" placeholder="Nhập lại mật khẩu..." autocomplete="password_confirmation"
                        class="block w-full py-2 px-1 mt-1 mb-2
                        text-gray-800 appearance-none 
                        border-t-0 border-r-0 border-l-0 border-b-2 border-gray-100
                        focus:text-gray-500 focus:outline-none focus:border-gray-200" />
                    <div v-if="authStore.errors.password_confirmation">
                        <span class="text-red-400 text-sm p-2 px-0">{{ authStore.errors.password_confirmation[0] }}</span>
                    </div>
                    <!-- Auth Buttton -->
                    <button type="submit"
                        class="w-full py-3 mt-10 bg-gray-800 rounded-sm
                        font-medium text-white uppercase
                        focus:outline-none hover:bg-gray-700 hover:shadow-none">
                        Đăng ký
                    </button>

                    <!-- Another Auth Routes -->
                    <div class="sm:flex sm:flex-wrap mt-8 sm:mb-4 text-sm text-center">

                        <router-link :to="{ name: 'Login' }" class="flex-1 text-gray-500 text-md mx-4 my-1 sm:my-auto">
                            Bạn đã có tài khoản? Đăng nhập
                        </router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<style scoped>
.focus\:border-gray-200:focus {
    box-shadow: none;
}
</style>