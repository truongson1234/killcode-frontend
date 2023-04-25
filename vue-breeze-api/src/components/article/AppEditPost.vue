<template>
    <div class="">
        <div class="flex justify-between mb-6">
            <button @click="handleUpdated(payload.post)" type="button"
                class=" ml-auto text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                Lưu lại
            </button>
        </div>
        <div class="">
            <label for="base-input"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tiêu
                đề:</label>
            <input v-model="payload.post.title" type="text" id="base-input"
                @keyup="keyUpValidate('statusTitle', $event)"
                :class="[statusTitle ? 'border-red-600' : '']"
                class="bg-gray-50 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        </div>
        <div class="" v-if="statusTitle">
            <span class="text-sm text-red-600">Vui lòng nhập tiêu đề</span>
        </div>
        <div class="flex items-center mb-2 mt-2">
            <label for="" class="pr-2">Thẻ được gắn:</label>
            <ul v-for="(tag, index) in payload.tags" :key="index">
                <li
                    class="flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ">
                    <p class="text-blue-500">{{ tag.name }}</p>
                    <button
                        class="flex items-center justify-center ml-1 hover:rounded-full hover:bg-gray-400 hover:text-white"
                        @click="removeTag(tag.id)"><i class='bx bx-x'></i></button>
                </li>
            </ul>
        </div>
        <div>
            <SearchTags :apiUrl="dataTags.url"
                :placeholder="'Gắn thẻ bài viết của bạn. Tối đa 5 thẻ. Ít nhất 1 thẻ!'"
                @add-item="addTag" :hightlight-border="statusTag" />
        </div>
        <div class="" v-if="statusTag">
            <span class="text-sm text-red-600">Vui lòng gắn chủ đề</span>
        </div>
        <div class="mt-3">
            <ckeditor :editor="editor" v-model="payload.post.body"
                @input="checkCkeditor" @focus="onEditorFocus"
                :config="editorConfig" />
        </div>
        <div class="" v-if="statusBody">
            <span class="text-sm text-red-600">Vui lòng nội dung</span>
        </div>
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
const statusTitle = ref(false), statusTag = ref(false), statusBody = ref(false), focusEditor = ref(false), statusSaveDraft = ref(true)
const checkCkeditor = () => {
    if (focusEditor.value) {
        payload.value.post.body == '' ? (statusBody.value = true, $('.ck.ck-reset.ck-editor.ck-rounded-corners').attr('style', 'border: 1px solid red')) : (statusBody.value = false, $('.ck.ck-reset.ck-editor.ck-rounded-corners').removeAttr('style'))
    }
}
const onEditorFocus = (event) => {
    focusEditor.value = true
    //   console.log('CKEditor is focused!');
}
const keyUpValidate = (name, event) => {
    var val = event.target.value
    name == 'statusTitle' && val == '' ? statusTitle.value = true : statusTitle.value = false
}
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
        statusTag.value = false

    }
}
const removeTag = (id) => {
    const index = payload.value.post.tag_ids.indexOf(id);
    if (index !== -1) {
        payload.value.post.tag_ids.splice(index, 1);
        payload.value.tags.splice(index, 1);
    }
    if (payload.value.post.tag_ids.length < 1) {
        statusTag.value = true
    }
}
onMounted(async () => {
    const response = await fetchData(postId);
    payload.value = response.data
    payload.value.post.tag_ids = []
    payload.value.tags.forEach(function (item) {
        payload.value.post.tag_ids.push(item.id)
    })
    console.log(response.data);
});

const handleUpdated = (payload) => {
    console.log(payload);
    if (payload.title == '' || payload.tag_ids.length < 1 || payload.body == '') {
        payload.title == '' ? statusTitle.value = true : statusTitle.value = false
        payload.tag_ids.length < 1 ? statusTag.value = true : statusTag.value = false
        payload.body == '' ? (statusBody.value = true, $('.ck.ck-reset.ck-editor.ck-rounded-corners').attr('style', 'border: 1px solid red')) : (statusBody.value = false, $('.ck.ck-reset.ck-editor.ck-rounded-corners').removeAttr('style'))
    } else {
        axios.put(`/api/posts/${postId}`, payload)
            .then(res => {
                // console.log(res);
                statusSaveDraft.value = false
                router.push({ name: 'PostDetail', params: { id: postId } })
                .then(() => {router.go()})
            })
            .catch(err => {
                console.log(err);
            })
    }
};
router.beforeEach((to, from, next) => {
    if (from.name === 'PostEdit') {
        if (payload.value.post.title != '' && payload.value.post.tag_ids.length > 0 && payload.value.post.body != '' && statusSaveDraft.value == true) {
            // Swal.fire({
            //     title: "Bạn đang muốn rời đi trong khi bài viết chưa xuất bản.",
            //     text: `Bạn có muốn lưu bài viết này dưới dạng bản nháp không?`,
            //     icon: "warning",
            //     showCancelButton: true,
            //     confirmButtonColor: "#3085d6",
            //     cancelButtonColor: "#A6A6A6",
            //     confirmButtonText: "Lưu",
            //     cancelButtonText: "Hủy",
            // })
            const confirmNavigation = confirm('Bạn có muốn lưu lại bài viết?');

            if (!confirmNavigation) {
                next(false);
                return;
            } else {
                axios.put(`/api/posts/draft/${postId}`, payload.value.post)
                // .then((response) => {
                //      console.log(response.data)
                // });
            }

        }
    }
    next()
});
</script>
