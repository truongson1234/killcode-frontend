import { ref, computed } from "vue";
import { useRolesStore } from "@/stores/roles.js";
export const rolesStore = useRolesStore();
export const formAddRole = ref({
    name: "",
});
export const formAddPermission = ref({
    name: "",
});
export const formEditRole = ref({
    id: "",
    name: "",
    permissions: []
});
export const formEditPermission = ref({
    id: "",
    name: "",
    roles: []
});
export const formEditUserRole = ref({
    id: "",
    name: "",
    roles: [],
});
export const formEditDetailUser = ref({
    name: '',
    id: '',
    roles: [],
    permissions: []
})
export const checkValiAddRole = ref(null);
export const checkValiEditRole = ref(null);
export const checkValiAddPermission = ref(null);
export const checkValiEditPermission = ref(null);
export var errorUserRole = ref(''), errorUserPermission = ref(''), errorRolePermission = ref(''), errorPermissionRole = ref('')
export const sortKey = ref(''), sortKeyRole = ref(''), sortKeyPermission = ref('')
export const sortOrder = ref(1), sortOrderRole = ref(1), sortOrderPermission = ref(1)
export const currentPage = ref(1), currentPageUser = ref(1), currentPagePermission = ref(1)
export const pageRole = ref(1), pageUser = ref(1), pagePermission = ref(1)
export const itemsPerPageRole = ref(5), itemsPerPagePermission = ref(5), itemsPerPageUser = ref(5)
export const indexStartUser = ref(''), indexEndUser = ref(''), indexStartRole = ref(''), indexEndRole = ref(''), indexStartPermission = ref(''), indexEndPermission = ref('')
export const listRoles = computed(() => {
    // return rolesStore.listRoles;
    if (rolesStore.listRoles !== null && typeof rolesStore.listRoles !== 'undefined') {
        return rolesStore.listRoles.sort((a, b) => {
            let modifier = sortOrderRole.value === 1 ? 1 : -1;
            if (a[sortKeyRole.value] < b[sortKeyRole.value]) {
                return -1 * modifier;
            }
            if (a[sortKeyRole.value] > b[sortKeyRole.value]) {
                return 1 * modifier;
            }
            if (a[sortKeyRole.value] === null && b[sortKeyRole.value] === null) {
                return 0;
            }
            if (a[sortKeyRole.value] === null) {
                return modifier * 1;
            }
            if (b[sortKeyRole.value] === null) {
                return modifier * -1;
            }
            return 0;
        });
    }
});
export const listPermissions = computed(() => {
    // return rolesStore.listRoles;
    if (rolesStore.listPermissions !== null && typeof rolesStore.listPermissions !== 'undefined') {
        return rolesStore.listPermissions.sort((a, b) => {
            let modifier = sortOrderPermission.value === 1 ? 1 : -1;
            if (a[sortKeyPermission.value] < b[sortKeyPermission.value]) {
                return -1 * modifier;
            }
            if (a[sortKeyPermission.value] > b[sortKeyPermission.value]) {
                return 1 * modifier;
            }
            if (a[sortKeyPermission.value] === null && b[sortKeyPermission.value] === null) {
                return 0;
            }
            if (a[sortKeyPermission.value] === null) {
                return modifier * 1;
            }
            if (b[sortKeyPermission.value] === null) {
                return modifier * -1;
            }
            return 0;
        });
    }
});
export const listUsers = computed(() => {
    if (rolesStore.listUsers !== null && typeof rolesStore.listUsers !== 'undefined') {
        return rolesStore.listUsers.sort((a, b) => {
            let modifier = sortOrder.value === 1 ? 1 : -1;
            if (a[sortKey.value] < b[sortKey.value]) {
                return -1 * modifier;
            }
            if (a[sortKey.value] > b[sortKey.value]) {
                return 1 * modifier;
            }
            if (a[sortKey.value] === null && b[sortKey.value] === null) {
                return 0;
            }
            if (a[sortKey.value] === null) {
                return modifier * 1;
            }
            if (b[sortKey.value] === null) {
                return modifier * -1;
            }
            return 0;
        });
    }
});
export const totalPagesRole = computed(() => {
    if (rolesStore.listRoles != null) {
        return Math.ceil(rolesStore.listRoles.length / itemsPerPageRole.value);
    }
})
export const totalPagesPermission = computed(() => {
    if (rolesStore.listPermissions != null) {
        return Math.ceil(rolesStore.listPermissions.length / itemsPerPagePermission.value);
    }
})
export const totalPagesUser = computed(() => {
    if (rolesStore.listUsers != null) {
        return Math.ceil(rolesStore.listUsers.length / itemsPerPageUser.value);
    }
})
export const displayedItemsRole = computed(() => {
    if (rolesStore.listRoles != null) {
        var startIndex = (currentPage.value - 1) * itemsPerPageRole.value;
        var endIndex = startIndex + itemsPerPageRole.value;
        if (endIndex > rolesStore.listRoles.length) {
            endIndex = rolesStore.listRoles.length
        }
        indexStartRole.value = startIndex + 1
        indexEndRole.value = endIndex
        return rolesStore.listRoles.slice(startIndex, endIndex);
    }
})
export const displayedItemsPermission = computed(() => {
    if (rolesStore.listPermissions != null) {
        var startIndex = (currentPagePermission.value - 1) * itemsPerPagePermission.value;
        var endIndex = startIndex + itemsPerPagePermission.value;
        if (endIndex > rolesStore.listPermissions.length) {
            endIndex = rolesStore.listPermissions.length
        }
        indexStartPermission.value = startIndex + 1
        indexEndPermission.value = endIndex
        return rolesStore.listPermissions.slice(startIndex, endIndex);
    }
})
export const displayedItemsUser = computed(() => {
    if (rolesStore.listUsers != null) {
        var startIndex = (currentPageUser.value - 1) * itemsPerPageUser.value;
        var endIndex = startIndex + itemsPerPageUser.value;
        if (endIndex > rolesStore.listUsers.length) {
            endIndex = rolesStore.listUsers.length
        }
        indexStartUser.value = startIndex + 1
        indexEndUser.value = endIndex
        return rolesStore.listUsers.slice(startIndex, endIndex);
    }
})
export const onPageChanged = (page) => {
    currentPage.value = page;
}
export const onPageChangedUser = (page) => {
    currentPageUser.value = page;
}
export const onPageChangedPermission = (page) => {
    currentPagePermission.value = page;
}
export const updatedRoleUser = computed(() => {
    return formEditDetailUser.value.roles
})
export const updatedPermissionUser = computed(() => {
    return formEditDetailUser.value.permissions
})

