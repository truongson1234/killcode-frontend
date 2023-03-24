import { defineStore } from "pinia";
import axios from "axios";

export const useRolesStore = defineStore("roles", {
    state: () => ({
        roles: null,
        users: null,
        permissions: null,
        authErrors: [],
        roleErrors: [],
        permissionErrors: [],
        rolePermissions: [],
        permissionRoles: [],
        authStatus: null,
        userRoleError: "",
        userPermissionError: "",
        detailUser: {
            roles: [],
            permissions: []
        }
    }),
    getters: {
        listRoles: (state) => state.roles,
        listUsers: (state) => state.users,
        listPermissions: (state) => state.permissions,
        errors: (state) => state.authErrors,
        getRoleErrors: (state) => state.roleErrors,
        getPermissionErrors: (state) => state.roleErrors,
        getPermissionErrors: (state) => state.permissionErrors,
        status: (state) => state.authStatus,
        getUserRoleError: (state) => state.userRoleError,
        getUserPermissionError: (state) => state.userPermissionError,
        getRolePermissions: (state) => state.rolePermissions,
        getPermissionRoles: (state) => state.permissionRoles,
        getDetailUser: (state) => state.detailUser,
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
        async getPermissions() {
            try {
                const response = await axios.get("/api/permissions");
                if (response.data) {
                    this.permissions = response.data.data;
                }
            } catch (error) {
                console.log(error);
            }
        },
        async getUsers() {
            try {
                const response = await axios.get("/api/users");
                if (response.data) {
                    this.users = response.data.data;
                }
            } catch (error) {
                console.log(error)
            }
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
        async handleAddPermission(data) {
            await axios
                .post("/api/permissions", data)
                .then((response) => {
                    this.getPermissions();
                    this.permissionErrors = "add success!";
                })
                .catch((error) => {
                    this.permissionErrors = error.response.data.error;
                });
        },
        async handleDeleteRole(id) {
            await axios
                .delete(`/api/roles/${id}`)
                .then((response) => {
                    this.getRoles();
                    console.log(response);
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
        async handleDeletePermission(id) {
            await axios
                .delete(`/api/permissions/${id}`)
                .then((response) => {
                    this.getPermissions();
                    this.permissionErrors = "delete success!";
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        // Xóa thất bại vì có ràng buộc
                        this.permissionErrors = error.response.data.error;
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
        async handleEditPermission(id, form) {
            await axios
                .put(`/api/permissions/${id}`, form)
                .then((response) => {
                    this.getPermissions();
                    this.permissionErrors = "update success!";
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        // Xóa thất bại vì có ràng buộc
                        this.permissionErrors = error.response.data.error;
                        console.log(error.response.data.error);
                    } else {
                        // Lỗi server khác
                        console.error(error);
                    }
                });
        },
        async handleShowDetailRoleUser(user_id) {
            await axios.get(`/api/users/${user_id}`)
            .then(response => {
                this.detailUser.roles = response.data.user_role
                this.detailUser.permissions = response.data.user_permission
                console.log(this.getDetailUser)
            })
            .catch(error => {
                console.log(error)
            })
        },

        async handleGivePermissionForRole(name_permission, role_id) {
            await axios
                .post(`/api/roles/${role_id}/permissions`, {
                    name: name_permission,
                })
                .then((response) => {
                    this.roleErrors = "success!";
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        // Xóa thất bại vì có ràng buộc
                        this.roleErrors = error.response.data.error;
                    } else {
                        // Lỗi server khác
                        console.error(error);
                    }
                });
        },
        async handleGetPermissionOfRole(role_id) {
            await axios
                .get(`/api/roles/${role_id}/permissions`)
                .then((response) => {
                    this.rolePermissions = response.data.data;
                })
                .catch((error) => {
                    this.rolePermissions = [];
                });
        },
        async handleRevokePermission(role_id, permission_id) {
            await axios
                .delete(`/api/roles/${role_id}/permissions/${permission_id}`)
                .then((response) => {
                    this.roleErrors = "success!";
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async handleGetRoleOfPermission(permission_id) {
            await axios
                .get(`/api/permissions/${permission_id}/roles`)
                .then((response) => {
                    this.permissionRoles = response.data.data;
                })
                .catch((error) => {
                    this.permissionRoles = [];
                });
        },
        async handleRemoveRole(permission_id, role_id) {
            await axios
                .delete(`/api/permissions/${permission_id}/roles/${role_id}`)
                .then((response) => {
                    this.permissionErrors = "success!";
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        // Xóa thất bại vì có ràng buộc
                        this.permissionErrors = error.response.data.error;
                    } else {
                        // Lỗi server khác
                        console.error(error);
                    }
                });
        },
        async handleAsignRole(permission_id, name_role) {
            await axios
                .post(`/api/permissions/${permission_id}/roles`, {
                    name: name_role
                })
                .then((response) => {
                    this.permissionErrors = "success!";
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        // Xóa thất bại vì có ràng buộc
                        this.permissionErrors = error.response.data.error;
                    } else {
                        // Lỗi server khác
                    }
                    console.error(error);
                });
        },
        async handleAsignRoleForUser(user_id, name_role) {
            await axios
                .post(`/api/users/${user_id}/roles`, {
                    name: name_role
                })
                .then((response) => {
                    this.userRoleError = "success!";
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.userRoleError = error.response.data.error;
                    } else {
                    }
                    console.error(error);
                });
        },
        async handleRemoveRoleUser(user_id, role_id) {
            await axios
                .delete(`/api/users/${user_id}/roles/${role_id}`)
                .then((response) => {
                    this.userRoleError = "success!";
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.userRoleError = error.response.data.error;
                    } else {
                    }
                    console.error(error);
                });
        },
        async handleGivePermissionForUser(user_id, name_permission) {
            await axios
                .post(`/api/users/${user_id}/permissions`, {
                    name: name_permission
                })
                .then((response) => {
                    this.userPermissionError = "success!";
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.userPermissionError = error.response.data.error;
                    } else {
                    }
                    console.log(error)

                });
        },
        async handleRevokePermissionToUser(user_id, permission_id) {
            await axios
                .delete(`/api/users/${user_id}/permissions/${permission_id}`)
                .then((response) => {
                    this.userPermissionError = "success!";
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.userPermissionError = error.response.data.error;
                    } else {
                    }
                    console.log(error)
                });
        },

    },
});
