<template>
    <div class="container">
        <div class="grid grid-cols-4 gap-x-2 gap-y-5 mx-auto" aria-label="Sidebar">
            <div
                class="px-3 py-1 overflow-y-auto rounded bg-gray-50 dark:bg-gray-800 col-span-4 p-3 h-100 row-span-1 lg:col-span-1 lg:row-span-1 border-r">
                <ul class="space-y-2" data-tabs-toggle="#myTabContent"
                    role="tablist">
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-example"
                            data-collapse-toggle="dropdown-example">
                            <i
                                class='bx bxs-pencil flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white text-lg'></i>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap"
                                sidebar-toggle-item>Bài viết
                                <span
                                    class="inline-flex items-center justify-center w-2 h-2 p-2.5 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">{{
                                        draftPost.length + publicPost.length +
                                        offendingPost.length }}</span>
                            </span>
                            <i class='bx bx-chevron-down text-2xl'
                                sidebar-toggle-item></i>
                        </button>
                        <ul id="dropdown-example" class="py-2 space-y-2 ml-7">
                            <li>
                                <button id="draft-post-tab"
                                    @click="handleClickActiveBtn(1)"
                                    data-tabs-target="#post" type="button"
                                    role="tab" aria-controls="post"
                                    aria-selected="true"
                                    class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11"
                                    :class="{ 'bg-gray-100 text-blue-600': activeBtn == 1, 'text-gray-900': activeBtn != 1 }"><i
                                        class="bx bxs-lock-alt text-md pr-3"></i>
                                    Bản nháp <span
                                        class="inline-flex items-center justify-center w-2 h-2 p-2.5 ml-1 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">{{
                                            draftPost.length }}</span>
                                </button>
                            </li>
                            <li>
                                <button id="block-post-tab"
                                    @click="handleClickActiveBtn(2)"
                                    data-tabs-target="#block-post" type="button"
                                    role="tab" aria-controls="block-post"
                                    class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11"
                                    :class="{ 'bg-gray-100 text-blue-600': activeBtn == 2, 'text-gray-900': activeBtn != 2 }"><i
                                        class="bx bx-block text-md pr-3"></i>
                                    Vi phạm <span
                                        class="inline-flex items-center justify-center w-2 h-2 p-2.5 ml-1 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">{{
                                            offendingPost.length }}</span>
                                </button>
                            </li>
                            <li>
                                <button id="public-post-tab"
                                    @click="handleClickActiveBtn(3)"
                                    data-tabs-target="#public-post" type="button"
                                    role="tab" aria-controls="public-post"
                                    class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11"
                                    :class="{ 'bg-gray-100 text-blue-600': activeBtn == 3, 'text-gray-900': activeBtn != 3 }"><i
                                        class="bx bx-world text-md pr-3"></i>
                                    Công khai <span
                                        class="inline-flex items-center justify-center w-2 h-2 p-2.5 ml-1 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">{{
                                            publicPost.length }}</span>
                                </button>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-example2"
                            data-collapse-toggle="dropdown-example2">
                            <i
                                class='bx bx-question-mark flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white text-lg'></i>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap"
                                sidebar-toggle-item>Câu hỏi
                                <span
                                    class="inline-flex items-center justify-center w-2 h-2 p-2.5 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">{{
                                        draftQuestion.length + publicQuestion.length + offendingQuestion.length
                                    }}</span>
                            </span>
                            <i class='bx bx-chevron-down text-2xl'
                                sidebar-toggle-item></i>
                        </button>
                        <ul id="dropdown-example2" class="py-2 space-y-2 ml-7">
                            <li>
                                <button id="draft-question-tab"
                                    @click="handleClickActiveBtn(4)"
                                    data-tabs-target="#draft-question" type="button"
                                    role="tab" aria-controls="draft-question"
                                    class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11"
                                    :class="{ 'bg-gray-100 text-blue-600': activeBtn == 4, 'text-gray-900': activeBtn != 4 }"><i
                                        class="bx bxs-lock-alt text-md pr-3"></i>
                                    Bản nháp <span
                                        class="inline-flex items-center justify-center w-2 h-2 p-2.5 ml-1 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">{{
                                            draftQuestion.length }}</span>
                                </button>
                            </li>
                            <li>
                                <button id="block-question-tab"
                                    @click="handleClickActiveBtn(5)"
                                    data-tabs-target="#block-question" type="button"
                                    role="tab" aria-controls="block-question"
                                    class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11"
                                    :class="{ 'bg-gray-100 text-blue-600': activeBtn == 5, 'text-gray-900': activeBtn != 5 }"><i
                                        class="bx bx-block text-md pr-3"></i>
                                    Vi phạm <span
                                        class="inline-flex items-center justify-center w-2 h-2 p-2.5 ml-1 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">{{
                                            offendingQuestion.length }}</span>
                                </button>
                            </li>
                            <li>
                                <button id="public-question-tab"
                                    @click="handleClickActiveBtn(6)"
                                    data-tabs-target="#public-question"
                                    type="button" role="tab"
                                    aria-controls="public-question"
                                    class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11"
                                    :class="{ 'bg-gray-100 text-blue-600': activeBtn == 6, 'text-gray-900': activeBtn != 6 }"><i
                                        class="bx bx-world text-md pr-3"></i>
                                    Công khai <span
                                        class="inline-flex items-center justify-center w-2 h-2 p-2.5 ml-1 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">{{
                                            publicQuestion.length }}</span>
                                </button>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!--* CONTAINER POST  -->
            <div id="myTabContent"
                class="col-span-4 row-span-1 lg:col-span-3 lg:row-span-3 px-3 py-1">

                <!--! ***************************BÀI VIẾT******************************* -->
                <!-- BẢN NHÁP  -->
                <div class="pt-2 rounded-lg dark:bg-gray-800 hidden" id="post"
                    role="tabpanel" aria-labelledby="draft-post-tab">
                    <h2 class="text-gray-800 font-medium text-lg border-b pb-2">Bản
                        nháp</h2>
                    <div v-if="draftPost && draftPost.length > 0" class="mt-3">
                        <div class="mb-2">
                            <form
                                @submit.prevent="searchPost(dataSearch.post, 'draft')">
                                <label for="default-search"
                                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
                                <div class="relative">
                                    <div
                                        class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="search" id="default-search"
                                        class="block px-5 py-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Nhập tiêu đề bài viết"
                                        v-model="dataSearch.post.title">
                                    <button type="submit"
                                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tìm
                                        kiếm</button>
                                </div>
                            </form>
                        </div>
                        <div class="py-2 border-b" v-for="post in displayDraftPost"
                            :key="post.id">
                            <div class="flex items-center ">
                                <router-link
                                    :to="{ name: 'PostDetail', params: { id: post.id } }"
                                    class="text-gray-800 text-lg flex items-center">
                                    <i
                                        class='bx bxs-lock-alt text-gray-400 text-lg pr-2'></i>
                                    {{ post.title }}
                                </router-link>
                                <div class="ml-2">
                                    <router-link
                                        :to="{ name: 'TagDetail', params: { id: tag.pivot.tag_id } }"
                                        class="inline-flex items-center bg-blue-100 text-blue-800 text-xs md:text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 "
                                        v-for="tag in post.tags" :key="tag.slug">{{
                                            tag.name }}</router-link>
                                </div>
                            </div>
                            <div
                                class="mt-1.5 text-sm text-gray-500 flex items-center">
                                <span>Sửa lần cuối: {{ formatDateTime(new
                                    Date(post.updated_at)) }}</span>
                                <div class="relative">
                                    <button class="text-lg ml-1 flex items-center"
                                        @click="showDropDownDraft($event, post.id)">
                                        <i class='bx bx-chevron-down'></i>
                                    </button>
                                    <ul :id="`drop-down-draft-${post.id}`"
                                        class="bg-white shadow-[0_3px_10px_rgb(0,0,0,0.2)] rounded w-28 absolute hidden z-20 drop-down-container">
                                        <router-link
                                            :to="{ name: 'PostEdit', params: { id: post.id, auth: authId } }"
                                            class="py-2 block px-2 hover:bg-blue-100">
                                            <i
                                                class='bx bxs-edit-alt mr-1'></i>Sửa</router-link>
                                        <button
                                            @click="deletePost(post.id, 'draft')"
                                            class="w-full text-left py-2 px-2 hover:bg-blue-100"><i
                                                class='bx bxs-trash mr-1'></i>Xóa</button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="draftPost && draftPost != null && draftPost.length > itemPerPagePost">
                            <v-pagination v-model="pagePost" :pages="totalPagesPost"
                                :range-size="1" active-color="#0074FF"
                                class="my-3 pl-0"
                                @update:modelValue="onPageChanged" />
                        </div>
                    </div>
                    <div v-else>
                        <h4 class="font-semibold text-center text-gray-500 mt-3">
                            Không có gì ở đây cả</h4>
                    </div>
                </div>

                <!-- VI PHẠM  -->
                <div class="pt-2 rounded-lg dark:bg-gray-800 hidden" id="block-post"
                    role="tabpanel" aria-labelledby="block-post-tab">
                    <h2 class="text-gray-800 font-medium text-lg border-b pb-2">Vi
                        phạm</h2>
                    <div v-if="offendingPost && offendingPost.length > 0"
                        class="mt-3">
                        <div class="mb-2">
                            <form
                                @submit.prevent="searchPost(dataSearch.blockPost, 'offending')">
                                <label for="default-search"
                                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
                                <div class="relative">
                                    <div
                                        class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="search" id="default-search"
                                        class="block px-5 py-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Nhập tiêu đề bài viết"
                                        v-model="dataSearch.blockPost.title">
                                    <button type="submit"
                                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tìm
                                        kiếm</button>
                                </div>
                            </form>
                        </div>
                        <div class="py-2 border-b"
                            v-for="post in displayOffendingPost" :key="post.id">
                            <div class="flex items-center ">
                                <router-link
                                    :to="{ name: 'PostDetail', params: { id: post.id } }"
                                    class="text-gray-800 text-lg flex items-center">
                                    <i
                                        class='bx bx-block text-red-700 text-lg pr-2'></i>
                                    {{ post.title }}
                                </router-link>
                                <div class="ml-2">
                                    <router-link
                                        :to="{ name: 'TagDetail', params: { id: tag.pivot.tag_id } }"
                                        class="inline-flex items-center bg-blue-100 text-blue-800 text-xs md:text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 "
                                        v-for="tag in post.tags" :key="tag.slug">{{
                                            tag.name }}</router-link>
                                </div>
                            </div>
                            <div
                                class="mt-1.5 text-sm text-gray-500 flex items-center">
                                <span>Vi phạm lúc: {{ formatDateTime(new
                                    Date(post.created_at)) }}</span>
                                <div class="relative">
                                    <button class="text-lg ml-1 flex items-center"
                                        @click="showDropDownDraft($event, post.id)">
                                        <i class='bx bx-chevron-down'></i>
                                    </button>
                                    <ul :id="`drop-down-draft-${post.id}`"
                                        class="bg-white shadow-[0_3px_10px_rgb(0,0,0,0.2)] rounded w-28 absolute hidden z-20 drop-down-container">
                                        <button
                                            class="w-full text-left py-2 px-2 hover:bg-blue-100"><i
                                                class='bx bxs-wrench mr-1'></i>Khiếu
                                            nại</button>
                                        <button
                                            @click="deletePost(post.id, 'offending')"
                                            class="w-full text-left py-2 px-2 hover:bg-blue-100"><i
                                                class='bx bxs-trash mr-1'></i>Xóa</button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="offendingPost && offendingPost != null && offendingPost.length > itemPerPageOffendingPost">
                            <v-pagination v-model="pageOffendingPost"
                                :pages="totalPagesOffendingPost" :range-size="1"
                                active-color="#0074FF" class="my-3 pl-0"
                                @update:modelValue="onPageChangedOffendingPost" />
                        </div>
                    </div>
                    <div v-else>
                        <h4 class="font-semibold text-center text-gray-500 mt-3">
                            Không có gì ở đây cả</h4>
                    </div>
                </div>

                <!-- CÔNG KHAI  -->
                <div class="pt-2 rounded-lg dark:bg-gray-800 hidden"
                    id="public-post" role="tabpanel"
                    aria-labelledby="public-post-tab">
                    <h2 class="text-gray-800 font-medium text-lg border-b pb-2">Công
                        khai</h2>
                    <div v-if="publicPost && publicPost.length > 0" class="mt-3">
                        <div class="mb-2">
                            <form
                                @submit.prevent="searchPost(dataSearch.publicPost, 'public')">
                                <label for="default-search"
                                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
                                <div class="relative">
                                    <div
                                        class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="search" id="default-search"
                                        class="block px-5 py-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Nhập tiêu đề bài viết"
                                        v-model="dataSearch.publicPost.title">
                                    <button type="submit"
                                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tìm
                                        kiếm</button>
                                </div>
                            </form>
                        </div>
                        <div class="py-2 border-b" v-for="post in displayPublicPost"
                            :key="post.id">
                            <div class="flex items-center ">
                                <router-link
                                    :to="{ name: 'PostDetail', params: { id: post.id } }"
                                    class="text-gray-800 text-lg flex items-center">
                                    <i
                                        class='bx bx-world text-emerald-500 text-lg pr-2'></i>
                                    {{ post.title }}
                                </router-link>
                                <div class="ml-2">
                                    <router-link
                                        :to="{ name: 'TagDetail', params: { id: tag.pivot.tag_id } }"
                                        class="inline-flex items-center bg-blue-100 text-blue-800 text-xs md:text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 "
                                        v-for="tag in post.tags" :key="tag.slug">{{
                                            tag.name }}</router-link>
                                </div>
                            </div>
                            <div
                                class="mt-1.5 text-sm text-gray-500 flex items-center">
                                <span>Đăng lúc: {{ formatDateTime(new
                                    Date(post.created_at)) }}</span>
                                <div class="relative">
                                    <button class="text-lg ml-1 flex items-center"
                                        @click="showDropDownDraft($event, post.id)">
                                        <i class='bx bx-chevron-down'></i>
                                    </button>
                                    <ul :id="`drop-down-draft-${post.id}`"
                                        class="bg-white shadow-[0_3px_10px_rgb(0,0,0,0.2)] rounded w-28 absolute hidden z-20 drop-down-container">
                                        <router-link
                                            :to="{ name: 'PostEdit', params: { id: post.id, auth: authId } }"
                                            class="py-2 block px-2 hover:bg-blue-100"><i
                                                class='bx bxs-edit-alt mr-1'></i>Sửa</router-link>
                                        <button
                                            @click="deletePost(post.id, 'public')"
                                            class="w-full text-left py-2 px-2 hover:bg-blue-100"><i
                                                class='bx bxs-trash mr-1'></i>Xóa</button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="publicPost && publicPost != null && publicPost.length > itemPerPagePublicPost">
                            <v-pagination v-model="pagePublicPost"
                                :pages="totalPagesPublicPost" :range-size="1"
                                active-color="#0074FF" class="my-3 pl-0"
                                @update:modelValue="onPageChangedPublicPost" />
                        </div>
                    </div>
                    <div v-else>
                        <h4 class="font-semibold text-center text-gray-500 mt-3">
                            Không có gì ở đây cả</h4>
                    </div>
                </div>
                <!--! *********************************************************** -->

                <!--! ***************************CÂU HỎI******************************* -->
                <!-- BẢN NHÁP  -->
                <div class="pt-2 rounded-lg dark:bg-gray-800 hidden"
                    id="draft-question" role="tabpanel"
                    aria-labelledby="draft-question-tab">
                    <h2 class="text-gray-800 font-medium text-lg border-b pb-2">Bản
                        nháp</h2>
                    <div v-if="draftQuestion && draftQuestion.length > 0"
                        class="mt-3">
                        <div class="mb-2">

                            <form
                                @submit.prevent="searchQuestion(dataSearch.question, 'draft')">
                                <label for="default-search"
                                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
                                <div class="relative">
                                    <div
                                        class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="search" id="default-search"
                                        class="block px-5 py-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Nhập tiêu đề câu hỏi"
                                        v-model="dataSearch.question.title">
                                    <button type="submit"
                                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tìm
                                        kiếm</button>
                                </div>
                            </form>
                        </div>
                        <div class="py-2 border-b"
                            v-for="question in displayDraftQuestion"
                            :key="question.id">
                            <div class="flex items-center ">
                                <router-link
                                    :to="{ name: 'QuestionDetail', params: { id: question.id } }"
                                    class="text-gray-800 text-lg flex items-center">
                                    <i
                                        class='bx bxs-lock-alt text-gray-400 text-lg pr-2'></i>
                                    {{ question.title }}
                                </router-link>
                                <div class="ml-2">
                                    <router-link
                                        :to="{ name: 'TagDetail', params: { id: tag.pivot.tag_id } }"
                                        class="inline-flex items-center bg-blue-100 text-blue-800 text-xs md:text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 "
                                        v-for="tag in question.tags"
                                        :key="tag.slug">{{
                                            tag.name }}</router-link>
                                </div>
                            </div>
                            <div
                                class="mt-1.5 text-sm text-gray-500 flex items-center">
                                <span>Sửa lần cuối: {{ formatDateTime(new
                                    Date(question.updated_at)) }}</span>
                                <div class="relative">
                                    <button class="text-lg ml-1 flex items-center"
                                        @click="showDropDownQuestion($event, question.id)">
                                        <i class='bx bx-chevron-down'></i>
                                    </button>
                                    <ul :id="`drop-down-question-${question.id}`"
                                        class="bg-white shadow-[0_3px_10px_rgb(0,0,0,0.2)] rounded w-28 absolute hidden z-20 drop-down-question-container">
                                        <router-link
                                            :to="{ name: 'QuestionEdit', params: { id: question.id, auth: authId } }"
                                            class="py-2 block px-2 hover:bg-blue-100"><i
                                                class='bx bxs-edit-alt mr-1'></i>Sửa</router-link>
                                        <button
                                            @click="deleteQuestion(question.id, 'draft')"
                                            class="w-full text-left py-2 px-2 hover:bg-blue-100"><i
                                                class='bx bxs-trash mr-1'></i>Xóa</button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="draftQuestion && draftQuestion != null && draftQuestion.length > itemPerPageQuestion">
                            <v-pagination v-model="pageQuestion"
                                :pages="totalPagesQuestion" :range-size="1"
                                active-color="#0074FF" class="my-3 pl-0"
                                @update:modelValue="onPageChangedQuestion" />
                        </div>
                    </div>
                    <div v-else>
                        <h4 class="font-semibold text-center text-gray-500 mt-3">
                            Không có gì ở đây cả</h4>
                    </div>
                </div>

                <!-- VI PHẠM  -->
                <div class="pt-2 rounded-lg dark:bg-gray-800 hidden"
                    id="block-question" role="tabpanel"
                    aria-labelledby="block-question-tab">
                    <h2 class="text-gray-800 font-medium text-lg border-b pb-2">Vi
                        phạm</h2>
                    <div v-if="offendingQuestion && offendingQuestion.length > 0"
                        class="mt-3">
                        <div class="mb-2">
                            <form
                                @submit.prevent="searchQuestion(dataSearch.blockQuestion, 'offending')">
                                <label for="default-search"
                                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
                                <div class="relative">
                                    <div
                                        class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="search" id="default-search"
                                        class="block px-5 py-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Nhập tiêu đề bài viết"
                                        v-model="dataSearch.blockQuestion.title">
                                    <button type="submit"
                                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tìm
                                        kiếm</button>
                                </div>
                            </form>
                        </div>
                        <div class="py-2 border-b"
                            v-for="question in displayOffendingQuestion" :key="question.id">
                            <div class="flex items-center ">
                                <router-link
                                    :to="{ name: 'QuestionDetail', params: { id: question.id } }"
                                    class="text-gray-800 text-lg flex items-center">
                                    <i
                                        class='bx bx-block text-red-700 text-lg pr-2'></i>
                                    {{ question.title }}
                                </router-link>
                                <div class="ml-2">
                                    <router-link
                                        :to="{ name: 'TagDetail', params: { id: tag.pivot.tag_id } }"
                                        class="inline-flex items-center bg-blue-100 text-blue-800 text-xs md:text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 "
                                        v-for="tag in question.tags" :key="tag.slug">{{
                                            tag.name }}</router-link>
                                </div>
                            </div>
                            <div
                                class="mt-1.5 text-sm text-gray-500 flex items-center">
                                <span>Vi phạm lúc: {{ formatDateTime(new
                                    Date(question.created_at)) }}</span>
                                <div class="relative">
                                    <button class="text-lg ml-1 flex items-center"
                                        @click="showDropDownQuestion($event, question.id)">
                                        <i class='bx bx-chevron-down'></i>
                                    </button>
                                    <ul :id="`drop-down-question-${question.id}`"
                                        class="bg-white shadow-[0_3px_10px_rgb(0,0,0,0.2)] rounded w-28 absolute hidden z-20 drop-down-container">
                                        <button
                                            class="w-full text-left py-2 px-2 hover:bg-blue-100"><i
                                                class='bx bxs-wrench mr-1'></i>Khiếu
                                            nại</button>
                                        <button
                                            @click="deleteQuestion(question.id, 'offending')"
                                            class="w-full text-left py-2 px-2 hover:bg-blue-100"><i
                                                class='bx bxs-trash mr-1'></i>Xóa</button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="offendingQuestion && offendingQuestion != null && offendingQuestion.length > itemPerPageOffendingQuestion">
                            <v-pagination v-model="pageOffendingQuestion"
                                :pages="totalPagesOffendingQuestion" :range-size="1"
                                active-color="#0074FF" class="my-3 pl-0"
                                @update:modelValue="onPageChangedOffendingQuestion" />
                        </div>
                    </div>
                    <div v-else>
                        <h4 class="font-semibold text-center text-gray-500 mt-3">
                            Không có gì ở đây cả</h4>
                    </div>
                </div>

                <!-- CÔNG KHAI -->
                <div class="pt-2 rounded-lg dark:bg-gray-800 hidden"
                    id="public-question" role="tabpanel"
                    aria-labelledby="public-question-tab">
                    <h2 class="text-gray-800 font-medium text-lg border-b pb-2">Bản
                        nháp</h2>
                    <div v-if="publicQuestion && publicQuestion.length > 0"
                        class="mt-3">
                        <div class="mb-2">

                            <form
                                @submit.prevent="searchQuestion(dataSearch.question, 'public')">
                                <label for="default-search"
                                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
                                <div class="relative">
                                    <div
                                        class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="search" id="default-search"
                                        class="block px-5 py-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Nhập tiêu đề câu hỏi"
                                        v-model="dataSearch.publicQuestion.title">
                                    <button type="submit"
                                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tìm
                                        kiếm</button>
                                </div>
                            </form>
                        </div>
                        <div class="py-2 border-b"
                            v-for="question in displayPublicQuestion"
                            :key="question.id">
                            <div class="flex items-center ">
                                <router-link
                                    :to="{ name: 'QuestionDetail', params: { id: question.id } }"
                                    class="text-gray-800 text-lg flex items-center">
                                    <i
                                        class='bx bxs-lock-alt text-emerald-500 text-lg pr-2'></i>
                                    {{ question.title }}
                                </router-link>
                                <div class="ml-2">
                                    <router-link
                                        :to="{ name: 'TagDetail', params: { id: tag.pivot.tag_id } }"
                                        class="inline-flex items-center bg-blue-100 text-blue-800 text-xs md:text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 "
                                        v-for="tag in question.tags"
                                        :key="tag.slug">{{
                                            tag.name }}</router-link>
                                </div>
                            </div>
                            <div
                                class="mt-1.5 text-sm text-gray-500 flex items-center">
                                <span>Đăng lúc: {{ formatDateTime(new
                                    Date(question.created_at)) }}</span>
                                <div class="relative">
                                    <button class="text-lg ml-1 flex items-center"
                                        @click="showDropDownQuestion($event, question.id)">
                                        <i class='bx bx-chevron-down'></i>
                                    </button>
                                    <ul :id="`drop-down-question-${question.id}`"
                                        class="bg-white shadow-[0_3px_10px_rgb(0,0,0,0.2)] rounded w-28 absolute hidden z-20 drop-down-post-container">
                                        <router-link
                                            :to="{ name: 'QuestionEdit', params: { id: question.id, auth: authId } }"
                                            class="py-2 block px-2 hover:bg-blue-100"><i
                                                class='bx bxs-edit-alt mr-1'></i>Sửa</router-link>
                                        <button
                                            @click="deleteQuestion(question.id, 'public')"
                                            class="w-full text-left py-2 px-2 hover:bg-blue-100"><i
                                                class='bx bxs-trash mr-1'></i>Xóa</button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="publicQuestion && publicQuestion != null && publicQuestion.length > itemPerPagePublicQuestion">
                            <v-pagination v-model="pagePuclicQuestion"
                                :pages="totalPagesPublicQuestion" :range-size="1"
                                active-color="#0074FF" class="my-3 pl-0"
                                @update:modelValue="onPageChangedPublicQuestion" />
                        </div>
                    </div>
                    <div v-else>
                        <h4 class="font-semibold text-center text-gray-500 mt-3">
                            Không có gì ở đây cả</h4>
                    </div>
                </div>
                <!--! *********************************************************** -->
            </div>
        </div>
    </div>
