import { defineStore } from "pinia";
import axios from "axios";
import { pageLoading, pageLoaded } from "@/assets/js/app.js";

export const useUserStore = defineStore("user", {
    state: () => ({
        authUser: null,
        authRoles: null,
        authPermissions: null,
        userError:'',
        dataUser: null
    }),
    getters: {
        getInfoUser: (state) => state.authUser,
        getInfoUserById: (state) => state.dataUser,
        getAuthRoles: (state) => state.authRoles,
        getAuthPermissions: (state) => state.authPermissions,
        getUserError: (state) => state.userError,
    },
    actions: {
        async getToken() {
            await axios.get("/sanctum/csrf-cookie");
        },
        async getUser() {
            try {
                const data = await axios.get("/api/user");
                if (data.data) {
                    this.authUser = data.data.user;
                    this.authRoles = data.data.roles;
                    this.authPermissions = data.data.permissions;
                    // console.log(data.data);
                } else {
                }
            } catch (error) {
                localStorage.removeItem("isAuthenticated");
            }
        },
        async getUserById(id) {
                await axios.get(`/api/user/${id}`)
                .then(res => {
                    this.dataUser = res.data.user;
                })
                .catch (error => {
                    console.log(error);
                    // localStorage.removeItem("isAuthenticated");
                })
        },
        async handleUpdateProfile(formData, id) {
            try {
                await axios
                    .post("api/user-detail/update-profile", formData)
                    .then((res) => {
                        // console.log(res);
                        this.getUserById(id)
                        this.userError = 'success!'
                    });
            } catch (error) {
                this.userError = error.response.data.error
                console.log(this.userError);
            }
        },
    },
});
