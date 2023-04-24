<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input
                                id="checkbox-all-search"
                                type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            />
                            <label for="checkbox-all-search" class="sr-only"
                                >checkbox</label
                            >
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">Tiều đề</th>
                    <th scope="col" class="px-6 py-3">Nội dung</th>
                    <th scope="col" class="px-6 py-3">Bình luận</th>
                    <th scope="col" class="px-6 py-3">Lượt thích</th>
                    <th scope="col" class="px-6 py-3">Lượt xem</th>
                    <th scope="col" class="px-6 py-3">Tác giả</th>
                    <th scope="col" class="px-6 py-3">Thẻ</th>
                    <th scope="col" class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                >
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input
                                id="checkbox-table-search-2"
                                type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            />
                            <label for="checkbox-table-search-2" class="sr-only"
                                >checkbox</label
                            >
                        </div>
                    </td>
                    <th
                        scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        C# cơ bản
                    </th>
                    <td class="px-6 py-4">Bước đầu...</td>
                    <td class="px-6 py-4">0</td>
                    <td class="px-6 py-4">0</td>
                    <td class="px-6 py-4">0</td>
                    <td class="px-6 py-4">Nguyễn Văn A</td>
                    <td class="px-6 py-4">c#, newbie</td>
                    <td class="flex items-center px-6 py-4 space-x-3">
                        <a
                            href="#"
                            class="font-medium text-red-600 dark:text-red-500 hover:underline"
                            >Remove</a
                        >
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup></script>

<style lang="scss" scoped></style>
