<template>
    <div class="wrapper container py-5 px-5">
        <div class="flex items-center justify-between">
            <h4 class="text-lg font-bold">Thông báo</h4>
            <div class="relative">
                <button class="text-gray-700 flex items-center" style="border-radius: 3px;" @click="showOptionNotification($event)">
                    <i class='bx bx-dots-horizontal-rounded text-2xl' ></i>
                </button>
                <div id="option-notification" class="hidden absolute z-20 bg-white rounded-md shadow-lg overflow-hidden" style="width: 20rem; left:-18.5rem">
                    <ul>
                        <button class="cursor-pointer px-2 py-2 text-md flex items-center" @click="readAllNotice(authStore.getInfoUser.id)">
                            <i class='bx bx-check-double pr-1 text-lg'></i> Đánh dấu đọc tất cả thông báo
                        </button>
                    </ul>
                </div>
            </div>
        </div>
        <router-link
            :to="{ name: 'PostsDetail', params: { id: notification.route.params.id } }"
            v-for="(notification, index) in displayedNotifications" :key="notification.id"
            @click="readNotice(notification.id, notification.post_id, index)"
            class=" flex px-4 py-3 border-b hover:text-inherit -mx-2 hover:bg-gray-100"
            :class="[notification.read ? '' : 'bg-gray-100 ']">
            <div class="flex">
                <img class="h-8 w-8 rounded-full object-cover mx-1"
                    :src="notification.sender.avatar" alt="avatar">
                <div>
                    <p class="text-gray-600 text-sm mx-2">
                        <span v-html="notification.content"></span>
                    </p>
                    <p class="mx-2 text-gray-400 text-sm">{{ formatDateTimeFB(new Date(notification.created_at)) }}</p>
                </div>
            </div>
        </router-link>
        <v-pagination v-model="page" :pages="totalPageNotication" :range-size="1"
            active-color="#0074FF" class="my-3"
            @update:modelValue="onPageChanged" />
    </div>
</template>
<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import Pusher from "pusher-js";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import {pageLoading, pageLoaded,formatDateTimeFB} from '@/assets/js/app.js'
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import "@/assets/admin/css/pagination-styles.css";
const authStore = useAuthStore();

const data = () => ({
    pusher: null,
    channel: null,
});
const notifications = ref([]);
const page = ref(1), currentPage = ref(1), itemPerPage = ref(10)
const isAdmin = computed(() => {
    return authStore.getAuthRoles;
});
const infoAuth = computed(() => {
    return authStore.getInfoUser;
});

const displayedNotifications = computed(() => {
    if(notifications.value != null) {
        var startIndex = (currentPage.value - 1) * itemPerPage.value;
        var endIndex = startIndex + itemPerPage.value;
        if (endIndex > notifications.value.length) {
            endIndex = notifications.value.length
        }
        return notifications.value.slice(startIndex, endIndex);
    }
})
const totalPageNotication = computed(() => {
    if(notifications.value != null) {
        return Math.ceil(notifications.value.length / itemPerPage.value);
    }
})
const onPageChanged = (page) => {
    return currentPage.value = page
}
const showOptionNotification = (event) => {
    event.stopPropagation();
    if ($('#option-notification').first().is(":hidden")) {
        $('#option-notification').slideDown(300);
    }else {
        $('#option-notification').slideUp(300);
    }
}
const readNotice = async (id_notice, id_, index) => {
    await axios.put(`api/notifications/read-notice/${id_notice}`)
    .then(res => {
        notifications.value[index].read = true
        // console.log(res)
    })
    .catch(err => {
        console.log(err)
    })
    $('#option-notification').slideUp(300);
}
const readAllNotice = async (user_id) => {
    await axios.put(`api/notifications/read-all-notice/${user_id}`)
    .then(res => {
        notifications.value.forEach(function(item) {
            item.read = true
        })
        // console.log(res)
    })
    .catch(err => {
        console.log(err)
    })
    $('#option-notification').slideUp(300);
}
const fetchData = () => {
    axios
        .post('/api/notifications/all-my-notice')
        .then((response) => {
            notifications.value = response.data.data;
            // notifications.value.reverse();
            notifications.value.map(function (item) {
                if (item.sender.avatar.indexOf('http://localhost:8000/images/') == -1) {
                    return item.sender.avatar = 'http://localhost:8000/images/' + item.sender.avatar
                }
            })
            // console.log('Day la danh sach thong bao', response.data.data)
        })
        .catch((error) => {
            console.log(error);
        });
};

onMounted(async () => {
    pageLoading()
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.showOptionNotification').length) {
            $('#option-notification').slideUp(300);
        }
    });
    await authStore.getToken();
    await authStore.getUser();

    if (infoAuth.value) {
        const userId = infoAuth.value.id;

        fetchData()

        data.pusher = new Pusher("100f9f72ec40accb9c52", {
            cluster: "ap1",
            encrypted: true,
        });

        data.channel = data.pusher.subscribe("chanel-notification");

        data.channel.bind('general-announcement', (notification) => {
            notifications.value.unshift(notification);
        });

        data.channel.bind(`event-notification-${userId}`, (notification) => {
            notifications.value.unshift(notification);
            notifications.value.map(function (item) {
                if (item.sender.avatar.indexOf('http://localhost:8000/images/') == -1) {
                    return item.sender.avatar = 'http://localhost:8000/images/' + item.sender.avatar
                }
            })
            // notifications.value.reverse();
            console.log('cc', notifications.value);
        });
    }
    pageLoaded()
});

onBeforeUnmount(() => {
    data.channel.unbind();
    data.pusher.disconnect();
});
</script>