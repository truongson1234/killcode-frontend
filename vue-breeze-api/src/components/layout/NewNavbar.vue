<template>
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div
                    class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start"
                >
                    <div class="flex-shrink-0">
                        <router-link to="/">
                            <img
                                class="block lg:hidden h-8 w-auto"
                                src="/logo.svg"
                                alt="Logo"
                            />
                            <img
                                class="hidden lg:block h-8 w-auto"
                                src="/logo.svg"
                                alt="Logo"
                            />
                        </router-link>
                    </div>
                    <div class="hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <router-link
                                to="/"
                                class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium"
                                >Trang chủ</router-link
                            >
                            <router-link
                                to="/products"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                >Sản phẩm</router-link
                            >
                            <router-link
                                to="/about"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                >Giới thiệu</router-link
                            >
                        </div>
                    </div>
                </div>
                <div
                    class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"
                >
                    <div class="relative" x-data="{ open: false }">
                        <button
                            @click="open = !open"
                            class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                            aria-expanded="false"
                        >
                            <span class="sr-only">View notifications</span>
                            <svg
                                class="h-6 w-6"
                                x-description="Heroicon name: bell"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"
                                />
                            </svg>
                            <div
                                class="absolute top-0 right-0 bg-red-500 text-white rounded-full px-2 py-1 text-xs"
                                x-show="true"
                            >
                                3
                            </div>
                        </button>
                        <div
                            x-show="open"
                            @click.away="open = false"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu"
                            aria-orientation="vertical"
                            aria-labelledby="user-menu"
                        >
                            <a
                                href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                role="menuitem"
                                >Thông báo 1</a
                            >
                            <a
                                href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                role="menuitem"
                                >Thông báo 2</a
                            >
                            <a
                                href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                role="menuitem"
                                >Thông báo 3</a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
