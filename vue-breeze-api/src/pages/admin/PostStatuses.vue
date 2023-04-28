<template>
    <section
        class="antialiased bg-gray-100 text-gray-600 h-screen px-4"
        x-data="app"
    >
        <div class="flex flex-col justify-center h-full">
            <!-- Table -->
            <div
                class="w-full mx-auto bg-white shadow-lg rounded-sm border border-gray-200"
            >
                <header class="px-4 py-4 border-b border-gray-100">
                    <div class="font-semibold text-gray-800">
                        <ModalPostStatuses @update-statuses="updateStatuses" />
                    </div>
                </header>

                <div class="overflow-x-auto p-4">
                    <table class="table-auto w-full">
                        <thead
                            class="text-xs font-semibold uppercase text-gray-400 bg-gray-50"
                        >
                            <tr>
                                <th class="p-2">
                                    <div class="font-semibold text-left">
                                        Tên
                                    </div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">
                                        Mô tả
                                    </div>
                                </th>
                                <th class="p-2">
                                    <div
                                        class="font-semibold text-center"
                                    ></div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="text-sm divide-y divide-gray-100">
                            <!-- record -->
                            <tr
                                v-for="postStatus in postStatuses"
                                :key="postStatus.id"
                            >
                                <td class="p-2">
                                    <div class="font-medium text-gray-800">
                                        {{ postStatus.name }}
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-left">
                                        {{ postStatus.describe }}
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="flex justify-center">
                                        <button
                                            v-if="!postStatus.is_default"
                                            @click="removeStatuses(postStatus.id)"
                                            type="button"
                                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                        >
                                            <i class="bx bx-trash"></i>
                                        </button>
                                        <button
                                            v-else
                                            disabled
                                            type="button"
                                            class="py-2.5 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                        >
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import ModalPostStatuses from "@/components/ui/ModalPostStatuses.vue";

const postStatuses = ref([]);

onMounted(() => {
    fetchData();
});

const fetchData = () => {
    axios
        .get("/api/dashboard/post-statuses")
        .then((response) => {
            postStatuses.value = response.data.post_statuses;
            // console.log(postStatuses);
        })
        .catch((error) => {
            console.log(error);
        });
};

const updateStatuses = (data) => {
    postStatuses.value = data;
};

const removeStatuses = async (id) => {
    await axios
            .delete(`/api/dashboard/post-statuses/${id}`)
            .then((response) => {
                postStatuses.value = response.data.post_statuses;
                // console.log(postStatuses);
            })
            .catch((error) => {
                console.log(error);
            });
};
</script>

<style lang="scss" scoped></style>
