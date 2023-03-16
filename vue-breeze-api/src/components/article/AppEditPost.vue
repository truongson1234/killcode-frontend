<template>
    <div class="">
        <div class="flex justify-between mb-6">
            <h1 class="text-xl font-bold">Sửa bài viết</h1>
            <button
                @click="handleUpdated(payload)"
                type="button"
                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
            >
                Lưu lại
            </button>
        </div>
        <div class="mb-6">
            <label
                for="base-input"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Tiêu đề:</label
            >
            <input
                v-model="payload.title"
                type="text"
                id="base-input"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            />
        </div>
        <ckeditor
            :editor="editor"
            v-model="payload.body"
            :config="editorConfig"
        />
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
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

const payload = ref({});

// method
const fetchData = (id) => {
    try {
        return axios.get(`/api/posts/${id}`);
    } catch (error) {
        console.log(error);
    }
}

onMounted(async () => {
    const response = await fetchData(postId);
    payload.value = response.data.data
});

const handleUpdated = (payload) => {
    try {
        axios.put(`/api/posts/${postId}`, payload);
        Swal.fire("Lưu thành công", "chúc mừng <3", "success");
    } catch (error) {
        console.log(error);
    }
};
</script>
