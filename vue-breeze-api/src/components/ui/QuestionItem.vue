<template>
  <div class="p-3 pt-0 pb-4">
    <div class="box-question relative">
      <div class="absolute right-7 cursor-pointer"
        v-if="data.user_id == idAuthor">
        <button @click="showToolQuestion($event, data.id)"><i
            class='bx bx-dots-horizontal-rounded text-gray-400'></i></button>
        <div
          class="tool-question-container hidden bg-white absolute right-0 shadow-lg"
          :class="`tool-question${data.id}`" style="min-width:15rem">
          <router-link :to="{ name: 'QuestionEdit', params: { id: data.id } }"
            class="px-2 py-2 flex items-center hover:text-current hover:bg-gray-100 w-full">
            <i class='bx bx-edit text-gray-400 pr-1'></i> Chỉnh sửa bài viết
          </router-link>
          <button @click="deleteQuestion(data.id)"
            class="px-2 py-2 flex items-center hover:text-current hover:bg-gray-100 w-full"><i
              class='bx bxs-trash  text-gray-400 pr-1'></i>Xóa bài viết</button>
        </div>
      </div>
      <div class="box-question-header flex items-center">
        <div class="userimage"><img :src="data.author.avatar" alt="" /></div>
        <div class="flex flex-col">
          <span class="username leading-5">
            <router-link :to="{ name: 'User', params: { id: data.author.id } }">{{
              data.author.name }}</router-link>
          </span>
          <span class="time-question leading-3 text-slate-400" v-if="statusDate">
            đăng lúc
            {{ formatDateTime(data.created_at) }}
          </span>
        </div>
      </div>
      <div class="box-question-content">
        <p>
          <router-link :to="{ name: 'QuestionDetail', params: { id: data.id } }"
            class="">
            {{ data.title }}
          </router-link>
        </p>
      </div>
      <div class="flex items-center justify-between mt-2">
        <div class="box-tags">
          <a href="#"
            class="inline-flex items-center bg-blue-100 text-blue-800 text-xs md:text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 "
            v-for="(data, index) in data.tags" :key="index">
            {{ data.name }}
          </a>
        </div>
        <div class="box-question-engagement">
          <div class="engagements flex items-center">
            <span class="engagements-text flex items-center">{{ data.likes_count ? data.likes_count : 0 }}
              <i class='bx bx-like fa-fw fa-lg m-r-3'></i></span>
            <span class="engagements-text flex items-center">{{ data.views_count ? data.views_count : 0 }} <i
                class='bx bx-show fa-fw fa-lg m-r-3'></i></span>
            <span class="engagements-text flex items-center">{{ data.comments_count ? data.comments_count : 0 }} <i
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
const authStore = useAuthStore();
const props = defineProps({
  data: Object,
  statusDate: {
    type: Boolean,
    default: true
  },
  deleteQuestion: Function
});

const data = props.data;
const statusDate = props.statusDate;
const idAuthor = computed(() => {
  if (authStore.getInfoUser != null) {
    return authStore.getInfoUser.id
  }
  return ''
})
const showToolQuestion = (event, index) => {
  event.stopPropagation();
  if ($(`.box-question .tool-question${index}`).first().is(':hidden')) {
    $(`.box-question .tool-question${index}`).slideDown(300)
  } else {
    $(`.box-question .tool-question${index}`).slideUp(300)
  }
}
onMounted(() => {
  $(document).on('click', function (event) {
    if (!$(event.target).closest('.showToolQuestion').length) {
      $(`.box-question .tool-question-container `).slideUp(300);
    }
  });
})
</script>

<style scoped>
.box-question {
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
  position: relative;
  padding: 20px 25px;
  border-radius: 6px;
}

.box-question .box-question-header .time-question {
  font-size: 12px
}

.box-question-header {
  padding-bottom: 10px;
  border-bottom: 1px solid #e2e7eb;
  line-height: 30px
}

.box-question-header .userimage {
  float: left;
  width: 34px;
  height: 34px;
  border-radius: 40px;
  overflow: hidden;
  margin: -2px 10px -2px 0
}

.box-question-header .username {
  font-size: 16px;
  font-weight: 600;
  margin-right: 5px;
}

.box-question-header .username,
.box-question-header .username a {
  color: #2d353c
}

.box-question-content {
  color: var(--color-dark-mode);
  text-align: justify;
  padding-top: 5px;
}

.box-question-content p {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.box-question-content:after,
.box-question-content:before {
  content: '';
  display: table;
  clear: both
}

.box-question-engagement {
  color: #6d767f;
  font-weight: 600;
  font-size: 12px
}

.box-question-engagement .engagements {
  text-align: right;
}

.box-question-engagement .stats-total {
  display: inline-block;
  line-height: 20px
}

.box-question-engagement .stats-icon {
  float: left;
  margin-right: 5px;
  font-size: 9px
}

.box-question-engagement .stats-icon+.stats-icon {
  margin-left: -2px
}

.box-question-engagement .engagements-text {
  line-height: 20px
}

.box-question-engagement .engagements-text+.engagements-text {
  margin-left: 15px
}</style>
