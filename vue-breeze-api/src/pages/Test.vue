<template>
  <div class="notification-list">
    <div v-for="notification in notifications" :key="notification.id" class="notification">
      {{ notification.message }}
    </div>
  </div>
</template>

<script>
import Pusher from 'pusher-js';

export default {
  name: 'NotificationList',
  data() {
    return {
      notifications: []
    };
  },
  props: {
    userId: {
      type: String,
      required: true
    }
  },
  created() {
    const pusher = new Pusher(process.env.VUE_APP_PUSHER_KEY, {
      cluster: process.env.VUE_APP_PUSHER_CLUSTER,
      authEndpoint: '/broadcasting/auth',
      auth: {
        headers: {
          'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content
        }
      }
    });

    const channel = pusher.subscribe(`private-notification-channel.${this.userId}`);
    channel.bind('App\\Events\\NewNotification', data => {
      this.notifications.push(data.notification);
    });
  }
};
</script>

<style scoped>
.notification {
  padding: 10px;
  border: 1px solid #ccc;
  margin-bottom: 10px;
}
</style>
