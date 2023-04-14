<template>
    <div class="">
        <div class="flex justify-between mb-6">
            <button @click="handleUpdated(payload.post)" type="button"
                class=" ml-auto text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                Lưu lại
            </button>
        </div>
        <div class="mb-3">
            <label for="base-input"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tiêu
                đề:</label>
            <input v-model="payload.post.title" type="text" id="base-input"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        </div>
        <div class="flex items-center mb-2">
            <label for="" class="pr-2">Thẻ được gắn:</label>
            <ul v-for="(tag, index) in payload.tags" :key="index">
                <li class="flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ">
                    <p class="text-blue-500">{{ tag.name }}</p>
                    <button class="flex items-center justify-center ml-1 hover:rounded-full hover:bg-gray-400 hover:text-white" @click="removeTag(tag.id)"><i class='bx bx-x'></i></button>
                </li>
            </ul>
        </div>
        <div class="mb-3">
            <SearchTags
            :apiUrl="dataTags.url"
            :placeholder="'Gắn thẻ bài viết của bạn. Tối đa 5 thẻ. Ít nhất 1 thẻ!'"
            @add-item="addTag"
            />
        </div>
        <ckeditor :editor="editor" v-model="payload.post.body"
            :config="editorConfig" />
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import { useRoute } from "vue-router";
import router from '@/router'
import SearchTags from "@/components/ui/SearchTags.vue";
// plugins ckeditor
import ClassicEditor from "@ckeditor/ckeditor5-editor-classic/src/classiceditor";
import EssentialsPlugin from "@ckeditor/ckeditor5-essentials/src/essentials";
import BoldPlugin from "@ckeditor/ckeditor5-basic-styles/src/bold";
import ItalicPlugin from "@ckeditor/ckeditor5-basic-styles/src/italic";
import LinkPlugin from "@ckeditor/ckeditor5-link/src/link";
import ParagraphPlugin from "@ckeditor/ckeditor5-paragraph/src/paragraph";
import CodeBlock from "@ckeditor/ckeditor5-code-block/src/codeblock";

const editor = ClassicEditor;
const editorConfig = {
    plugins: [
        EssentialsPlugin,
        BoldPlugin,
        ItalicPlugin,
        LinkPlugin,
        ParagraphPlugin,
        CodeBlock,
    ],
    toolbar: {
        items: ["bold", "italic", "link", "undo", "redo", "codeBlock"],
    },
};

const route = useRoute();
const postId = route.params.id;
const dataTags = ref({
        url: "/api/tags",
        tags: [],
    })
const payload = ref({
    post: {
        id: '',
        title: '',
        body: '',
        tag_ids: []
    },
    tags: []
    
});
// method
const fetchData = (id) => {
    try {
        return axios.get(`/api/posts/${id}`);
    } catch (error) {
        console.log(error);
    }
}
const addTag = (data) => {
    console.log(data);
    if (payload.value.post.tag_ids.length > 4) {
        // Swal.fire("Qúa nhiều tags rồi!", "Chỉ thêm được tối đa 5 tags.");
    } else if (!payload.value.post.tag_ids.find(i => i == data.id)) {
        payload.value.post.tag_ids.push(data.id);
        payload.value.tags.push(data);
        console.log(payload.value, payload.value);
    }
}
const removeTag = (id) => {
    const index = payload.value.post.tag_ids.indexOf(id);
    if (index !== -1) {
        payload.value.post.tag_ids.splice(index, 1);
        payload.value.tags.splice(index, 1);
    }
}
onMounted(async () => {
    const response = await fetchData(postId);
    payload.value = response.data
    payload.value.post.tag_ids = []
    payload.value.tags.forEach(function(item) {
        payload.value.post.tag_ids.push(item.id)
    })
    console.log(response.data);
});

const handleUpdated = (payload) => {
    try {
        axios.put(`/api/posts/${postId}`, payload)
        .then(res => {
            console.log(res);
            router.push({ name: 'PostsDetail', params: { id: postId }})
            // .then(() => {router.go()})
        })
        .catch(err => {
            console.log(err);
        })
    } catch (error) {
        console.log(error);
    }
};
</script>
