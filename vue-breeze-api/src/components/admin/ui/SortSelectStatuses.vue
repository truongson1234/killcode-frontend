<template>
    <div class="w-full h-screen bg-gray-900 flex justify-center items-center">
        <div class="w-full flex justify-center">
            <div
                @click="openSort = false"
                class="relative"
                x-data="{ openSort: true, sortType: 'Sort by' }"
            >
                <button
                    @click="openSort = !openSort"
                    class="flex text-white bg-gray-200 items-center justify-start w-40 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg"
                >
                    <span x-text="sortType"></span>
                    <svg
                        :class="{
                            'rotate-180': openSort,
                            'rotate-0': !openSort,
                        }"
                        class="w-4 h-4 transition-transform duration-200 transform"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            clip-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            fill-rule="evenodd"
                        ></path>
                    </svg>
                </button>
                <div
                    x-show="openSort"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute z-50 w-full origin-top-right"
                >
                    <div
                        class="px-2 pt-2 pb-2 bg-white rounded-md shadow-lg dark-mode:bg-gray-700"
                    >
                        <div class="flex flex-col">
                            <a
                                @click="
                                    sortType = 'Most discussed';
                                    openSort = false;
                                "
                                x-show="sortType !== 'Most discussed'"
                                class="flex flex-row items-start rounded-lg bg-transparent p-2 hover:bg-gray-200"
                                href="#"
                            >
                                <div>
                                    <p class="font-semibold">Most discussed</p>
                                </div>
                            </a>
                            <a
                                @click="
                                    sortType = 'Most popular';
                                    openSort = false;
                                "
                                x-show="sortType !== 'Most popular'"
                                class="flex flex-row items-start rounded-lg bg-transparent p-2 hover:bg-gray-200"
                                href="#"
                            >
                                <div>
                                    <p class="font-semibold">Most popular</p>
                                </div>
                            </a>
                            <a
                                @click="
                                    sortType = 'Most upvoted';
                                    openSort = false;
                                "
                                x-show="sortType !== 'Most upvoted'"
                                class="flex flex-row items-start rounded-lg bg-transparent p-2 hover:bg-gray-200"
                                href="#"
                            >
                                <div>
                                    <p class="font-semibold">Most upvoted</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            openSort: true,
            sortType: "Sort by",
        };
    },
};
</script>

<style>
/* No custom styles needed */
</style>
