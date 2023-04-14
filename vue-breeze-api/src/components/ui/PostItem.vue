<template>
  <div class="p-3">
    <div class="box-post relative">
      <div v-if="data.user_id == idAuthor" class="absolute right-7 cursor-pointer" @click="editPost(data.id)">
        <i class='bx bx-edit text-gray-400'></i>
      </div>
      <div class="box-post-header flex items-center">
        <div class="userimage"><img :src="data.author.avatar" alt="" /></div>
        <div class="flex flex-col">
          <span class="username leading-5"><a href="javascript:;">{{
            data.author.name }}</a>
          </span>
          <span class="time-post leading-3 text-slate-400" v-if="statusDate">
            đăng lúc
            {{ formatDateTime(data.created_at) }}
          </span>
        </div>
      </div>
      <div class="box-post-content">
        <p>
          <router-link :to="{ name: 'PostsDetail', params: { id: data.id } }" class="">
            {{ data.title }}
          </router-link>
        </p>
      </div>
      <div class="flex items-center justify-between mt-2">
        <div class="box-tags">
          <a href="#" class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 " v-for="(data, index) in data.tags" :key="index">
            {{ data.name }}
          </a>
        </div>
        <div class="box-post-engagement">
          <div class="engagements flex items-center">
            <span class="engagements-text">{{ data.likes }}
              <i class='bx bx-like fa-fw fa-lg m-r-3'></i></span>
            <span class="engagements-text">{{ data.views }} <i
                class='bx bx-show fa-fw fa-lg m-r-3'></i></span>
            <span class="engagements-text">21 <i
                class="bx bx-comment-detail fa-fw fa-lg m-r-3"></i></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { formatDateTime } from '@/assets/js/app.js'
import { useAuthStore } from "@/stores/auth";
import router from '@/router'
const authStore = useAuthStore();
const props = defineProps({
  data: Object,
  statusDate: {
    type: Boolean,
    default: true
  }
});

const data = props.data;
const statusDate = props.statusDate;
const idAuthor = computed(() => {
  if(authStore.getInfoUser != null) {
    return authStore.getInfoUser.id
  }
  return ''
})
const editPost = (id) => {
  router.push({ name: 'PostsEdit', params: {id: id}})
  .then(() => { router.go() })
}
</script>

<style scoped>
.box-post {
  box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
  position: relative;
  padding: 20px 25px;
  border-radius: 6px;
}

.box-post .box-post-header .time-post {
  font-size: 12px
}

.box-post-header {
  padding-bottom: 10px;
  border-bottom: 1px solid #e2e7eb;
  line-height: 30px
}

.box-post-header .userimage {
  float: left;
  width: 34px;
  height: 34px;
  border-radius: 40px;
  overflow: hidden;
  margin: -2px 10px -2px 0
}

.box-post-header .username {
  font-size: 16px;
  font-weight: 600;
  margin-right: 5px;
}

.box-post-header .username,
.box-post-header .username a {
  color: #2d353c
}

.box-post-content {
  color: var(--color-dark-mode);
  text-align: justify;
  padding-top: 5px;
}
.box-post-content p {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.box-post-content:after,
.box-post-content:before {
  content: '';
  display: table;
  clear: both
}

.box-post-engagement {
  color: #6d767f;
  font-weight: 600;
  font-size: 12px
}

.box-post-engagement .engagements {
  text-align: right;
}

.box-post-engagement .stats-total {
  display: inline-block;
  line-height: 20px
}

.box-post-engagement .stats-icon {
  float: left;
  margin-right: 5px;
  font-size: 9px
}

.box-post-engagement .stats-icon+.stats-icon {
  margin-left: -2px
}

.box-post-engagement .engagements-text {
  line-height: 20px
}

.box-post-engagement .engagements-text+.engagements-text {
  margin-left: 15px
}
</style>
