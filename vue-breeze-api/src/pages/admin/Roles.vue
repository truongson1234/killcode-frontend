<script setup>
import { ref, onMounted, computed, onBeforeMount } from "vue";
import { useRolesStore } from "@/stores/roles.js";
import { initModals } from "flowbite";
import TagInput from "@/components/ui/TagInput.vue";
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import "@/assets/admin/css/pagination-styles.css";
const rolesStore = useRolesStore();
const roles = [], permissions = [];
const formAddRole = ref({
    name: "",
});
const formAddPermission = ref({
    name: "",
});
const formEditRole = ref({
    id: "",
    name: "",
    permissions: []
});
const formEditPermission = ref({
    id: "",
    name: "",
    roles: []
});
const formEditUserRole = ref({
    id: "",
    name: "",
    roles: [],
});
const formEditDetailUser = ref({
    name: '',
    id: '',
    roles: [],
    permissions: []
})
const checkValiAddRole = ref(null);
const checkValiEditRole = ref(null);
const checkValiAddPermission = ref(null);
const checkValiEditPermission = ref(null);
var errorUserRole = ref(''), errorUserPermission = ref(''), errorRolePermission = ref(''), errorPermissionRole = ref('')
const sortKey = ref(''), sortKeyRole = ref(''), sortKeyPermission = ref('')
const sortOrder = ref(1), sortOrderRole = ref(1), sortOrderPermission = ref(1)
const currentPage = ref(1), currentPageUser = ref(1), currentPagePermission = ref(1)
const pageRole = ref(1), pageUser = ref(1), pagePermission = ref(1)
const itemsPerPageRole = ref(5), itemsPerPagePermission = ref(5), itemsPerPageUser = ref(3)
const indexStartUser = ref(''), indexEndUser = ref(''), indexStartRole = ref(''), indexEndRole = ref(''), indexStartPermission = ref(''), indexEndPermission = ref('')
onBeforeMount(async () => {
    // await axios
    //     .get("/api/roles")
    //     .then((response) => {
    //         roles = response.data.map((tag) => tag.name);
    //         console.log(response.data)
    //     })
    //     .catch((error) => {
    //         console.log(error);
    //     });
})
onMounted(async () => {
    initModals();
    await rolesStore.getRoles();
    await rolesStore.getPermissions();
    await rolesStore.getUsers()
        .then(response => {
            console.log(response.data)
        })
        .catch(error => {

        });
});
const listRoles = computed(() => {
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
const listPermissions = computed(() => {
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

const listUsers = computed(() => {
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
const totalPagesRole = computed(() => {
    if (rolesStore.listRoles != null) {
        return Math.ceil(rolesStore.listRoles.length / itemsPerPageRole.value);
    }
})
const totalPagesPermission = computed(() => {
    if (rolesStore.listPermissions != null) {
        return Math.ceil(rolesStore.listPermissions.length / itemsPerPagePermission.value);
    }
})
const totalPagesUser = computed(() => {
    if (rolesStore.listUsers != null) {
        return Math.ceil(rolesStore.listUsers.length / itemsPerPageUser.value);
    }
})
const displayedItemsRole = computed(() => {
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
const displayedItemsPermission = computed(() => {
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
const displayedItemsUser = computed(() => {
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
const onPageChanged = (page) => {
    currentPage.value = page;
}
const onPageChangedUser = (page) => {
    currentPageUser.value = page;
}
const onPageChangedPermission = (page) => {
    currentPagePermission.value = page;
}
const updatedRoleUser = computed(() => {
    return formEditDetailUser.value.roles
})
const updatedPermissionUser = computed(() => {
    return formEditDetailUser.value.permissions
})

const updatedPermission = computed(() => {
    return formEditRole.value.permissions
})

const updatedRolePermission = computed(() => {
    return formEditPermission.value.roles
})
const isReadonly = computed(() => {
    const roles = formEditUserRole.value.roles
    return roles.length > 4 ? true : false
})
const updateRoleUser = (async (newRole) => {
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
const updatePermissionUser = (async (newPermission) => {
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
const givePermissionForRole = (async (newPermission) => {
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
const revokePermission = (async (permission, role_id, permission_id) => {
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
const revokePermissionUser = (async (user_id, permission_id, permissison) => {
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

const asignRole = (async (newRole) => {
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
const removeRoleOfPermission = (async (role, role_id, permission_id) => {
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

const removeRoleUser = (async (user_id, role_id, role) => {
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
const modelValueEditRole = (event) => {
    formEditRole.value.name = event.target.value;
};
const modelValueEditPermission = (event) => {
    formEditPermission.value.name = event.target.value;
};
const deleteRole = (id, name) => {
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
const deletePermission = (id, name) => {
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
const addRole = (form) => {
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
const addPermission = (form) => {
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
const valiEmptyInput = (name_condition, value) => {
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
const editRole = (id, form) => {
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
                }
                $("#modal-edit-role").addClass("hidden");
                rolesStore.getUsers();
            })
            .catch((error) => { });
    }
};
const editPermission = (id, form) => {
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
                }
                $("#modal-edit-permission").addClass("hidden");
                // rolesStore.getUsers();
            })
            .catch((error) => { });
    }
};
const showModalEditUserRole = async(id, name) => {
    await rolesStore.handleShowDetailRoleUser(id)
    formEditDetailUser.value.roles = rolesStore.getDetailUser.roles
    formEditDetailUser.value.permissions = rolesStore.getDetailUser.permissions
    formEditUserRole.value.id = id
    formEditUserRole.value.name = name
    formEditUserRole.value.roles = roles
    errorUserRole.value = ''
    errorUserPermission.value = ''

    $("#modal-edit-user-role").removeClass("hidden");
};
const showModalEditPermission = async(id, name) => {
    await rolesStore.handleGetRoleOfPermission(id)
    formEditPermission.value.roles = rolesStore.getPermissionRoles
    formEditPermission.value.id = id;
    formEditPermission.value.name = name;
    $("#modal-edit-permission").removeClass("hidden");
    checkValiEditPermission.value = false
};
const showModalEditRole = async(id, name) => {
    await rolesStore.handleGetPermissionOfRole(id)
    formEditRole.value.permissions = rolesStore.getRolePermissions
    formEditRole.value.id = id;
    formEditRole.value.name = name;
    errorRolePermission.value = ''
    $("#modal-edit-role").removeClass("hidden");
    checkValiEditRole.value = false
};
const closeModalEditRole = () => {
    $("#modal-edit-role").addClass("hidden");
};
const closeModalEditPermission = () => {
    $("#modal-edit-permission").addClass("hidden");
};
const closeModalEditUserRole = () => {
    $("#modal-edit-user-role").addClass("hidden");
};
const formatDateTime = (date_time) => {
    if (date_time != null) {
        const date = new Date(date_time);
        const day = date.getDate().toString().padStart(2, "0");
        const month = (date.getMonth() + 1).toString().padStart(2, "0");
        const year = date.getFullYear().toString();
        const formattedDate = `${day}/${month}/${year}`;
        return formattedDate;
    }
    return ''
};
const sortTable = (key) => {
    if (sortKey.value === key) {
        sortOrder.value = sortOrder.value * -1;
    } else {
        sortKey.value = key;
        sortOrder.value = 1;
    }
}
const sortTableRole = (key) => {
    if (sortKeyRole.value === key) {
        sortOrderRole.value = sortOrderRole.value * -1;
    } else {
        sortKeyRole.value = key;
        sortOrderRole.value = 1;
    }
}
const sortTablePermission = (key) => {
    if (sortKeyPermission.value === key) {
        sortOrderPermission.value = sortOrderPermission.value * -1;
    } else {
        sortKeyPermission.value = key;
        sortOrderPermission.value = 1;
    }
}
const sortIcon = (column) => {
    if (sortKey.value === column) {
        return sortOrder.value === 1 ? 'bx bxs-up-arrow' : 'bx bxs-down-arrow';
    }
    return 'bx bxs-sort-alt';
}
const sortIconRole = (column) => {
    if (sortKeyRole.value === column) {
        return sortOrderRole.value === 1 ? 'bx bxs-up-arrow' : 'bx bxs-down-arrow';
    }
    return 'bx bxs-sort-alt';
}
const sortIconPermission = (column) => {
    if (sortKeyPermission.value === column) {
        return sortOrderPermission.value === 1 ? 'bx bxs-up-arrow' : 'bx bxs-down-arrow';
    }
    return 'bx bxs-sort-alt';
}
</script>
<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Authors table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0"
                                id="table-user">
                                <thead>
                                    <tr>
                                        <!-- <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 cursor-pointer column-name">
                                                #
                                            </th> -->
                                        <th @click="sortTable('name')"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 cursor-pointer column-name">
                                            Tên <i :class="sortIcon('name')"></i>
                                        </th>
                                        <th @click="sortTable('email')"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 cursor-pointer column-email">
                                            E-mail <i
                                                :class="sortIcon('email')"></i>

                                        </th>
                                        <th @click="sortTable('email_verified_at')"
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 cursor-pointer column-status">
                                            Trạng thái <i
                                                :class="sortIcon('email_verified_at')"></i>

                                        </th>
                                        <th @click="sortTable('created_at')"
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 cursor-pointer column-created-at">
                                            ngày tạo <i
                                                :class="sortIcon('created_at')"></i>

                                        </th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in displayedItemsUser"
                                        :key="item.id">
                                        <!-- <td>
                                                <span>{{ index }}</span>
                                            </td> -->
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="@/assets/admin/img/team-2.jpg"
                                                        class="avatar avatar-sm me-3"
                                                        alt="user1" />
                                                </div>
                                                <div
                                                    class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ item.name }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div
                                                    class="d-flex flex-column justify-content-center">
                                                    <p
                                                        class="text-secondary text-xs font-weight-bold mb-0">
                                                        {{ item.email }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="align-middle text-center text-sm">
                                            <span
                                                v-if="item.email_verified_at != null"
                                                class="badge badge-sm bg-gradient-success">Đã
                                                xác thực</span>
                                            <span v-else
                                                class="badge badge-sm bg-gradient-secondary">Chưa
                                                xác thực</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{
                                                    formatDateTime(
                                                        item.created_at
                                                    )
                                                }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <button type="button"
                                                @click="showModalEditUserRole(item.id, item.name)"
                                                class="px-2 py-1.5 rounded-sm bg-green-600 text-white flex">
                                                <i
                                                    class="bx bxs-edit self-center justify-self-center"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div id="modal-edit-user-role"
                                        class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
                                        <div class="backdrop-modal-edit-role absolute z-10"
                                            @click="closeModalEditUserRole()"></div>
                                        <div class="relative h-full border-0">
                                            <div class="absolute bg-white rounded-lg shadow z-20"
                                                style="
                                                            top: 50%;
                                                            left: 50%;
                                                            transform: translate(
                                                                -50%,
                                                                -50%
                                                            );
                                                        ">
                                                <button type="button"
                                                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                                    @click="
                                                        closeModalEditUserRole()
                                                    ">
                                                    <i class="bx bx-x text-xl"></i>
                                                </button>
                                                <div class="px-4 py-4 lg:px-5"
                                                    style="width: 450px">
                                                    <h3
                                                        class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                        Chỉnh sửa vai trò của: {{
                                                            formEditUserRole.name }}
                                                    </h3>
                                                    <p class="leading-8">Các vai trò
                                                        hiện tại:
                                                        <span
                                                            v-for="role in updatedRoleUser"
                                                            :key="role.id"
                                                            class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ">
                                                            {{ role.name }} <i
                                                                class='bx bx-x text-lg pl-1 cursor-pointer'
                                                                @click="removeRoleUser(formEditUserRole.id, role.id, role)"></i>
                                                        </span>
                                                    </p>
                                                    <form class="space-y-6"
                                                        @submit.prevent="">
                                                        <tag-input
                                                            :initial-tags="formEditDetailUser.roles"
                                                            :api-url="'/api/roles/search'"
                                                            @add-item="updateRoleUser"
                                                            :placeholder="'Nhập vai trò cần thêm...'"
                                                            :is-readonly="isReadonly"></tag-input>
                                                        <div v-if="errorUserRole != ''"
                                                            class="mt-0 mb-0">
                                                            <span
                                                                class="text-red-400 text-sm p-2 pt-3 px-0">{{
                                                                    errorUserRole
                                                                }}</span>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="px-4 py-2 lg:px-5"
                                                    style="width: 450px">
                                                    <p class="leading-8">Các quyền khác:
                                                        <span
                                                            v-for="permisison in updatedPermissionUser"
                                                            :key="permisison.id"
                                                            class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ">
                                                            {{ permisison.name }} <i
                                                                class='bx bx-x text-lg pl-1 cursor-pointer'
                                                                @click="revokePermissionUser(formEditUserRole.id, permisison.id, permisison)"
                                                                ></i>
                                                        </span>
                                                    </p>
                                                    <form class="space-y-6"
                                                        @submit.prevent="">
                                                        <tag-input
                                                            :initial-tags="formEditDetailUser.permissions"
                                                            :api-url="'/api/permissions/search'"
                                                            @add-item="updatePermissionUser"
                                                            :placeholder="'Nhập quyền cần thêm...'"
                                                            :is-readonly="isReadonly"></tag-input>
                                                        <div v-if="errorUserPermission != ''"
                                                            class="mt-0 mb-0">
                                                            <span
                                                                class="text-red-400 text-sm p-2 pt-3 px-0">{{
                                                                    errorUserPermission
                                                                }}</span>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="flex justify-between align-center"
                        v-if="listUsers != null && listUsers.length > itemsPerPageUser">
                        <div>
                            <v-pagination v-model="pageUser" :pages="totalPagesUser"
                                :range-size="1" active-color="#0074FF" class="my-3"
                                @update:modelValue="onPageChangedUser" />
                        </div>
                        <div style="line-height: 54px;" class="pr-4">
                            <span
                                class="text-secondary text-xs font-weight-bold">Hiển
                                thị: {{ indexStartUser }} - {{ indexEndUser }} / {{
                                    listUsers.length }} bản ghi.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Các vai trò</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table
                                class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th @click="sortTableRole('name')"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 cursor-pointer">
                                            Tên quyền <i
                                                :class="sortIconRole('name')"></i>
                                        </th>
                                        <th @click="sortTableRole('created_at')"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 cursor-pointer">
                                            Ngày tạo <i
                                                :class="sortIconRole('created_at')"></i>
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Khác
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in displayedItemsRole"
                                        :key="item.name">
                                        <td>
                                            <div class="d-flex px-2">
                                                <div>
                                                    <img src="@/assets/admin/img/small-logos/logo-spotify.svg"
                                                        class="avatar avatar-sm rounded-circle me-2"
                                                        alt="spotify" />
                                                </div>
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ item.name }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="text-xs font-weight-bold">{{
                                                    formatDateTime(item.created_at)
                                                }}</span>
                                        </td>

                                        <td>
                                            <div class="flex gap-x-1">
                                                <button @click.prevent="
                                                    deleteRole(
                                                        item.id,
                                                        item.name
                                                    )
                                                "
                                                    class="px-2 py-1.5 rounded-sm bg-red-600 text-white flex">
                                                    <i
                                                        class="bx bxs-trash-alt self-center justify-self-center"></i>
                                                </button>
                                                <button type="button" @click="
                                                    showModalEditRole(
                                                        item.id,
                                                        item.name
                                                    )
                                                "
                                                    class="px-2 py-1.5 rounded-sm bg-green-600 text-white flex">
                                                    <i
                                                        class="bx bxs-edit self-center justify-self-center"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <div id="modal-edit-role"
                                        class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
                                        <div class="backdrop-modal-edit-role absolute z-10"
                                            @click="closeModalEditRole()"></div>
                                        <div class="relative h-full border-0">
                                            <div class="absolute bg-white rounded-lg shadow z-20"
                                                style="
                                                        top: 50%;
                                                        left: 50%;
                                                        transform: translate(
                                                            -50%,
                                                            -50%
                                                        );
                                                    ">
                                                <button type="button"
                                                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                                    @click="
                                                        closeModalEditRole()
                                                    ">
                                                    <i class="bx bx-x text-xl"></i>
                                                </button>
                                                <div class="px-4 py-4 lg:px-5">
                                                    <h3
                                                        class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                        Chỉnh sửa vai trò
                                                    </h3>
                                                    <form class="space-y-6"
                                                        @submit.prevent="
                                                            editRole(
                                                                formEditRole.id,
                                                                formEditRole
                                                            )
                                                        ">
                                                        <input type="text"
                                                            name="name-role"
                                                            placeholder=""
                                                            class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md text-sm focus:border-black shadow-sm"
                                                            v-model="
                                                                formEditRole.name
                                                            " @blur="
                                                                modelValueEditRole(
                                                                    $event
                                                                )
                                                            "
                                                            @keyup="valiEmptyInput('checkValiEditRole', formEditRole.name)" />
                                                        <div v-if="checkValiEditRole"
                                                            class="mt-0 mb-0">
                                                            <span
                                                                class="text-red-400 text-sm p-2 pt-3 px-0">Không
                                                                được để trống tên
                                                                vai trò!</span>
                                                        </div>
                                                        <button type="submit"
                                                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-3">
                                                            Chỉnh sửa
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="px-4 py-4 lg:px-5"
                                                    style="width: 450px">
                                                    <h3
                                                        class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                        Các quyền hiện tại của vai trò: {{ formEditRole.name }}
                                                    </h3>
                                                    <p class="leading-8">
                                                        <span
                                                            v-for="permission in updatedPermission"
                                                            :key="permission.id"
                                                            class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ">
                                                            {{ permission.name }} <i
                                                                class='bx bx-x text-lg pl-1 cursor-pointer'
                                                                @click="revokePermission(permission, formEditRole.id, permission.id)"
                                                            ></i>
                                                        </span>
                                                    </p>
                                                    <form class="space-y-6"
                                                        @submit.prevent="">
                                                        <tag-input
                                                            :initial-tags="formEditRole.permissions"
                                                            :api-url="'/api/permissions/search'"
                                                            @add-item="givePermissionForRole"
                                                            :is-readonly="isReadonly"></tag-input>
                                                        <div v-if="errorRolePermission != ''"
                                                            class="mt-0 mb-0">
                                                            <span
                                                                class="text-red-400 text-sm p-2 pt-3 px-0">{{
                                                                    errorRolePermission
                                                                }}</span>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="flex justify-between align-center"
                        v-if="listRoles != null && listRoles.length > itemsPerPageRole">
                        <div>
                            <v-pagination v-model="pageRole" :pages="totalPagesRole"
                                :range-size="1" active-color="#0074FF"
                                class="my-3 pl-2"
                                @update:modelValue="onPageChanged" />
                        </div>
                        <div style="line-height: 54px;" class="pr-4">
                            <span
                                class="text-secondary text-xs font-weight-bold">Hiển
                                thị: {{ indexStartRole }} - {{ indexEndRole }} / {{
                                    listRoles.length }} bản ghi.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Thêm vai trò</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive p-0">
                            <form @submit.prevent="addRole(formAddRole)">
                                <input id="text_role" type="text" name="name"
                                    v-model="formAddRole.name"
                                    @keyup="valiEmptyInput('checkValiAddRole', formAddRole.name)"
                                    placeholder="Nhập tên vai trò..."
                                    class="block w-full py-2 px-1 mt-1 mb-2 text-gray-800 appearance-none border-t-0 border-r-0 border-l-0 border-b-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 :focus:ring-0" />
                                <div v-if="checkValiAddRole">
                                    <span class="text-red-400 text-sm p-2 px-0">Vui
                                        lòng nhập tên vai trò!</span>
                                </div>
                                <button type="submit"
                                    class="px-2 py-1.5 rounded-sm bg-blue-600 text-white text-sm mt-1">
                                    Thêm
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Các quyền</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table
                                class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th @click="sortTablePermission('name')"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 cursor-pointer">
                                            Tên quyền <i
                                                :class="sortIconPermission('name')"></i>
                                        </th>
                                        <th @click="sortTablePermission('created_at')"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 cursor-pointer">
                                            Ngày tạo <i
                                                :class="sortIconPermission('created_at')"></i>
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Khác
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in displayedItemsPermission"
                                        :key="item.name">
                                        <td>
                                            <div class="d-flex px-2">
                                                <div>
                                                    <img src="@/assets/admin/img/small-logos/logo-spotify.svg"
                                                        class="avatar avatar-sm rounded-circle me-2"
                                                        alt="spotify" />
                                                </div>
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ item.name }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="text-xs font-weight-bold">{{
                                                    formatDateTime(item.created_at)
                                                }}</span>
                                        </td>

                                        <td>
                                            <div class="flex gap-x-1">
                                                <button @click.prevent="
                                                    deletePermission(
                                                        item.id,
                                                        item.name
                                                    )
                                                "
                                                    class="px-2 py-1.5 rounded-sm bg-red-600 text-white flex">
                                                    <i
                                                        class="bx bxs-trash-alt self-center justify-self-center"></i>
                                                </button>
                                                <button type="button" @click="
                                                    showModalEditPermission(
                                                        item.id,
                                                        item.name
                                                    )
                                                "
                                                    class="px-2 py-1.5 rounded-sm bg-green-600 text-white flex">
                                                    <i
                                                        class="bx bxs-edit self-center justify-self-center"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <div id="modal-edit-permission"
                                        class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
                                        <div class="backdrop-modal-edit-role absolute z-10"
                                            @click="closeModalEditPermission()"></div>
                                        <div class="relative h-full border-0">
                                            <div class="absolute bg-white rounded-lg shadow z-20"
                                                style="
                                                        top: 50%;
                                                        left: 50%;
                                                        transform: translate(
                                                            -50%,
                                                            -50%
                                                        );
                                                    ">
                                                <button type="button"
                                                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                                    @click="
                                                        closeModalEditPermission()
                                                    ">
                                                    <i class="bx bx-x text-xl"></i>
                                                </button>
                                                <div class="px-4 py-4 lg:px-5">
                                                    <h3
                                                        class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                        Chỉnh sửa quyền
                                                    </h3>
                                                    <form class="space-y-6"
                                                        @submit.prevent="
                                                            editPermission(
                                                                formEditPermission.id,
                                                                formEditPermission
                                                            )
                                                        ">
                                                        <input type="text"
                                                            name="name-role"
                                                            placeholder=""
                                                            class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md text-sm focus:border-black shadow-sm"
                                                            v-model="
                                                                formEditPermission.name
                                                            " @blur="
                                                                modelValueEditPermission(
                                                                    $event
                                                                )
                                                            "
                                                            @keyup="valiEmptyInput('checkValiEditPermission', formEditPermission.name)" />
                                                        <div v-if="checkValiEditPermission != false"
                                                            class="mt-0 mb-0">
                                                            <span
                                                                class="text-red-400 text-sm p-2 pt-3 px-0">Không
                                                                được để trống tên
                                                                quyền!</span>
                                                        </div>
                                                        <button type="submit"
                                                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-3">
                                                            Chỉnh sửa
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="px-4 py-4 lg:px-5"
                                                    style="width: 450px">
                                                    <h3
                                                        class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                        Các vai trò liên quan đến: {{ formEditPermission.name }}
                                                    </h3>
                                                    <p class="leading-8">
                                                        <span
                                                            v-for="role in updatedRolePermission"
                                                            :key="role.id"
                                                            class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ">
                                                            {{ role.name }} <i
                                                                class='bx bx-x text-lg pl-1 cursor-pointer'
                                                                @click="removeRoleOfPermission(role, formEditPermission.id, role.id)"
                                                            ></i>
                                                        </span>
                                                    </p>
                                                    <form class="space-y-6"
                                                        @submit.prevent="">
                                                        <tag-input
                                                            :initial-tags="formEditPermission.roles"
                                                            :api-url="'/api/roles/search'"
                                                            @add-item="asignRole"
                                                            :is-readonly="isReadonly"></tag-input>
                                                        <div v-if="errorPermissionRole != ''"
                                                            class="mt-0 mb-0">
                                                            <span
                                                                class="text-red-400 text-sm p-2 pt-3 px-0">{{
                                                                    errorPermissionRole
                                                                }}</span>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="flex justify-between align-center"
                        v-if="listPermissions != null && listPermissions.length > itemsPerPagePermission">
                        <div>
                            <v-pagination v-model="pagePermission" :pages="totalPagesPermission"
                                :range-size="1" active-color="#0074FF"
                                class="my-3 pl-2"
                                @update:modelValue="onPageChangedPermission" />
                        </div>
                        <div style="line-height: 54px;" class="pr-4">
                            <span
                                class="text-secondary text-xs font-weight-bold">Hiển
                                thị: {{ indexStartPermission }} - {{ indexEndPermission }} / {{
                                    listPermissions.length }} bản ghi.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Thêm quyền</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive p-0">
                            <form @submit.prevent="addPermission(formAddPermission)">
                                <input id="text_role" type="text" name="name"
                                    v-model="formAddPermission.name"
                                @keyup="valiEmptyInput('checkValiAddPermission', formAddPermission.name)"
                                placeholder="Nhập tên quyền..."
                                class="block w-full py-2 px-1 mt-1 mb-2 text-gray-800 appearance-none border-t-0 border-r-0 border-l-0 border-b-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 :focus:ring-0" />
                            <div v-if="checkValiAddPermission">
                                <span class="text-red-400 text-sm p-2 px-0">Vui
                                    lòng nhập tên quyền!</span>
                            </div>
                            <button type="submit"
                                class="px-2 py-1.5 rounded-sm bg-blue-600 text-white text-sm mt-1">
                                Thêm
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div></template>
<style scoped>.focus\:border-gray-200:focus {
    box-shadow: none;
}

.backdrop-modal-edit-role {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.2);
}

.hennge-pagination-custom button.Page-active {
    color: #fff !important;
}</style>
