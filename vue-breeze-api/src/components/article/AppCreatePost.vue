<template>
    <div class="">
        <div class="flex justify-between mb-6">
            <button
                @click="handleCreated(payload)"
                type="button"
                class=" ml-auto text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
            >
                Xuất bản bài viết
            </button>
        </div>
        <div class="mb-3">
            <input
                v-model="payload.title"
                placeholder="Tiêu đề"
                type="text"
                id="base-input"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            />
        </div>

        <ul v-for="(tag, index) in dataTags.tags" :key="index">
            <li class="flex">
                <p class="text-green-500">{{ tag.name }}</p>
                <button class="mx-2" @click="removeTag(tag.id)">x</button>
            </li>
        </ul>
        <div class="mb-3">
            <SearchTags
            :apiUrl="dataTags.url"
            :placeholder="'Gắn thẻ bài viết của bạn. Tối đa 5 thẻ. Ít nhất 1 thẻ!'"
            @add-item="addTag"
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
import SearchTags from "@/components/ui/SearchTags.vue";
import router from '@/router';
// plugins ckeditor
import ClassicEditor from "@ckeditor/ckeditor5-editor-classic/src/classiceditor";
import EssentialsPlugin from "@ckeditor/ckeditor5-essentials/src/essentials";
import BoldPlugin from "@ckeditor/ckeditor5-basic-styles/src/bold";
import ItalicPlugin from "@ckeditor/ckeditor5-basic-styles/src/italic";
import LinkPlugin from "@ckeditor/ckeditor5-link/src/link";
import ParagraphPlugin from "@ckeditor/ckeditor5-paragraph/src/paragraph";
import CodeBlock from "@ckeditor/ckeditor5-code-block/src/codeblock";
<<<<<<< HEAD
import Highlight from '@ckeditor/ckeditor5-highlight/src/highlight';

=======
import List from '@ckeditor/ckeditor5-list/src/list';
import Heading from '@ckeditor/ckeditor5-heading/src/heading';
>>>>>>> d58fe5ba64078811b1bec5b40c37b3b7f4c0dba0
const editor = ClassicEditor;
const editorConfig = {
    plugins: [
        EssentialsPlugin,
        BoldPlugin,
        ItalicPlugin,
        LinkPlugin,
        ParagraphPlugin,
        CodeBlock,
<<<<<<< HEAD
        Highlight
    ],
    toolbar: {
        items: ["bold", "italic", "link", "undo", "redo", "codeBlock", "highlight"],
=======
        List, 
        Heading
    ],
    toolbar: {
        items: ["bold", "italic", "link", "undo", "redo", "codeBlock", "bulletedList", "numberedList", "heading"],
>>>>>>> d58fe5ba64078811b1bec5b40c37b3b7f4c0dba0
    },
};

const dataTags = ref({
        url: "/api/tags",
        tag_ids: [],
    })

const payload = ref({
        title: "",
        body: "",
        tag_ids: [1, 2, 3],
        views: 0,
        likes: 0,
    })

const addTag = (data) => {
    if (payload.value.tag_ids.length > 4) {
        Swal.fire("Qúa nhiều tags rồi!", "Chỉ thêm được tối đa 5 tags.");
    } else if (!payload.value.tag_ids.find(i => i == data.id)) {
        payload.value.tag_ids.push(data.id);
        dataTags.value.tag_ids.push(data);
    }
}
const removeTag = (id) => {
    const index = payload.value.tag_ids.indexOf(id);
    if (index !== -1) {
        payload.value.tag_ids.splice(index, 1);
        dataTags.value.tag_ids.splice(index, 1);
    }
}

const handleCreated = (payload) => {
    axios.post("/api/posts", payload).then((response) => {
        console.log(response);
        if (response.data.status) {
            // console.log(response.data)
            router.push({ name: 'PostsDetail', params: { id: response.data.data.id }})

        }
    });
};
</script>
<style scoped>
.ck-editor .ck-editor__main .ck-editor__editable {
    height: 500px !important;;
}
</style>