<script setup>
import { ref, onMounted, computed } from "vue";
import { useRolesStore } from "@/stores/roles.js";
import { initModals } from "flowbite";
const rolesStore = useRolesStore();
const formAddRole = ref({
    name: "",
});
const formEditRole = ref({
    id: "",
    name: "",
});
const formEditUserRole = ref({
    id: "",
    name: "",
    role: [],
});
const checkValiAddRole = ref(null);
const checkValiEditRole = ref(null);
const sortKey = ref('')
const sortOrder = ref(1)
onMounted(async () => {
    initModals();
    await rolesStore.getRoles();
    await rolesStore.getUsers();
});
const listRoles = computed(() => {
    return rolesStore.listRoles;
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
            return 0;
        });
    }
});
const modelValueEditRole = (event) => {
    formEditRole.value.name = event.target.value;
};
const deleteRole = (id, name) => {
    console.log(name);
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
const valiEmptyInput = (name_condition, value) => {
    console.log(value)
    if(value == '') {
        if(name_condition == 'checkValiEditRole') checkValiEditRole.value = true
        else if(name_condition == 'checkValiAddRole') checkValiAddRole.value = true
    }else {
        checkValiEditRole.value = false
        checkValiAddRole.value = false
    }
}
const editRole = (id, form) => {
    if(form.name != '') {
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
const showModalEditUserRole = (id,name,roles) => {
    formEditUserRole.value.id = id
    formEditUserRole.value.name = name
    formEditUserRole.value.roles = roles
    $("#modal-edit-user-role").removeClass("hidden");
};
const showModalEditRole = (id, name) => {
    formEditRole.value.id = id;
    formEditRole.value.name = name;
    $("#modal-edit-role").removeClass("hidden");
    checkValiEditRole.value = false
};
const closeModalEditRole = () => {
    $("#modal-edit-role").addClass("hidden");
};
const closeModalEditUserRole = () => {
    $("#modal-edit-user-role").addClass("hidden");
};
const formatDateTime = (date_time) => {
    const date = new Date(date_time);
    const day = date.getDate().toString().padStart(2, "0");
    const month = (date.getMonth() + 1).toString().padStart(2, "0");
    const year = date.getFullYear().toString();
    const formattedDate = `${day}/${month}/${year}`;
    return formattedDate;
};
const sortTable = (key) => {
    if (sortKey.value === key) {
        sortOrder.value = sortOrder.value * -1;
    } else {
        sortKey.value = key;
        sortOrder.value = 1;
    }
}
const sortIcon = (column) => {
    if (sortKey.value === column) {
        return sortOrder.value === 1 ? 'bx bxs-up-arrow' : 'bx bxs-down-arrow';
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
                                        <th @click="sortTable('name')" style="content: normal;"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 cursor-pointer column-name">
                                            Tên <i :class="sortIcon('name')"></i>
                                        </th>
                                        <th @click="sortTable('email')" style="content: normal;"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 cursor-pointer column-email">
                                            E-mail <i
                                                :class="sortIcon('email')"></i>

                                        </th>
                                        <th @click="sortTable('role_name')" style="content: normal;"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 cursor-pointer column-role">
                                            Quyền hạn <i
                                                :class="sortIcon('role_name')"></i>
                                        </th>
                                        <th @click="sortTable('email_verified_at')" style="content: normal;"
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 cursor-pointer column-status">
                                            Trạng thái <i
                                                :class="sortIcon('email_verified_at')"></i>

                                        </th>
                                        <th @click="sortTable('created_at')" style="content: normal;"
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 cursor-pointer column-created-at">
                                            ngày tạo <i
                                                :class="sortIcon('created_at')"></i>

                                        </th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in listUsers" :key="item.id">
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
                                        <td>
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300"
                                                v-for="role in item.role_name"
                                                :key="role">
                                                {{ role }}
                                            </span>
                                        </td>
                                        <td
                                            class="align-middle text-center text-sm">
                                            <span v-if="item.email_verified_at != null"
                                                class="badge badge-sm bg-gradient-success">Đã xác thực</span>
                                            <span v-else
                                                class="badge badge-sm bg-gradient-secondary">Chưa xác thực</span>
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
                                            <button type="button" @click="showModalEditUserRole(item.id, item.name, item.role_name)"
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
                                                        Chỉnh sửa quyền của {{ formEditUserRole.name }} :
                                                    </h3>
                                                    <form class="space-y-6"
                                                        @submit.prevent="">
                                                        <input type="text"
                                                            name="name-role"
                                                            placeholder=""
                                                            class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md text-sm focus:border-black shadow-sm"
                                                        />
                                                        <button type="submit"
                                                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            Chỉnh sửa
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tbody>
                            </table>
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
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tên quyền
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Budget
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Status
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Khác
                                        </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in listRoles" :key="item.name">
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
                                        <p
                                            class="text-sm font-weight-bold mb-0">
                                            $2,500
                                        </p>
                                    </td>
                                    <td>
                                        <span
                                            class="text-xs font-weight-bold">working</span>
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
                                            <div class="px-4 py-4 lg:px-5"
                                                style="width: 300px">
                                                <h3
                                                    class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                    Chỉnh sửa quyền
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
                                                        " @keyup="valiEmptyInput('checkValiEditRole', formEditRole.name)"/>
                                                    <div v-if="checkValiEditRole" class="mt-0 mb-0">
                                                        <span class="text-red-400 text-sm p-2 pt-3 px-0">Không được để trống tên quyền!</span>
                                                    </div>
                                                    <button type="submit"
                                                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-3">
                                                        Chỉnh sửa
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tbody>
                        </table>
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
                        <form @submit.prevent="addRole(formAddRole)">
                            <input id="text_role" type="text" name="name"
                                v-model="formAddRole.name"
                                @keyup="valiEmptyInput('checkValiAddRole', formAddRole.name)"
                                placeholder="Nhập tên quyền..."
                                class="block w-full py-2 px-1 mt-1 mb-2 text-gray-800 appearance-none border-t-0 border-r-0 border-l-0 border-b-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 :focus:ring-0" />
                            <div v-if="checkValiAddRole">
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
        <!-- <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Projects table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table
                                class="table align-items-center justify-content-center mb-0"
                            >
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        >
                                            Project
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        >
                                            Budget
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        >
                                            Status
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2"
                                        >
                                            Completion
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div>
                                                    <img
                                                        src="@/assets/admin/img/small-logos/logo-spotify.svg"
                                                        class="avatar avatar-sm rounded-circle me-2"
                                                        alt="spotify"
                                                    />
                                                </div>
                                                <div class="my-auto">
                                                    <h6
                                                        class="mb-0 text-sm"
                                                    >
                                                        Spotify
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p
                                                class="text-sm font-weight-bold mb-0"
                                            >
                                                $2,500
                                            </p>
                                        </td>
                                        <td>
                                            <span
                                                class="text-xs font-weight-bold"
                                                >working</span
                                            >
                                        </td>
                                        <td
                                            class="align-middle text-center"
                                        >
                                            <div
                                                class="d-flex align-items-center justify-content-center"
                                            >
                                                <span
                                                    class="me-2 text-xs font-weight-bold"
                                                    >60%</span
                                                >
                                                <div>
                                                    <div
                                                        class="progress"
                                                    >
                                                        <div
                                                            class="progress-bar bg-gradient-info"
                                                            role="progressbar"
                                                            aria-valuenow="60"
                                                            aria-valuemin="0"
                                                            aria-valuemax="100"
                                                            style="
                                                                width: 60%;
                                                            "
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <button
                                                class="btn btn-link text-secondary mb-0"
                                            >
                                                <i
                                                    class="fa fa-ellipsis-v text-xs"
                                                ></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div>
                                                    <img
                                                        src="@/assets/admin/img/small-logos/logo-invision.svg"
                                                        class="avatar avatar-sm rounded-circle me-2"
                                                        alt="invision"
                                                    />
                                                </div>
                                                <div class="my-auto">
                                                    <h6
                                                        class="mb-0 text-sm"
                                                    >
                                                        Invision
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p
                                                class="text-sm font-weight-bold mb-0"
                                            >
                                                $5,000
                                            </p>
                                        </td>
                                        <td>
                                            <span
                                                class="text-xs font-weight-bold"
                                                >done</span
                                            >
                                        </td>
                                        <td
                                            class="align-middle text-center"
                                        >
                                            <div
                                                class="d-flex align-items-center justify-content-center"
                                            >
                                                <span
                                                    class="me-2 text-xs font-weight-bold"
                                                    >100%</span
                                                >
                                                <div>
                                                    <div
                                                        class="progress"
                                                    >
                                                        <div
                                                            class="progress-bar bg-gradient-success"
                                                            role="progressbar"
                                                            aria-valuenow="100"
                                                            aria-valuemin="0"
                                                            aria-valuemax="100"
                                                            style="
                                                                width: 100%;
                                                            "
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <button
                                                class="btn btn-link text-secondary mb-0"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                            >
                                                <i
                                                    class="fa fa-ellipsis-v text-xs"
                                                ></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div>
                                                    <img
                                                        src="@/assets/admin/img/small-logos/logo-jira.svg"
                                                        class="avatar avatar-sm rounded-circle me-2"
                                                        alt="jira"
                                                    />
                                                </div>
                                                <div class="my-auto">
                                                    <h6
                                                        class="mb-0 text-sm"
                                                    >
                                                        Jira
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p
                                                class="text-sm font-weight-bold mb-0"
                                            >
                                                $3,400
                                            </p>
                                        </td>
                                        <td>
                                            <span
                                                class="text-xs font-weight-bold"
                                                >canceled</span
                                            >
                                        </td>
                                        <td
                                            class="align-middle text-center"
                                        >
                                            <div
                                                class="d-flex align-items-center justify-content-center"
                                            >
                                                <span
                                                    class="me-2 text-xs font-weight-bold"
                                                    >30%</span
                                                >
                                                <div>
                                                    <div
                                                        class="progress"
                                                    >
                                                        <div
                                                            class="progress-bar bg-gradient-danger"
                                                            role="progressbar"
                                                            aria-valuenow="30"
                                                            aria-valuemin="0"
                                                            aria-valuemax="30"
                                                            style="
                                                                width: 30%;
                                                            "
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <button
                                                class="btn btn-link text-secondary mb-0"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                            >
                                                <i
                                                    class="fa fa-ellipsis-v text-xs"
                                                ></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div>
                                                    <img
                                                        src="@/assets/admin/img/small-logos/logo-slack.svg"
                                                        class="avatar avatar-sm rounded-circle me-2"
                                                        alt="slack"
                                                    />
                                                </div>
                                                <div class="my-auto">
                                                    <h6
                                                        class="mb-0 text-sm"
                                                    >
                                                        Slack
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p
                                                class="text-sm font-weight-bold mb-0"
                                            >
                                                $1,000
                                            </p>
                                        </td>
                                        <td>
                                            <span
                                                class="text-xs font-weight-bold"
                                                >canceled</span
                                            >
                                        </td>
                                        <td
                                            class="align-middle text-center"
                                        >
                                            <div
                                                class="d-flex align-items-center justify-content-center"
                                            >
                                                <span
                                                    class="me-2 text-xs font-weight-bold"
                                                    >0%</span
                                                >
                                                <div>
                                                    <div
                                                        class="progress"
                                                    >
                                                        <div
                                                            class="progress-bar bg-gradient-success"
                                                            role="progressbar"
                                                            aria-valuenow="0"
                                                            aria-valuemin="0"
                                                            aria-valuemax="0"
                                                            style="
                                                                width: 0%;
                                                            "
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <button
                                                class="btn btn-link text-secondary mb-0"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                            >
                                                <i
                                                    class="fa fa-ellipsis-v text-xs"
                                                ></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div>
                                                                <img
                                                                            src="@/assets/admin/img/small-logos/logo-webdev.svg"
                                                                                    class="avatar avatar-sm rounded-circle me-2"
                                                                                    alt="webdev"
                                                                                    />
                                                                                            </div>
                                                                                                <div class="my-auto">
                                                                                                    <h6
                                                                                                            class="mb-0 text-sm"
                                                                                                            >
                                                                                                                Webdev
                                                                                                            </h6>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <p
                                                                                                                    class="text-sm font-weight-bold mb-0"
                                                                                                                >
                                                                                                                        $14,000
                                                                                                                    </p>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    <span
                                                                                                                        class="text-xs font-weight-bold"
                                                                                                                            >working</span
                                                                                                                        >
                                                                                                                    </td>
                                                                                                                    <td
                                                                                                                        class="align-middle text-center"
                                                                                                                    >
                                                                                                                        <div
                                                                                                                            class="d-flex align-items-center justify-content-center"
                                                                                                                        >
                                                                                                                            <span
                                                                                                                                class="me-2 text-xs font-weight-bold"
                                                                                                                                >80%</span
                                                                                                                            >
                                                                                                                            <div>
                                                                                                                                <div
                                                                                                                                    class="progress"
                                                                                                                                >
                                                                                                                                    <div
                                                                                                                                        class="progress-bar bg-gradient-info"
                                                                                                                                        role="progressbar"
                                                                                                                                        aria-valuenow="80"
                                                                                                                                        aria-valuemin="0"
                                                                                                                                            aria-valuemax="80"
                                                                                                                                            style="
                                                                                                                                                                            width: 80%;
                                                                                                                                                                            "
                                                                                                                                                                        ></div>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                            </div>
                                                                                                                                                        </td>
                                                                                                                                                        <td class="align-middle">
                                                                                                                                                            <button
                                                                                                                                                                class="btn btn-link text-secondary mb-0"
                                                                                                                                                                aria-haspopup="true"
                                                                                                                                                                aria-expanded="false"
                                                                                                                                                            >
                                                                                                                                                                <i
                                                                                                                                                                    class="fa fa-ellipsis-v text-xs"
                                                                                                                                                                ></i>
                                                                                                                                                            </button>
                                                                                                                                                        </td>
                                                                                                                                                    </tr>
                                                                                                                                                    <tr>
                                                                                                                                                        <td>
                                                                                                                                                            <div class="d-flex px-2">
                                                                                                                                                                <div>
                                                                                                                                                                    <img
                                                                                                                                                                        src="@/assets/admin/img/small-logos/logo-xd.svg"
                                                                                                                                                                        class="avatar avatar-sm rounded-circle me-2"
                                                                                                                                                                        alt="xd"
                                                                                                                                                                    />
                                                                                                                                                                </div>
                                                                                                                                                                <div class="my-auto">
                                                                                                                                                                    <h6
                                                                                                                                                                        class="mb-0 text-sm"
                                                                                                                                                                    >
                                                                                                                                                                        Adobe XD
                                                                                                                                                                                                                                </h6>
                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                    <td>
                                                                                                                                                                                                                        <p
                                                                                                                                                                                                                            class="text-sm font-weight-bold mb-0"
                                                                                                                                                                                                                        >
                                                                                                                                                                                                                            $2,300
                                                                                                                                                                                                                        </p>
                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                    <td>
                                                                                                                                                                                                                        <span
                                                                                                                                                                                                                            class="text-xs font-weight-bold"
                                                                                                                                                                                                                            >done</span
                                                                                                                                                                                                                        >
                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                    <td
                                                                                                                                                                                                                        class="align-middle text-center"
                                                                                                                                                                                                                    >
                                                                                                                                                                                                                        <div
                                                                                                                                                                                                                            class="d-flex align-items-center justify-content-center"
                                                                                                                                                                                                                        >
                                                                                                                                                                                                                            <span
                                                                                                                                                                                                                                class="me-2 text-xs font-weight-bold"
                                                                                                                                                                                                                                >100%</span
                                                                                                                                                                                                                            >
                                                                                                                                                                                                                            <div>
                                                                                                                                                                                                                                <div
                                                                                                                                                                                                                                    class="progress"
                                                                                                                                                                                                                                >
                                                                                                                                                                                                                                    <div
                                                                                                                                                                                                                                        class="progress-bar bg-gradient-success"
                                                                                                                                                                                                                                        role="progressbar"
                                                                                                                                                                                                                                        aria-valuenow="100"
                                                                                                                                                                                                                                        aria-valuemin="0"
                                                                                                                                                                                                                                        aria-valuemax="100"
                                                                                                                                                                                                                                        style="
                                                                                                                                                                                                                                            width: 100%;
                                                                                                                                                                                                                                        "
                                                                                                                                                                                                                                    ></div>
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                    <td class="align-middle">
                                                                                                                                                                                                                        <button
                                                                                                                                                                                                                            class="btn btn-link text-secondary mb-0"
                                                                                                                                                                                                                            aria-haspopup="true"
                                                                                                                                                                                                                            aria-expanded="false"
                                                                                                                                                                                                                        >
                                                                                                                                                                                                                            <i
                                                                                                                                                                                                                                class="fa fa-ellipsis-v text-xs"
                                                                                                                                                                                                                            ></i>
                                                                                                                                                                                                                        </button>
                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                </tr>
                                                                                                                                                                                                        </tbody>
                                                                                                                                                                                                    </table>
                                                                                                                                                                                                </div>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    </div>
                                                                                                                                                                                </div> -->
        </div>
    </div>
</template>
<style scoped>
.focus\:border-gray-200:focus {
    box-shadow: none;
}

.backdrop-modal-edit-role {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.2);
}
</style>
