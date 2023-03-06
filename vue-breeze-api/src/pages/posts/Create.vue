<template>
  <div class="container p-5">
    <div class="d-flex justify-content-between">
      <h3>Hãy chia sẻ kinh nghiệm đến mọi người nhé! 🥰</h3>
      <button class="btn">Lưu nháp</button>
    </div>
    <div class="editor">
      <label for="txtTitle">Tiêu đề:</label>
      <input type="text" class="editor__input" id="txtTitle">
      <label for="txtContent">Nội dung:</label>
      <tinymce id="txtContent" class="editor__input" v-model="editorContent" v-bind="editorConfig" />
    </div>
  </div>
</template>

<script setup>
import tinymce from '@tinymce/tinymce-vue'

const editorContent = ''
const editorConfig = {
  height: 500,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
  ],
  toolbar:
    'undo redo | formatselect | ' +
    'bold italic backcolor | alignleft aligncenter ' +
    'alignright alignjustify | bullist numlist outdent indent | ' +
    'removeformat | help',
  content_style:
    'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
}
</script>

<style scoped>
.editor{
  display: flex;
  flex-direction: column;
}
</style>