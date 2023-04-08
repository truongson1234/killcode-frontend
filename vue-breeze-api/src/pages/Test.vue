<template>
    <div>
        <h1>Notifications</h1>
        <ul>
            <li v-for="(notification, index) in notifications" :key="index">
                <h1>{{ notification.title }}</h1>
                <span>{{ notification.content }}</span>
            </li>
        </ul>
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
</script>