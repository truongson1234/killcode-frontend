<template>
    <div>
        <div class="row">
            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Các chủ đề</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table
                                class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th @click="sortTable('name')"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 cursor-pointer">
                                            Tên chủ đề <i
                                                :class="sortIcon('name')"></i>

                                        </th>
                                        <th @click="sortTable('slug')"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 cursor-pointer">
                                            Slug <i :class="sortIcon('slug')"></i>

                                        </th>
                                        <th @click="sortTable('created_at')"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 cursor-pointer">
                                            Ngày tạo <i
                                                :class="sortIcon('created_at')"></i>

                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Khác
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in displayedItemsTag"
                                        :key="item.name">
                                        <td>
                                            <div class="flex px-2 items-center">
                                                <img :src="item.thumbnail" alt=""
                                                    class="thumbnail-tag pr-1">
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
                                                    item.slug
                                                }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-xs font-weight-bold">{{
                                                    formatDateTime(item.created_at)
                                                }}</span>
                                        </td>

                                        <td>
                                            <div class="flex gap-x-1">
                                                <button
                                                    @click="deleteTag(item, item.id)"
                                                    class="px-2 py-1.5 rounded-sm bg-red-600 text-white flex">
                                                    <i
                                                        class="bx bxs-trash-alt self-center justify-self-center"></i>
                                                </button>
                                                <button type="button"
                                                    @click="showModalEditTag(item, item.id, item.name, item.slug)"
                                                    class="px-2 py-1.5 rounded-sm bg-green-600 text-white flex">
                                                    <i
                                                        class="bx bxs-edit self-center justify-self-center"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <div id="modal-edit-tag"
                                        class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
                                        <div class="backdrop-modal-edit-tag absolute z-10"
                                            @click="closeModalEditTag()"
                                            style="background: rgba(0, 0, 0, 0.2);">
                                        </div>
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
                                                        closeModalEditTag()
                                                        ">
                                                    <i class="bx bx-x text-xl"></i>
                                                </button>
                                                <div class="px-4 py-4 lg:px-5"
                                                    style="width: 450px">
                                                    <h3
                                                        class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                        Chỉnh sửa thẻ: {{
                                                            formEditTag.name }}
                                                    </h3>
                                                    <form class="space-y-6"
                                                        @submit.prevent="
                                                            editTag(
                                                                formEditTag.id,
                                                                formEditTag
                                                            )
                                                            ">
                                                        <div>
                                                            <p for="name-role"
                                                                class="leading-8">
                                                                Tên thẻ:</p>
                                                            <input type="text"
                                                                name="name-role"
                                                                placeholder=""
                                                                class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md text-sm focus:border-black shadow-sm"
                                                                v-model="formEditTag.name
                                                                    "
                                                                @keyup="valiEmptyInput('name-edit', formEditTag.name)" />
                                                            <div v-if="checkValiEditTag.name"
                                                                class="mt-0 mb-0">
                                                                <span
                                                                    class="text-red-400 text-sm p-2 pt-3 px-0">Không
                                                                    được để trống
                                                                    tên
                                                                    thẻ!</span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p for="name-slug"
                                                                class="leading-8">
                                                                Tên slug:</p>
                                                            <input type="text"
                                                                name="slug-role"
                                                                placeholder=""
                                                                class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md text-sm focus:border-black shadow-sm"
                                                                v-model="formEditTag.slug
                                                                    "
                                                                @keyup="valiEmptyInput('slug-edit', formEditTag.slug)" />
                                                            <div v-if="checkValiEditTag.slug"
                                                                class="mt-0 mb-0">
                                                                <span
                                                                    class="text-red-400 text-sm p-2 pt-3 px-0">Không
                                                                    được để trống
                                                                    tên
                                                                    slug!</span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p for=""
                                                                class="leading-8">
                                                                Chọn ảnh thumbnail
                                                                nếu cần thay
                                                                đổi:</p>
                                                            <label class="block">
                                                                <span
                                                                    class="sr-only">Choose
                                                                    profile
                                                                    photo</span>
                                                                <input type="file"
                                                                    class="block w-full text-sm text-slate-500
                                                                        file:mr-4 file:py-2 file:px-4
                                                                        file:rounded-full file:border-0
                                                                        file:text-sm file:font-semibold
                                                                        file:bg-violet-50 file:text-violet-700
                                                                        hover:file:bg-violet-100
                                                                        "
                                                                    id="thumbnail-update-tag"
                                                                    accept="image/*" />
                                                            </label>
                                                            <div
                                                                v-if="checkValiEditTag.size">
                                                                <span
                                                                    class="text-red-400 text-sm p-2 px-0">Ảnh
                                                                    vượt quá
                                                                    2MB!</span>
                                                            </div>
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
                    <div class="flex justify-between align-center"
                        v-if="listTags != null && listTags.length > itemsPerPage">
                        <div>
                            <v-pagination v-model="pageTag" :pages="totalPagesTag"
                                :range-size="1" active-color="#0074FF"
                                class="my-3 pl-2"
                                @update:modelValue="onPageChanged" />
                        </div>
                        <div style="line-height: 54px;" class="pr-4">
                            <span
                                class="text-secondary text-xs font-weight-bold">Hiển
                                thị: {{ indexStartTag }} - {{ indexEndTag }} / {{
                                    listTags.length }} bản ghi.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Thêm thẻ</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive p-0">
                            <form @submit.prevent="addTag(formAddTag)">
                                <input id="text_role" type="text" name="name"
                                    v-model="formAddTag.name"
                                    placeholder="Nhập tên thẻ..."
                                    @keyup="valiEmptyInput('name', formAddTag.name)"
                                    class="block w-full py-2 px-1 mt-1 bg-transparent mb-2 text-gray-800 appearance-none border-t-0 border-r-0 border-l-0 border-b-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 :focus:ring-0" />
                                <div v-if="checkValiAddTag.name">
                                    <span class="text-red-400 text-sm p-2 px-0">Vui
                                        lòng nhập tên thẻ!</span>
                                </div>
                                <input id="text_role" type="text" name="slug"
                                    v-model="formAddTag.slug"
                                    placeholder="Nhập tên slug thẻ..."
                                    @keyup="valiEmptyInput('slug', formAddTag.slug)"
                                    class="block w-full py-2 px-1 mt-1 bg-transparent mb-2 text-gray-800 appearance-none border-t-0 border-r-0 border-l-0 border-b-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 :focus:ring-0" />
                                <div v-if="checkValiAddTag.slug">
                                    <span class="text-red-400 text-sm p-2 px-0">Vui
                                        lòng nhập slug thẻ!</span>
                                </div>
                                <label class="block">
                                    <input type="file" title="Chọn ảnh thumbnail"
                                        class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-violet-50 file:text-violet-700
                                        hover:file:bg-violet-100
                                        " id="thumbnail-add-tag" />
                                </label>
                                <div v-if="checkValiAddTag.thumbnail">
                                    <span class="text-red-400 text-sm p-2 px-0">Vui
                                        lòng chọn ảnh thumbnail!</span>
                                </div>
                                <div v-if="checkValiAddTag.size">
                                    <span class="text-red-400 text-sm p-2 px-0">Ảnh
                                        vượt quá 2MB!</span>
                                </div>
                                <button type="submit"
                                    class="px-2 py-1.5 rounded-sm bg-blue-600 text-white text-sm mt-1 block">
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
import { tagStore, listTags, onPageChanged, itemsPerPage, pageTag, indexStartTag, indexEndTag, displayedItemsTag, totalPagesTag, deleteTag, addTag, formAddTag, formEditTag, valiEmptyInput, checkValiAddTag, showModalEditTag, closeModalEditTag, checkValiEditTag, editTag, sortIcon, sortTable } from "@/components/admin/process/TagProcess.js";
import { formatDateTime } from '@/assets/js/app.js'
onMounted(async () => {
    initModals();
    $("#thumbnail-add-tag").change(function () {
        readURL(this, 'add');
    });
    $("#thumbnail-update-tag").change(function () {
        readURL(this, 'update');
    });
    await tagStore.getTags()
});
const readURL = (input, type) => {
    if (type == 'add') {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                // Lấy tên file
                var fileName = input.files[0].name;
                var fileSize = input.files[0].size / 1024 / 1024;
                formAddTag.value.size = fileSize
                var fileData = reader.result;
                if (fileSize > 2) {
                    checkValiAddTag.value.size = true
                }
                formAddTag.value.nameImage = fileName
                formAddTag.value.image = fileData
            }
            reader.readAsDataURL(input.files[0]);
        }
    } else if (type == 'update') {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                // Lấy tên file
                var fileName = input.files[0].name;
                var fileSize = input.files[0].size / 1024 / 1024;
                formEditTag.value.size = fileSize
                var fileData = reader.result;
                if (fileSize > 2) {
                    checkValiEditTag.value.size = true
                }
                formEditTag.value.nameImage = fileName
                formEditTag.value.image = fileData
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

}
</script>
<style scoped>
.thumbnail-tag {
    width: 30px;
    height: 30px;
    object-fit: contain;
}

#admin h3 {
    font-size: 1.567rem;
}

#admin p.leading-8 {
    margin-bottom: .5rem;
}

.focus\:border-gray-200:focus {
    box-shadow: none;
}

.backdrop-modal-edit-tag {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.2);
}

.hennge-pagination-custom button.Page-active {
    color: #fff !important;
}</style>
