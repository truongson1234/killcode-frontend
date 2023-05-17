import { defineStore } from "pinia";
import axios from "axios";

export const useTagStore = defineStore("tag", {
    state: () => ({
        tags: null,
        tagErrors: null
    }),
    getters: {
        dataTags: (state) => state.tags,
        dataTagErrors: (state) => state.tagErrors
    },
    actions: {
        async getTags() {
            await axios.get('api/admin/tags')
            .then(response => {
                this.tags = response.data.data
                this.tags.map((tag) => {
                    tag.thumbnail = 'http://localhost:8000/images/tags/' + tag.thumbnail
                })
            })
            .catch(error => {
                console.log(error)
            })
        },
        async handleDeleteTag(id) {
            await axios.delete(`api/admin/tags/${id}`)
            .then(res => {
                this.getTags()
                this.tagErrors = 'success!'
            })
            .catch(err => {
                console.log(err)
            })
        },
        async handleAddTag(form) {
            await axios.post(`api/admin/tags`, form)
            .then(res => {
                this.getTags()
                this.tagErrors = 'success!'
                console.log(res);
            })
            .catch(err => {
                if(err.response.status == 422) {
                    this.tagErrors = err.response.data.error
                }
                console.log(err)
            })
        },
        async handleEditTag(id, form) {
            await axios.put(`api/admin/tags/${id}`, form)
            .then(res => {
                this.getTags()
                this.tagErrors = 'success!'
            })
            .catch(err => {
                if(err.response.status == 422) {
                    this.tagErrors = err.response.data.error
                }
                console.log('duma',err)
            })
        },
    }
})