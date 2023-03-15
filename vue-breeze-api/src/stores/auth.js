import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        authUser: null,
        authErrors: [],
        authStatus: null,
    }),
    getters: {
        user: (state) => state.authUser,
        errors: (state) => state.authErrors,
        status: (state) => state.authStatus,
    },
    actions: {
        async getToken() {
            await axios.get("/sanctum/csrf-cookie")
        },
        async getUser() {
            try {
                await this.getToken();
                const data = await axios.get("/api/user");
                if(data.data) {
                    this.authUser = data.data;
                }else {
                    localStorage.removeItem('isAuthenticated')
                }

            } catch (error) {
                
            }
        },
        async handleLogin(data) {
            await $('#loading').removeClass('hidden')
            this.authErrors = [];
            try {
                await this.getToken();
                const response = await axios.post("/login", {
                    email: data.email,
                    password: data.password,
                });
                console.log(response);
                await $('#loading').addClass('hidden')
                localStorage.setItem('isAuthenticated', true)
                this.router.push("/home");
            } catch (error) {
                if (error.response.status == 422) {
                    await $('#loading').addClass('hidden')
                    this.authErrors = error.response.data.errors;
                    console.log(this.authErrors);
                }
            }
        },
        async checkAuth() {
            return localStorage.getItem('isAuthenticated')
        },
        async handleRegister(data) {
            await $('#loading').removeClass('hidden')
            this.authErrors = [];
            try {
                await this.getToken();
                await axios.post("/register", {
                    name: data.name,
                    email: data.email,
                    password: data.password,
                    password_confirmation: data.password_confirmation,
                });
                // await axios.post("/email/verification-notification");
                // this.router.push("/send-verify-email");
                await $('#loading').addClass('hidden')
                await Swal.fire({
                    icon: 'success',
                    title: 'Đăng ký tài khoản thành công!',
                    confirmButtonText: 'Tiếp tục'
                }).then(result => {
                    if(result.isConfirmed || result) {
                        this.router.push("/home");
                    }
                })
            } catch (error) {
                if (error.response.status == 422) {
                    await $('#loading').addClass('hidden')
                    this.authErrors = error.response.data.errors;
                    console.log(this.authErrors);
                }
            }
        },
        async handleLogout() {
            await axios.post("/logout");
            localStorage.removeItem('isAuthenticated')
            this.authUser = null;
        },
        async handleForgotPassword(email) {
            await $('#loading').removeClass('hidden')
            this.authErrors = [];
            try {
                await this.getToken();
                const response = await axios.post("/forgot-password", {
                    email: email,
                });
                this.authStatus = response.data.status;
                await $('#loading').addClass('hidden')
            } catch (error) {
                if (error.response.status == 422) {
                    await $('#loading').addClass('hidden')
                    this.authErrors = error.response.data.errors;
                    this.authStatus = null;
                }
            }
        },
        async handleResetPassword(resetData) {
            await $('#loading').removeClass('hidden')
            this.authErrors = [];
            try {
                const response = await axios.post("/reset-password", resetData);
                await $('#loading').addClass('hidden')
                await Swal.fire({
                    icon: 'success',
                    title: 'Đổi mật khẩu thành công!',
                    confirmButtonText: 'Đóng'
                }).then(result => {
                    if(result.isConfirmed || result) {
                        this.router.push("/login");
                        this.authStatus = response.data.status;
                    }
                })
            } catch (error) {
                console.log(error.response);
                if (error.response.status == 422) {
                    await $('#loading').addClass('hidden')
                    this.authErrors = error.response.data.errors;
                    this.authStatus = null;
                }
            }
        }
    },
});