</template>
<script>
import { initFlowbite } from 'flowbite'
import { formatDateTimeFB } from '@/assets/js/app.js'
import axios from 'axios'
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import "@/assets/admin/css/pagination-styles.css";
import { useAuthStore } from '@/stores/auth'
import { pageLoading, pageLoaded } from '@/assets/js/app'
export default {
    components: {
        VPagination
    },
    data() {
        return {
            draftPost: [], publicPost: [], offendingPost: [],
            draftQuestion: [], publicQuestion: [], offendingQuestion: [],
            itemPerPagePost: 5, itemPerPagePublicPost: 5, itemPerPageOffendingPost: 5,
            itemPerPageQuestion: 5, itemPerPagePublicQuestion: 5, itemPerPageOffendingQuestion: 5,
            currentPagePost: 1, currentPublicPagePost: 1, currentOffendingPagePost: 1,
            currentPageQuestion: 1, currentPublicPageQuestion: 1, currentOffendingPageQuestion: 1,
            pagePost: 1, pagePublicPost: 1, pageOffendingPost: 1,
            pageQuestion: 1, pagePuclicQuestion: 1, pageOffendingQuestion: 1,
            dataSearch: {
                post: {
                    'title': '',
                },
                publicPost: {
                    'title': '',
                },
                blockPost: {
                    'title': '',
                },
                question: {
                    'title': ''
                },
                publicQuestion: {
                    'title': ''
                },
                blockQuestion: {
                    'title': ''
                }
            },
            authStore: useAuthStore(),
            activeBtn: 1,
            authId: ''
        }
    },
    computed: {
        displayDraftPost() {
            if (this.draftPost && this.draftPost != null) {
                var startIndex = (this.currentPagePost - 1) * this.itemPerPagePost
                var endIndex = startIndex + this.itemPerPagePost
                if (endIndex > this.draftPost.length) {
                    endIndex = this.draftPost.length
                }
                return this.draftPost.slice(startIndex, endIndex)
            }
        },
        displayPublicPost() {
            if (this.publicPost && this.publicPost != null) {
                var startIndex = (this.currentPublicPagePost - 1) * this.itemPerPagePublicPost
                var endIndex = startIndex + this.itemPerPagePublicPost
                if (endIndex > this.publicPost.length) {
                    endIndex = this.publicPost.length
                }
                return this.publicPost.slice(startIndex, endIndex)
            }
        },
        displayOffendingPost() {
            if (this.offendingPost && this.offendingPost != null) {
                var startIndex = (this.currentOffendingPagePost - 1) * this.itemPerPageOffendingPost
                var endIndex = startIndex + this.itemPerPageOffendingPost
                if (endIndex > this.offendingPost.length) {
                    endIndex = this.offendingPost.length
                }
                return this.offendingPost.slice(startIndex, endIndex)
            }
        },
        displayOffendingQuestion() {
            if (this.offendingQuestion && this.offendingQuestion != null) {
                var startIndex = (this.currentOffendingPageQuestion - 1) * this.itemPerPageOffendingQuestion
                var endIndex = startIndex + this.itemPerPageOffendingQuestion
                if (endIndex > this.offendingQuestion.length) {
                    endIndex = this.offendingQuestion.length
                }
                return this.offendingQuestion.slice(startIndex, endIndex)
            }
        },
        displayDraftQuestion() {
            if (this.draftQuestion && this.draftQuestion != null) {
                var startIndex = (this.currentPageQuestion - 1) * this.itemPerPageQuestion
                var endIndex = startIndex + this.itemPerPageQuestion
                if (endIndex > this.draftQuestion.length) {
                    endIndex = this.draftQuestion.length
                }
                return this.draftQuestion.slice(startIndex, endIndex)
            }
        },
        displayPublicQuestion() {
            if (this.publicQuestion && this.publicQuestion != null) {
                var startIndex = (this.currentPublicPageQuestion - 1) * this.itemPerPagePublicQuestion
                var endIndex = startIndex + this.itemPerPagePublicQuestion
                if (endIndex > this.publicQuestion.length) {
                    endIndex = this.publicQuestion.length
                }
                return this.publicQuestion.slice(startIndex, endIndex)
            }
        },
        totalPagesQuestion() {
            if (this.draftQuestion && this.draftQuestion != null) {
                return Math.ceil(this.draftQuestion.length / this.itemPerPageQuestion)
            }
        },
        totalPagesOffendingPost() {
            if (this.offendingPost && this.offendingPost != null) {
                return Math.ceil(this.offendingPost.length / this.itemPerPageOffendingPost)
            }
        },
        totalPagesOffendingQuestion() {
            if (this.offendingQuestion && this.offendingQuestion != null) {
                return Math.ceil(this.offendingQuestion.length / this.itemPerPageOffendingQuestion)
            }
        },
        totalPagesPublicQuestion() {
            if (this.publicQuestion && this.publicQuestion != null) {
                return Math.ceil(this.publicQuestion.length / this.itemPerPagePublicQuestion)
            }
        },
        totalPagesPublicPost() {
            if (this.publicPost && this.publicPost != null) {
                return Math.ceil(this.publicPost.length / this.itemPerPagePublicPost)
            }
        },
        totalPagesPost() {
            if (this.draftPost && this.draftPost != null) {
                return Math.ceil(this.draftPost.length / this.itemPerPagePost)
            }
        },
    },
    methods: {
        onPageChanged(page) {
            return this.currentPagePost = page
        },
        onPageChangedOffendingPost(page) {
            return this.currentOffendingPagePost = page
        },
        onPageChangedPublicPost(page) {
            return this.currentPublicPagePost = page
        },
        onPageChangedQuestion(page) {
            return this.currentPageQuestion = page
        },
        onPageChangedOffendingQuestion(page) {
            return this.currentOffendingPageQuestion = page
        },
        onPageChangedPublicQuestion(page) {
            return this.currentPublicPageQuestion = page
        },
        fetchData() {
            axios.get(`api/posts/draft/${this.authId}`)
                .then(res => {
                    // console.log(res.data);
                    this.draftPost = res.data.data
                })
                .catch(err => {
                    console.log(err);
                })
            axios.get(`api/posts/offending/${this.authId}`)
                .then(res => {
                    this.offendingPost = res.data.data
                    // console.log(this.offendingPost);
                })
                .catch(err => {
                    console.log(err);
                })
            axios.get(`api/posts/list-post-user/${this.authId}`)
                .then(res => {
                    // console.log(res.data);
                    this.publicPost = res.data.posts
                })
                .catch(err => {
                    console.log(err);
                })
            axios.get(`api/questions/draft/${this.authId}`)
                .then(res => {
                    // console.log(res.data);
                    this.draftQuestion = res.data.data
                })
                .catch(err => {
                    console.log(err);
                })
            axios.get(`api/questions/offending/${this.authId}`)
                .then(res => {
                    this.offendingQuestion = res.data.data
                    // console.log(this.offendingQuestion);
                })
                .catch(err => {
                    console.log(err);
                })
            axios.get(`api/questions/list-question-user/${this.authId}`)
                .then(res => {
                    // console.log(res.data);
                    this.publicQuestion = res.data.questions
                })
                .catch(err => {
                    console.log(err);
                })
        },
        formatDateTime(date) {
            return formatDateTimeFB(date)
        },
        showDropDownDraft(event, id) {
            event.stopPropagation();
            if ($(`#drop-down-draft-${id}`).first().is(":hidden")) {
                $(`#drop-down-draft-${id}`).slideDown(300);
            } else {
                $(`#drop-down-draft-${id}`).slideUp(300);
            }
        },
        showDropDownQuestion(event, id) {
            event.stopPropagation();
            if ($(`#drop-down-question-${id}`).first().is(":hidden")) {
                $(`#drop-down-question-${id}`).slideDown(300);
            } else {
                $(`#drop-down-question-${id}`).slideUp(300);
            }
        },
        deletePost(id, type) {
            Swal.fire({
                title: "",
                text: `Bạn có chắc muốn xóa bài viết này?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy",
            }).then(res => {
                if (res.isConfirmed) {
                    axios.delete(`api/posts/${id}`)
                        .then(res => {
                            if (type == 'draft') {
                                this.draftPost = this.draftPost.filter((post) => post.id !== id);
                                if (this.displayDraftPost.length <= 1) {
                                    this.currentPagePost = this.totalPagesPost
                                    this.pagePost = this.totalPagesPost
                                }
                            }
                            if (type == 'offending') {
                                this.offendingPost = this.offendingPost.filter((post) => post.id !== id);
                                if (this.displayOffendingPost.length <= 1) {
                                    this.currentOffendingPagePost = this.totalPagesOffendingPost
                                    this.pageOffendingPost = this.totalPagesOffendingPost
                                }
                            }
                            if (type == 'public') {
                                this.publicPost = this.publicPost.filter((post) => post.id !== id);
                                if (this.displayPublicPost.length <= 1) {
                                    this.currentPublicPagePost = this.totalPagesPublicPost
                                    this.pagePublicPost = this.totalPagesPublicPost
                                }
                            }
                        })
                        .catch(err => {
                            console.log(err);
                        })
                }
            })
        },
        deleteQuestion(id, type) {
            Swal.fire({
                title: "",
                text: `Bạn có chắc muốn xóa câu hỏi này?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy",
            }).then(res => {
                if (res.isConfirmed) {
                    axios.delete(`api/questions/${id}`)
                        .then(res => {
                            if (type == 'draft') {
                                this.draftQuestion = this.draftQuestion.filter((question) => question.id !== id);
                                if (this.displayDraftQuestion.length <= 1) {
                                    this.currentPageQuestion = this.totalPagesQuestion
                                    this.pageQuestion = this.totalPagesQuestion
                                }
                            }
                            if (type == 'offending') {
                                this.offendingQuestion = this.offendingQuestion.filter((question) => question.id !== id);
                                if (this.displayOffendingQuestion.length <= 1) {
                                    this.currentOffendingPageQuestion = this.totalPagesOffendingQuestion
                                    this.pageOffendingQuestion = this.totalPagesOffendingQuestion
                                }
                            }
                            if (type == 'public') {
                                this.publicQuestion = this.publicQuestion.filter((question) => question.id !== id);
                                if (this.displayPublicQuestion.length <= 1) {
                                    this.currentPublicPageQuestion = this.totalPagesPublicQuestion
                                    this.pagePuclicQuestion = this.totalPagesPublicQuestion
                                }
                            }
                        })
                        .catch(err => {
                            console.log(err);
                        })
                }
            })
        },
        searchPost(data, type) {
            if (type == 'draft') {
                axios.get(`api/posts/search/${this.authId}`, {
                    params: {
                        title: data.title,
                        type: 'draft'
                    }
                })
                    .then(res => {
                        this.draftPost = res.data.data
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
            if (type == 'offending') {
                axios.get(`api/posts/search/${this.authId}`, {
                    params: {
                        title: data.title,
                        type: 'offending'
                    }
                })
                    .then(res => {
                        this.offendingPost = res.data.data
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
            if (type == 'public') {
                axios.get(`api/posts/search/${this.authId}`, {
                    params: {
                        title: data.title,
                        type: 'public'
                    }
                })
                    .then(res => {
                        this.publicPost = res.data.data
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        },
        searchQuestion(data, type) {
            if (type == 'draft') {
                axios.get(`api/questions/search/draft/${this.authId}`, {
                    params: {
                        title: data.title,
                        type: 'draft'
                    }
                })
                    .then(res => {
                        this.draftQuestion = res.data.data
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
            if (type == 'offending') {
                axios.get(`api/questions/search/draft/${this.authId}`, {
                    params: {
                        title: data.title,
                        type: 'offending'
                    }
                })
                    .then(res => {
                        this.offendingQuestion = res.data.data
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
            if (type == 'public') {
                axios.get(`api/questions/search/draft/${this.authId}`, {
                    params: {
                        title: data.title,
                        type: 'public'
                    }
                })
                    .then(res => {
                        this.publicQuestion = res.data.data
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        },
        handleClickActiveBtn(tabIndex) {
            this.activeBtn = tabIndex
        }
    },
    async mounted() {
        pageLoading()
        initFlowbite()
        await this.authStore.getToken()
        await this.authStore.getUser()
        this.authId = this.authStore.getInfoUser.id
        this.fetchData()
        $(document).on('click', function (event) {
            if (!$(event.target).closest('.showDropDownDraft').length) {
                $(`.drop-down-container`).slideUp(300);
            }
            if (!$(event.target).closest('.showDropDownQuestion').length) {
                $(`.drop-down-post-container`).slideUp(300);
            }
        });
        pageLoaded()
    }
}
</script>
<style scoped></style>