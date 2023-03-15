import { defineStore } from "pinia";
import axios from "axios";

export const useRolesStore = defineStore("roles", {
    state: () => ({
        roles: null,
        users: null,
        authErrors: [],
        roleErrors: [],
        authStatus: null,
    }),
    getters: {
        listRoles: (state) => state.roles,
        listUsers: (state) => state.users,
        errors: (state) => state.authErrors,
        getRoleErrors: (state) => state.roleErrors,
        status: (state) => state.authStatus,
    },
    actions: {
        async getRoles() {
            try {
                const response = await axios.get("/api/roles");
                if (response.data) {
                    this.roles = response.data.data;
                }
            } catch (error) {}
        },
        async getUsers() {
            try {
                const response = await axios.get("/api/users");
                if (response.data) {
                    this.users = response.data.data;
                    // console.log('api role', response.data)
                }
            } catch (error) {}
        },
        async handleAddRole(data) {
            await axios
                .post("/api/roles", data)
                .then((response) => {
                    this.getRoles();
                    this.roleErrors = "add success!";
                })
                .catch((error) => {
                    this.roleErrors = error.response.data.error;
                });
        },
        async handleDeleteRole(id) {
            await axios
                .delete(`/api/roles/${id}`)
                .then((response) => {
                    this.getRoles();
                    this.roleErrors = "delete success!";
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        // Xóa thất bại vì có ràng buộc
                        this.roleErrors = error.response.data.error;
                        console.log(error.response.data.error);
                    } else {
                        // Lỗi server khác
                        console.error(error);
                    }
                });
        },
        async handleEditRole(id, form) {
            await axios
                .put(`/api/roles/${id}`, form)
                .then((response) => {
                    this.getRoles();
                    this.roleErrors = "update success!";
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        // Xóa thất bại vì có ràng buộc
                        this.roleErrors = error.response.data.error;
                        console.log(error.response.data.error);
                    } else {
                        // Lỗi server khác
                        console.error(error);
                    }
                });
        },
    },
});
