import { defineStore } from "pinia";
import axios from "axios";
import { pageLoading, pageLoaded } from "@/assets/js/app.js"

export const useAuthStore = defineStore("auth", {
    state: () => ({
        authUser: null,
        authRoles: null,
        authPermissions: null,
        authErrors: [],
        authStatus: null,
    }),
    getters: {
        getInfoUser: (state) => state.authUser,
        errors: (state) => state.authErrors,
        status: (state) => state.authStatus,
        getAuthRoles: (state) => state.authRoles,
        getAuthPermissions: (state) => state.authPermissions,
    },
    actions: {
        async getToken() {
            await axios.get("/sanctum/csrf-cookie")
        },
        async getUser() {
            try {
                const data = await axios.get("/api/user");
                if(data.data) {
                    data.data.user.avatar = 'http://localhost:8000/images/' + data.data.user.avatar
                    this.authUser = data.data.user;
                    console.log(data.data);
                    this.authRoles = data.data.roles;
                    this.authPermissions = data.data.permissions;
                }else {
                }
                
            } catch (error) {
                localStorage.removeItem('isAuthenticated')
            }
        },
        async handleLogin(data) {
            pageLoading()
            this.authErrors = [];
            try {
                await axios.post("/login", {
                    email: data.email,
                    password: data.password,
                });
                await this.getUser()
                pageLoaded()
                localStorage.setItem('isAuthenticated', true)
                this.router.push("/home");
            } catch (error) {
                if (error.response.status == 422) {
                    pageLoaded()
                    this.authErrors = error.response.data.errors;
                    console.log(this.authErrors);
                }
            }
        },

        async handleRegister(data) {
            pageLoading()
            this.authErrors = [];
            try {
                await axios.post("/register", {
                    name: data.name,
                    email: data.email,
                    password: data.password,
                    password_confirmation: data.password_confirmation,
                });
                // await axios.post("/email/verification-notification");
                // this.router.push("/send-verify-email");
                pageLoaded()
                localStorage.setItem('isAuthenticated', true)
                await this.getUser()
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
                    pageLoaded()
                    this.authErrors = error.response.data.errors;
                    console.log(this.authErrors);
                }
            }
        },
        async handleLogout() {
            await axios.post("/logout");
            localStorage.removeItem('isAuthenticated')
            this.authUser = null;
            this.router.push("/home");
        },
        async handleForgotPassword(email) {
            pageLoading()
            this.authErrors = [];
            try {
                const response = await axios.post("/forgot-password", {
                    email: email,
                });
                this.authStatus = response.data.status;
                pageLoaded()
            } catch (error) {
                if (error.response.status == 422) {
                    pageLoaded()
                    this.authErrors = error.response.data.errors;
                    this.authStatus = null;
                }
            }
        },
        async handleResetPassword(resetData) {
            pageLoading()
            this.authErrors = [];
            try {
                const response = await axios.post("/reset-password", resetData);
                pageLoaded()
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
                    pageLoaded()
                    this.authErrors = error.response.data.errors;
                    this.authStatus = null;
                }
            }
        }
    },
});
