<!-- <template>
    <div>
        <h1>Notifications</h1>
        <ul>
            <li v-for="(notification, index) in notifications" :key="index">
                {{ notification }}
            </li>
        </ul>
    </div>
</template>

<script>
import Pusher from "pusher-js";

export default {
    data() {
        return {
            notifications: [],
            pusher: null,
            channel: null,
        };
    },
    created() {
        this.pusher = new Pusher("498b63a6c28698265c1c", {
            cluster: "ap1",
            encrypted: true,
        });

        this.channel = this.pusher.subscribe(
            "test-chanel"
        );

        this.channel.bind("test-event", (data) => {
            this.notifications.push(data);
        });
    },
    beforeDestroy() {
        this.channel.unbind();
        this.pusher.disconnect();
    },
};
</script> -->
