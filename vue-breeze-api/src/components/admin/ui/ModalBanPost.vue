<template>
    <div>
        <button
            @click="openModal"
            type="button"
            class="mx-2 focus:outline-none text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-900"
        >
            <i class='bx bx-bug'></i>
        </button>
        <div
            class="main-modal fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster"
            style="background: rgba(0, 0, 0, 0.7)"
            v-if="isModalOpen"
        >
            <div
                class="border border-teal-500 shadow-lg modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto"
            >
                <div class="modal-content py-4 text-left px-3">
                    <!--Title-->
                    <div class="flex justify-between items-center">
                        <p class="text-2xl font-bold mb-4 text-bold">
                            Điền thông tin lệnh cấm
                        </p>
                        <div
                            class="modal-close cursor-pointer z-50 mb-4"
                            @click="closeModal"
                        >
                            <svg
                                class="fill-current text-black"
                                xmlns="http://www.w3.org/2000/svg"
                                width="18"
                                height="18"
                                viewBox="0 0 18 18"
                            >
                                <path
                                    d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"
                                ></path>
                            </svg>
                        </div>
                    </div>
                    <!--Body-->
                    <div class="">
                        <form @submit.prevent="handleSubmit">
                            <div class="mb-4">
                                <label
                                    for="title"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Tiêu đề</label
                                >
                                <input
                                    v-model="formData.title"
                                    type="text"
                                    id="title"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="cảnh báo: vi phạm nội dung"
                                    required
                                />
                            </div>
                            <div class="mb-4">
                                <label
                                    for="reason"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Mô tả</label
                                >
                                <input
                                    v-model="formData.reason"
                                    type="text"
                                    id="reason"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="người dùng đã vi phạm..."
                                    required
                                />
                            </div>
                            <button
                                type="submit"
                                class="float-right text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                            >
                                Xác nhận
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            isModalOpen: false,
            formData: {
                title: "",
                reason: "",
            },
        };
    },
    props: {
        post_id: Number
    },
    methods: {
        closeModal() {
            this.isModalOpen = false;
        },
        openModal() {
            this.isModalOpen = true;
        },
        async handleSubmit() {
            await axios
                .post(`/api/dashboard/posts/${this.post_id}/ban`, this.formData)
                .then((response) => {
                    // posts.value = response.data.posts;
                    if (response.data.status == 1) {
                        this.formData.title = "";
                        this.formData.reason = "";

                        this.closeModal();
                        this.$emit('update-posts', response.data.posts);

                        Swal.fire(
                            'Đã ban lệnh cấm với bài viết này!',
                            'You clicked the button!',
                            'success'
                        )
                    }
                    console.log(response);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
