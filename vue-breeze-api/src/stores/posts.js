import {
    defineStore
} from 'pinia'
import axios from 'axios'

export const usePostStore = defineStore('post', {
    state: () => ({
        listPosts: null,
        selectedPost: null,
    }),
    getters: {
        posts: (state) => state.listPosts,
        post: (state) => state.selectedPost,
    },
    actions: {
        async fetchPosts() {
            const response = await axios.get('/api/posts')
            this.listPosts = response.data
        },
        async fetchPost(id) {
            const response = await axios.get(`/api/posts/${id}`)
            this.selectedPost = response.data
        },
        async createPost(payload) {
            await axios.post('/api/posts', payload)
                .then(response => {
                    this.listPosts.push(response.data)
                    Swal.fire(
                        'Lưu thành công',
                        'hí',
                        'success'
                    )
                })
        },
        async updatePost(payload) {
            const response = await axios.put(`/api/posts/${payload.id}`, payload)
            const index = this.listPosts.findIndex(post => post.id === payload.id)
            this.listPosts[index] = response.data
        },
        async deletePost(id) {
            await axios.delete(`/api/posts/${id}`)
            this.listPosts = this.listPosts.filter(post => post.id !== id)
        },
    },
})
