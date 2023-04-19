<template>
    <div class="create-post-unique">
        <div class="flex justify-between mb-6">
            <button @click="handleCreated(payload)" type="button"
                class=" ml-auto text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                Xuất bản bài viết
            </button>
        </div>
        <div class="">
            <input v-model="payload.title" placeholder="Tiêu đề bài viết" type="text"
                id="base-input"
                class="bg-gray-50 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                :class="[statusTitle ? 'border-red-600' : '']"
                @keyup="keyUpValidate('statusTitle', $event)" />
        </div>
        <div class="" v-if="statusTitle">
            <span class="text-sm text-red-600">Vui lòng nhập tiêu đề bài viết</span>
        </div>

        <div class="flex items-center mb-2 mt-2">
            <label for="" class="pr-2">Thẻ được gắn:</label>
            <ul v-for="(tag, index) in dataTags.tags" :key="index">
                <li
                    class="flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ">
                    <p class="text-blue-500">{{ tag.name }}</p>
                    <button
                        class="flex items-center justify-center ml-1 hover:rounded-full hover:bg-gray-400 hover:text-white"
                        @click="removeTag(tag.id)"><i class='bx bx-x'></i></button>
                </li>
            </ul>
        </div>
        <div class="">
            <SearchTags :apiUrl="dataTags.url"
                :placeholder="'Gắn thẻ bài viết của bạn. Tối đa 5 thẻ. Ít nhất 1 thẻ!'"
                @add-item="addTag" :hightlight-border="statusTag" />
        </div>
        <div class="" v-if="statusTag">
            <span class="text-sm text-red-600">Vui lòng gắn chủ đề cho bài viết</span>
        </div>
        <div class="mt-3">
            <ckeditor :editor="editor" v-model="payload.body" @input="checkCkeditor"
                @focus="onEditorFocus" :config="editorConfig" />
        </div>
        <div class="" v-if="statusBody">
            <span class="text-sm text-red-600">Vui lòng nội dung bài viết</span>
        </div>
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
import List from '@ckeditor/ckeditor5-list/src/list';
import Heading from '@ckeditor/ckeditor5-heading/src/heading';

const editor = ClassicEditor;
const editorConfig = {
    plugins: [
        EssentialsPlugin,
        BoldPlugin,
        ItalicPlugin,
        LinkPlugin,
        ParagraphPlugin,
        CodeBlock,
        List,
        Heading
    ],
    toolbar: {
        items: ["bold", "italic", "link", "undo", "redo", "codeBlock", "bulletedList", "numberedList", "heading"],
    },
};
const dataTags = ref({
    url: "/api/tags",
    tags: [],
})

const payload = ref({
    title: "",
    body: "",
    tag_ids: [],
    views: 0,
    likes: 0,
})
const statusTitle = ref(false), statusTag = ref(false), statusBody = ref(false), focusEditor = ref(false)
const addTag = (data) => {
    console.log(data);
    if (payload.value.tag_ids.length > 4) {
        // Swal.fire("Qúa nhiều tags rồi!", "Chỉ thêm được tối đa 5 tags.");
    } else if (!payload.value.tag_ids.find(i => i == data.id)) {
        payload.value.tag_ids.push(data.id);
        dataTags.value.tags.push(data);
        statusTag.value = false
    }
}
const checkCkeditor = () => {
    if (focusEditor.value) {
        payload.value.body == '' ? (statusBody.value = true, $('.ck.ck-reset.ck-editor.ck-rounded-corners').attr('style', 'border: 1px solid red')) : (statusBody.value = false, $('.ck.ck-reset.ck-editor.ck-rounded-corners').removeAttr('style'))
    }
}
const onEditorFocus = (event) => {
    focusEditor.value = true
    //   console.log('CKEditor is focused!');
}

const removeTag = (id) => {
    const index = payload.value.tag_ids.indexOf(id);
    if (index !== -1) {
        payload.value.tag_ids.splice(index, 1);
        dataTags.value.tags.splice(index, 1);
    }
    if (payload.value.tag_ids.length < 1) {
        statusTag.value = true
    }
}
const keyUpValidate = (name, event) => {
    var val = event.target.value
    name == 'statusTitle' && val == '' ? statusTitle.value = true : statusTitle.value = false
}
const handleCreated = (payload) => {
    if (payload.title == '' || payload.tag_ids.length < 1 || payload.body == '') {
        payload.title == '' ? statusTitle.value = true : statusTitle.value = false
        payload.tag_ids.length < 1 ? statusTag.value = true : statusTag.value = false
        payload.body == '' ? (statusBody.value = true, $('.ck.ck-reset.ck-editor.ck-rounded-corners').attr('style', 'border: 1px solid red')) : (statusBody.value = false, $('.ck.ck-reset.ck-editor.ck-rounded-corners').removeAttr('style'))
    } else {
        axios.post("/api/posts", payload).then((response) => {
            console.log(response);
            if (response.data.status) {
                // console.log(response.data)
                // router.push({ name: 'PostDetail', params: { id: response.data.data.id } })
                // .then(() => { router.go() })

            }
        });
    }
};
</script>
<style>
.create-post-unique .ck.ck-editor__main>.ck-editor__editable {
    height: 500px !important;
    ;
}
</style>