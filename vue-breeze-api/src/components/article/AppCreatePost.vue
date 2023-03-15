<template>
    <div class="">
        <div class="flex justify-between mb-6">
            <h1 class="text-xl font-bold">Tạo bài viết</h1>
            <button
                @click="handleCreated(payload)"
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
import { useAuthStore } from "@/stores/auth";
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

const auth = useAuthStore();
const payload = ref({
        user_id: null,
        title: "",
        body: "",
        tags: ["tagname1", "tagname2", "tagname3"],
        views: 0,
        likes: 0,
    })

onMounted(async () => {
    await auth.getUser();
    payload.value.user_id = auth.user.id
});

const handleCreated = (payload) => {
    axios.post("/api/posts", payload).then((response) => {
        Swal.fire("Lưu thành công", "chúc mừng <3", "success");
    });
};
</script>
