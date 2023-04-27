<template>
    <div class="reports__item">
        <div class="reports__sender">
            <a class="reports__avartar" href="#">
                <img
                    class="reports__image"
                    src="https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg"
                    alt=""
                />
            </a>
            <div class="reports__milestones">
                <h3 class="reports__name">{{ report.sender.name }}</h3>
                <span class="reports__line">|</span>
                <span class="reports__created">{{ report.created_at }}</span>
            </div>
        </div>
        <p class="reports__content">
            {{ report.reason }}. (<router-link :to="{ name: report.violator.route.post.name, params: { id: report.violator.route.post.params.id } }" class="reports__violators-post">
                Bài viết vi phạm
            </router-link>)
        </p>
        <a class="reports__cover" href="">
            <div class="reports__violators">
                <div class="reports__avartar" href="#">
                    <img
                        class="reports__image"
                        src="https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg"
                        alt=""
                    />
                </div>
                <h3 class="reports__name">{{ report.violator.name }}</h3>
            </div>
        </a>
    </div>
</template>

<script setup>
const props = defineProps({
    report: Object,
});

</script>

<style scoped>
.reports__item {
    padding: 10px;
    margin-bottom: 20px;
    background-color: #fff;
    border-radius: 10px;
}
.reports__item .reports__avartar {
    display: block;
    width: 35px;
    height: 35px;
    margin-right: 10px;
    overflow: hidden;
    border-radius: 50%;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px,
        rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
}
.reports__item .reports__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.reports__item .reports__name {
    font-size: 18px !important;
    font-weight: 500 !important;
    margin: 0 !important;
}
.reports__item .reports__line {
    margin: 0 8px;
}
.reports__item .reports__created {
    /* color: #fff; */
}
.reports__item .reports__sender,
.reports__item .reports__violators {
    height: 50px;
    display: flex;
    align-items: center;
}
.reports__item .reports__cover {
    display: inline-block;
}
.reports__item .reports__sender {
    padding: 0 10px;
}
.reports__item .reports__sender .reports__name {
}
.reports__item .reports__violators {
    padding: 0 10px;
    background-color: #eb4d4b;
    border-radius: 10px;
}
.reports__item .reports__violators .reports__name {
    color: #fff !important;
}
.reports__item .reports__milestones {
    display: flex;
    align-items: center;
}
.reports__item .reports__violators-post {
    color: #eb4d4b !important;
    text-decoration: underline !important;
}
.reports__item .reports__content {
    color: #000;
}
</style>
