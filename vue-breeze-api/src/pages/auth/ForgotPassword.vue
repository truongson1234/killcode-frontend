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
    <main id="content" role="main" class="w-full max-w-md mx-auto p-6">
        <div
            class="mt-7 bg-white rounded-xl shadow-lg dark:bg-gray-800 dark:border-gray-700"
        >
            <div class="p-4 sm:p-7">
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
                            class="text-blue-600 decoration-2 hover:underline font-medium"
                        >
                            Đăng nhập tại đây
                        </router-link>
                    </p>
                </div>

                <div class="mt-5">
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
                                        class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                                        aria-describedby="email-error"
                                        v-model="form.email"
                                    />
                                </div>
                                <div v-if="authStore.errors.email">
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
                                class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800"
                            >
                                Đặt lại mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</template>
