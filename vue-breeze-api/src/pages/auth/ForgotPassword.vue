<script setup>
import { ref, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
const authStore = useAuthStore();
onMounted(async () => {
    authStore.authErrors = [];
});
const form = ref({
    email: "",
});
</script>
<template>
    <!-- component -->
    <div id="content" role="main" class="flex flex-col h-screen bg-gray-100 realative">
        <!-- BUTTON BACK HOME  -->
        <router-link :to="{name: 'Home'}" class="absolute top-3.5 left-3.5 py-1 px-2.5 bg-slate-800 rounded-sm hover:bg-slate-700 font-medium text-white text-lg">
            <i class='bx bxs-home'></i>
        </router-link>
        <div
            class="grid place-items-center mx-2 my-20 sm:my-auto"
        >
            <div class="p-6 sm:p-10 bg-white rounded-xl shadow-lg dark:bg-gray-800 dark:border-gray-700">
                <div class="text-center">
                    <h1
                        class="block text-2xl font-bold text-gray-800 dark:text-white"
                    >
                        Quên mật khẩu?
                    </h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Bạn nhớ mật khẩu của bạn?
                        <router-link
                            :to="{ name: 'Login' }"
                            class="text-blue-600 decoration-2 font-medium"
                        >
                            Đăng nhập tại đây
                        </router-link>
                    </p>
                </div>

                <div class="mt-4">
                    <form
                        @submit.prevent="
                            authStore.handleForgotPassword(form.email)
                        "
                    >
                        <div class="grid gap-y-4">
                            <div>
                                <label
                                    for="email"
                                    class="block text-sm font-bold ml-1 mb-2 dark:text-white"
                                    >E-mail</label
                                >
                                <div class="relative">
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md text-sm focus:border-black shadow-sm"
                                        aria-describedby="email-error"
                                        v-model="form.email"
                                    />
                                </div>
                                <div v-if="(authStore.errors.email && authStore.errors.email[0] == 'The email field is required.')">
                                    <p
                                        class="text-xs text-red-600 mt-2"
                                        id="email-error"
                                    >
                                        Vui lòng nhập e-mail của bạn.
                                    </p>
                                </div>
                                <div v-else-if="authStore.errors.email">
                                    <p
                                        class="text-xs text-red-600 mt-2"
                                        id="email-error"
                                    >
                                        Vui lòng đợi trước khi thử lại.
                                    </p>
                                </div>
                                <div
                                    class="p-2 mt-2 text-green-900 font-semibold bg-green-300 rounded-md"
                                    v-if="authStore.authStatus"
                                >
                                    Chúng tôi đã gửi email liên kết đặt lại mật
                                    khẩu của bạn!
                                </div>
                            </div>
                            <button
                                type="submit"
                                class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm hover:bg-gray-700 hover:shadow-none leading-3"
                            >
                                Đặt lại mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