export const updatedPermission = computed(() => {
    return formEditRole.value.permissions
})

export const updatedRolePermission = computed(() => {
    return formEditPermission.value.roles
})
export const isReadonly = computed(() => {
    const roles = formEditDetailUser.value.roles
    return roles.length > 4 ? true : false
})
export const updateRoleUser = (async (newRole) => {
    await rolesStore.handleAsignRoleForUser(formEditUserRole.value.id, newRole.name)
        .then(response => {
            if (rolesStore.getUserRoleError == 'success!') {
                formEditDetailUser.value.roles.push(newRole)
                errorUserRole.value = ''
            } else {
                errorUserRole.value = rolesStore.getUserRoleError
            }
        })
        .catch(err => {

        })
})
export const updatePermissionUser = (async (newPermission) => {
    await rolesStore.handleGivePermissionForUser(formEditUserRole.value.id, newPermission.name)
        .then(response => {
            if (rolesStore.userPermissionError == 'success!') {
                formEditDetailUser.value.permissions.push(newPermission)
                errorUserPermission.value = ''
            } else {
                errorUserPermission.value = rolesStore.userPermissionError
            }
        })
        .catch(err => {

        })
})
export const givePermissionForRole = (async (newPermission) => {
    await rolesStore.handleGivePermissionForRole(newPermission.name, formEditRole.value.id)
        .then(response => {
            if (rolesStore.getRoleErrors == 'success!') {
                formEditRole.value.permissions.push(newPermission)
                errorRolePermission.value = ''
            } else {
                errorRolePermission.value = rolesStore.getRolePermissions
            }
        })
        .catch(err => {

        })
})
export const revokePermission = (async (permission, role_id, permission_id) => {
    await rolesStore.handleRevokePermission(role_id, permission_id)
        .then(() => {
            if (rolesStore.getRoleErrors == 'success!') {
                const index = formEditRole.value.permissions.indexOf(permission);
                if (index !== -1) {
                    formEditRole.value.permissions.splice(index, 1);
                }
            }
        })
        .catch(() => {

        })
})
export const revokePermissionUser = (async (user_id, permission_id, permissison) => {
    await rolesStore.handleRevokePermissionToUser(user_id, permission_id)
        .then(() => {
            if (rolesStore.getUserPermissionError == 'success!') {
                const index = formEditDetailUser.value.permissions.indexOf(permissison);
                if (index !== -1) {
                    formEditDetailUser.value.permissions.splice(index, 1);
                }
            }
        })
        .catch(() => {

        })
})

