<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Người dùng</h6>
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
                                                    <img :src="item.avatar"
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
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold mb-0">
                                                        {{ item.email }}
                                                    </span>
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
                                            @click="closeModalEditUserRole()" style="background: rgba(0, 0, 0, 0.2);"></div>
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
                                                            ></tag-input>
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
                                            <div class="flex items-center px-2">
                                                <div class="flex items-center pr-1">
                                                        <i class='bx bxs-shield text-lg text-sky-500' ></i>
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
                                                        item,
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
                                            @click="closeModalEditRole()" style="background: rgba(0, 0, 0, 0.2);"></div>
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
                                                            ></tag-input>
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
                                    class="block w-full py-2 px-1 mt-1 bg-transparent mb-2 text-gray-800 appearance-none border-t-0 border-r-0 border-l-0 border-b-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 :focus:ring-0" />
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
                                            <div class="flex items-center px-2">
                                                <div class="flex items-center pr-1">
                                                    <i class='bx bx-star text-lg text-amber-600'></i>

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
                                                        item,
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
                                            @click="closeModalEditPermission()" style="background: rgba(0, 0, 0, 0.2);"></div>
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
                                                            ></tag-input>
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
                                class="block w-full py-2 px-1 mt-1 mb-2 text-gray-800 bg-transparent appearance-none border-t-0 border-r-0 border-l-0 border-b-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 :focus:ring-0" />
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
</div>
</template>
<script setup>
import { onMounted } from "vue";
import { initModals } from "flowbite";
import TagInput from "@/components/admin/ui/SearchTag.vue";
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import "@/assets/admin/css/pagination-styles.css";
import {
    rolesStore, formAddRole, formAddPermission, formEditRole, formEditPermission, formEditUserRole, formEditDetailUser,
    checkValiAddRole, checkValiEditRole, checkValiAddPermission, checkValiEditPermission,
    errorUserRole, errorUserPermission, errorRolePermission, errorPermissionRole, pageRole, pageUser,  pagePermission, itemsPerPageRole, itemsPerPagePermission,  itemsPerPageUser, indexStartUser, indexEndUser, indexStartRole, indexEndRole, indexStartPermission, indexEndPermission,
    listRoles, listPermissions, listUsers, totalPagesRole, totalPagesPermission,  totalPagesUser, displayedItemsRole,  displayedItemsPermission, displayedItemsUser, onPageChanged, onPageChangedUser, onPageChangedPermission, updatedRoleUser, updatedPermissionUser, updatedPermission, updatedRolePermission, isReadonly, updateRoleUser,  updatePermissionUser, givePermissionForRole, revokePermission, revokePermissionUser, asignRole, removeRoleOfPermission, removeRoleUser, modelValueEditRole,  modelValueEditPermission, deleteRole, deletePermission, addRole, addPermission, valiEmptyInput, editRole, editPermission, showModalEditUserRole, showModalEditPermission, showModalEditRole, closeModalEditRole, closeModalEditPermission, closeModalEditUserRole, sortTable, sortTableRole, sortTablePermission, sortIcon, sortIconRole, sortIconPermission,
} from '@/components/admin/process/RoleProcess.js';
import { formatDateTime } from '@/assets/js/app.js'
onMounted(async () => {
    initModals();
    await rolesStore.getRoles();
    await rolesStore.getPermissions();
    await rolesStore.getUsers()
});
</script>
<style scoped>
#admin h3 {
    font-size: 1.567rem;
}
.focus\:border-gray-200:focus {
    box-shadow: none;
}

.backdrop-modal-edit-role {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.hennge-pagination-custom button.Page-active {
    color: #fff !important;
}</style>
