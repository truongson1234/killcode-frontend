<script setup>
    import { ref, onMounted } from 'vue'
    import { useAuthStore } from '@/stores/auth'
    const authStore = useAuthStore()
    onMounted(async () => {
        authStore.authErrors = []
    });
    const form = ref({
        email: '',
        password: ''
    })
</script>
<template>
    <div class="flex flex-col h-screen bg-gray-100">
        <div class="grid place-items-center mx-2 my-20 sm:my-auto">
            <div class="w-11/12 p-12 sm:w-8/12 md:w-6/12 lg:w-5/12 2xl:w-4/12 
                px-6 py-10 sm:px-10 sm:py-6 
                bg-white rounded-lg shadow-md lg:shadow-lg">

                <!-- <h2 class="text-center font-semibold text-3xl lg:text-4xl text-gray-800">
                    Đăng nhập
                </h2> -->

                <form class="mt-10" @submit.prevent="authStore.handleLogin(form)">
                    <!-- Email Input -->
                    <label for="email" class="block text-xs font-semibold text-gray-600 uppercase">E-mail</label>
                    <input id="email" type="email" name="email" v-model="form.email" placeholder="Địa chỉ e-mail" autocomplete="email"
                        class="block w-full py-2 px-1 mt-1 mb-2
                        text-gray-800 appearance-none 
                        border-b-2 border-gray-100
                        focus:text-gray-500 focus:outline-none focus:border-gray-200" />
                    <div v-if="authStore.errors.email">
                        <span class="text-red-400 text-sm p-2 px-0">{{ authStore.errors.email[0] }}</span>
                    </div>
                    <!-- Password Input -->
                    <label for="password" class="block mt-4 text-xs font-semibold text-gray-600 uppercase">Mật khẩu</label>
                    <input id="password" type="password" name="password" v-model="form.password" placeholder="Mật khẩu" autocomplete="current-password"
                        class="block w-full py-2 px-1 mt-1 mb-2
                        text-gray-800 appearance-none 
                        border-b-2 border-gray-100
                        focus:text-gray-500 focus:outline-none focus:border-gray-200" />
                    <div v-if="authStore.errors.password">
                        <span class="text-red-400 text-sm p-2 px-0">{{ authStore.errors.password[0] }}</span>
                    </div>
                    <!-- Auth Buttton -->
                    <button type="submit"
                        class="w-full py-3 mt-10 bg-gray-800 rounded-sm
                        font-medium text-white uppercase
                        focus:outline-none hover:bg-gray-700 hover:shadow-none">
                        Đăng nhập
                    </button>

                    <!-- Another Auth Routes -->
                    <div class="sm:flex sm:flex-wrap mt-8 sm:mb-4 text-sm text-center">
                        <router-link :to="{name: 'ForgotPassword'}" class="flex-2 underline">
                            Quên mật khẩu?
                        </router-link>

                        <p class="flex-1 text-gray-500 text-md mx-4 my-1 sm:my-auto">
                            hoặc
                        </p>
            
                        <router-link :to="{ name: 'Register' }" class="flex-2 underline">
                            Tạo mới tài khoản?
                        </router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>