export const asignRole = (async (newRole) => {
    await rolesStore.handleAsignRole(formEditPermission.value.id, newRole.name)
        .then(() => {
            if (rolesStore.getPermissionErrors == 'success!') {
                formEditPermission.value.roles.push(newRole)
                errorPermissionRole.value = ''
            } else {
                errorPermissionRole.value = rolesStore.getPermissionErrors
            }
        })
        .catch(() => {

        })
})
export const removeRoleOfPermission = (async (role, role_id, permission_id) => {
    await rolesStore.handleRemoveRole(role_id, permission_id)
        .then(() => {
            if (rolesStore.getPermissionErrors == 'success!') {
                const index = formEditPermission.value.roles.indexOf(role);
                if (index !== -1) {
                    formEditPermission.value.roles.splice(index, 1);
                }
            }
        })
        .catch(() => {

        })
})

export const removeRoleUser = (async (user_id, role_id, role) => {
    await rolesStore.handleRemoveRoleUser(user_id, role_id)
        .then(() => {
            if (rolesStore.getUserRoleError == 'success!') {
                const index = formEditDetailUser.value.roles.indexOf(role);
                if (index !== -1) {
                    formEditDetailUser.value.roles.splice(index, 1);
                }
            }
        })
        .catch(() => {

        })
})
export const modelValueEditRole = (event) => {
    formEditRole.value.name = event.target.value;
};
export const modelValueEditPermission = (event) => {
    formEditPermission.value.name = event.target.value;
};
export const deleteRole = (id, name) => {
    Swal.fire({
        title: "",
        text: `Bạn có chắc muốn xóa vai trò "${name}" ?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy",
    }).then((result) => {
        if (result.isConfirmed) {
            rolesStore
                .handleDeleteRole(id)
                .then((response) => {
                    if (rolesStore.getRoleErrors != "delete success!") {
                        Swal.fire({
                            title: "",
                            text: `${rolesStore.getRoleErrors}`,
                            icon: "warning",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Đóng",
                        });
                    }
                })
                .catch((error) => { });
        }
    });
};
export const deletePermission = (id, name) => {
    Swal.fire({
        title: "",
        text: `Bạn có chắc muốn xóa quyền "${name}" ?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy",
    }).then((result) => {
        if (result.isConfirmed) {
            rolesStore
                .handleDeletePermission(id)
                .then((response) => {
                    if (rolesStore.getPermissionErrors != "delete success!") {
                        Swal.fire({
                            title: "",
                            text: `${rolesStore.getPermissionErrors}`,
                            icon: "warning",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Đóng",
                        });
                    }
                })
                .catch((error) => { });
        }
    });
};
export const addRole = (form) => {
    if (form.name != "") {
        checkValiAddRole.value = null;
        rolesStore
            .handleAddRole(form)
            .then((response) => {
                if (rolesStore.getRoleErrors != "add success!") {
                    Swal.fire({
                        title: "",
                        text: `${rolesStore.getRoleErrors}`,
                        icon: "warning",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Đóng",
                    });
                }
            })
            .catch((error) => { });
    } else {
        checkValiAddRole.value = true;
    }
};
export const addPermission = (form) => {
    if (form.name != "") {
        checkValiAddPermission.value = null;
        rolesStore
            .handleAddPermission(form)
            .then((response) => {
                if (rolesStore.getPermissionErrors != "add success!") {
                    Swal.fire({
                        title: "",
                        text: `${rolesStore.getPermissionErrors}`,
                        icon: "warning",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Đóng",
                    });
                }
            })
            .catch((error) => { });
    } else {
        checkValiAddPermission.value = true;
    }
};
export const valiEmptyInput = (name_condition, value) => {
    if (value == '') {
        if (name_condition == 'checkValiEditRole') checkValiEditRole.value = true
        else if (name_condition == 'checkValiAddRole') checkValiAddRole.value = true
        else if (name_condition == 'checkValiAddPermission') checkValiAddPermission.value = true
        else if (name_condition == 'checkValiEditPermission') checkValiEditPermission.value = true
    } else {
        checkValiEditRole.value = false
        checkValiAddRole.value = false
        checkValiAddPermission.value = false
        checkValiEditPermission.value = false
    }
}
export const editRole = (id, form) => {
    if (form.name != '') {
        rolesStore
            .handleEditRole(id, form)
            .then((response) => {
                if (rolesStore.getRoleErrors != "update success!") {
                    Swal.fire({
                        title: "",
                        text: `${rolesStore.getRoleErrors}`,
                        icon: "warning",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Đóng",
                    });
                }else {
                    $("#modal-edit-role").addClass("hidden");
                }
                rolesStore.getUsers();
            })
            .catch((error) => { });
    }
};
export const editPermission = (id, form) => {
    if (form.name != '') {
        rolesStore
            .handleEditPermission(id, form)
            .then((response) => {
                if (rolesStore.getPermissionErrors != "update success!") {
                    Swal.fire({
                        title: "",
                        text: `${rolesStore.getPermissionErrors}`,
                        icon: "warning",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Đóng",
                    });
                }else {
                    $("#modal-edit-permission").addClass("hidden");
                }
                // rolesStore.getUsers();
            })
            .catch((error) => { });
    }
};
export const showModalEditUserRole = async(id, name) => {
    await rolesStore.handleShowDetailRoleUser(id)
    formEditDetailUser.value.roles = rolesStore.getDetailUser.roles
    formEditDetailUser.value.permissions = rolesStore.getDetailUser.permissions
    formEditUserRole.value.id = id
    formEditUserRole.value.name = name
    errorUserRole.value = ''
    errorUserPermission.value = ''
    $("#modal-edit-user-role").removeClass("hidden");
};
export const showModalEditPermission = async(id, name) => {
    await rolesStore.handleGetRoleOfPermission(id)
    formEditPermission.value.roles = rolesStore.getPermissionRoles
    formEditPermission.value.id = id;
    formEditPermission.value.name = name;
    $("#modal-edit-permission").removeClass("hidden");
    checkValiEditPermission.value = false
};
export const showModalEditRole = async(id, name) => {
    await rolesStore.handleGetPermissionOfRole(id)
    formEditRole.value.permissions = rolesStore.getRolePermissions
    formEditRole.value.id = id;
    formEditRole.value.name = name;
    errorRolePermission.value = ''
    $("#modal-edit-role").removeClass("hidden");
    checkValiEditRole.value = false
};
export const closeModalEditRole = () => {
    $("#modal-edit-role").addClass("hidden");
};
export const closeModalEditPermission = () => {
    $("#modal-edit-permission").addClass("hidden");
};
export const closeModalEditUserRole = () => {
    $("#modal-edit-user-role").addClass("hidden");
};
export const sortTable = (key) => {
    if (sortKey.value === key) {
        sortOrder.value = sortOrder.value * -1;
    } else {
        sortKey.value = key;
        sortOrder.value = 1;
    }
}
export const sortTableRole = (key) => {
    if (sortKeyRole.value === key) {
        sortOrderRole.value = sortOrderRole.value * -1;
    } else {
        sortKeyRole.value = key;
        sortOrderRole.value = 1;
    }
}
export const sortTablePermission = (key) => {
    if (sortKeyPermission.value === key) {
        sortOrderPermission.value = sortOrderPermission.value * -1;
    } else {
        sortKeyPermission.value = key;
        sortOrderPermission.value = 1;
    }
}
export const sortIcon = (column) => {
    if (sortKey.value === column) {
        return sortOrder.value === 1 ? 'bx bxs-up-arrow' : 'bx bxs-down-arrow';
    }
    return 'bx bxs-sort-alt';
}
export const sortIconRole = (column) => {
    if (sortKeyRole.value === column) {
        return sortOrderRole.value === 1 ? 'bx bxs-up-arrow' : 'bx bxs-down-arrow';
    }
    return 'bx bxs-sort-alt';
}
export const sortIconPermission = (column) => {
    if (sortKeyPermission.value === column) {
        return sortOrderPermission.value === 1 ? 'bx bxs-up-arrow' : 'bx bxs-down-arrow';
    }
    return 'bx bxs-sort-alt';
}
