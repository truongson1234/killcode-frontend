<template>
    <div>
        <div class="flex justify-center h-screen">
            <div class="relative my-32">
                <button @click="showNotifications()"
                    class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
                    <svg class="h-5 w-5 text-gray-800"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>
                </button>

                <!-- <div x-show="dropdownOpen" @click="dropdownOpen = false"
                    class="fixed inset-0 h-full w-full z-10"></div> -->

                <div 
                    class="list-notification absolute right-0 mt-2 bg-white rounded-md shadow-lg overflow-hidden z-20 hidden"
                    style="width:20rem;">
                    <div class="py-2">
                        <a href="#"
                            class="flex items-center px-4 py-3 border-b hover:bg-gray-100 -mx-2">
                            <img class="h-8 w-8 rounded-full object-cover mx-1"
                                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80"
                                alt="avatar">
                            <p class="text-gray-600 text-sm mx-2">
                                <span class="font-bold" href="#">Sara Salah</span>
                                replied on the <span class="font-bold text-blue-500"
                                    href="#">Upload Image</span> artical . 2m
                            </p>
                        </a>
                        <a href="#"
                            class="flex items-center px-4 py-3 border-b hover:bg-gray-100 -mx-2">
                            <img class="h-8 w-8 rounded-full object-cover mx-1"
                                src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=634&q=80"
                                alt="avatar">
                            <p class="text-gray-600 text-sm mx-2">
                                <span class="font-bold" href="#">Slick Net</span>
                                start following you . 45m
                            </p>
                        </a>
                        <a href="#"
                            class="flex items-center px-4 py-3 border-b hover:bg-gray-100 -mx-2">
                            <img class="h-8 w-8 rounded-full object-cover mx-1"
                                src="https://images.unsplash.com/photo-1450297350677-623de575f31c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80"
                                alt="avatar">
                            <p class="text-gray-600 text-sm mx-2">
                                <span class="font-bold" href="#">Jane Doe</span>
                                Like Your reply on <span
                                    class="font-bold text-blue-500" href="#">Test
                                    with TDD</span> artical . 1h
                            </p>
                        </a>
                        <a href="#"
                            class="flex items-center px-4 py-3 hover:bg-gray-100 -mx-2">
                            <img class="h-8 w-8 rounded-full object-cover mx-1"
                                src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=398&q=80"
                                alt="avatar">
                            <p class="text-gray-600 text-sm mx-2">
                                <span class="font-bold" href="#">Abigail
                                    Bennett</span> start following you . 3h
                            </p>
                        </a>
                    </div>
                    <a href="#"
                        class="block bg-gray-800 text-white text-center font-bold py-2">See
                        all notifications</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref } from "vue";
import Pusher from "pusher-js";
import { useAuthStore } from "@/stores/auth";
const authStore = useAuthStore();

const data = {
    pusher: null,
    channel: null,
};

const notifications = ref([]);

onMounted(async () => {
    await authStore.getToken();
    await authStore.getUser();

    const userId = authStore.getInfoUser.id;

    data.pusher = new Pusher("100f9f72ec40accb9c52", {
        cluster: "ap1",
        encrypted: true,
    });

    data.channel = data.pusher.subscribe("chanel-notification");

    data.channel.bind('general-announcement', (notification) => {
        notifications.value.push(notification);
        console.log(notification);
    });

    if (userId) {
        data.channel.bind(`event-notification-${userId}`, (notification) => {
            notifications.value.push(notification);
            console.log(notification);
        });
    }
});

onBeforeUnmount(() => {
    data.channel.unbind();
    data.pusher.disconnect();
});
const showNotifications = () => {
    if($('.list-notification ').first().is( ":hidden" )) {
        $('.list-notification ').slideDown(300);
    }else {
        $('.list-notification ').slideUp(300);
    }
}
</script>