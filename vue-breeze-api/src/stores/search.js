import { defineStore } from "pinia";
import axios from "axios";

export const useSearchStore = defineStore("search", {
    state: () => ({
        dataSearch: null,
    }),
    getters: {
        getDataSearch: (state) => state.dataSearch,
    },
    actions: {
        async handleGetDataSearch(data) {
            this.dataSearch = data;
            this.dataSearch.posts.forEach(function (item) {
                item.author.avatar =
                    "http://localhost:8000/images/" + item.author.avatar;
            });
            this.dataSearch.questions.forEach(function (item) {
                item.author.avatar =
                    "http://localhost:8000/images/" + item.author.avatar;
            });
            this.router.push({ name: "Search" });
        },
        async handleSearch(payload) {
            await axios
                .get("/api/search", {
                    params: {
                        keyword: payload.keyword,
                        sort_by: payload.payload,
                    },
                })
                .then((response) => {
                    this.dataSearch = response.data;
                    console.log(payload, this.dataSearch);
                    this.dataSearch.posts.forEach(function (item) {
                        item.author.avatar =
                            "http://localhost:8000/images/" + item.author.avatar;
                    });
                    this.dataSearch.questions.forEach(function (item) {
                        item.author.avatar =
                            "http://localhost:8000/images/" + item.author.avatar;
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async handleGetSearchAll() {
            await axios.get('api/search/all')
            .then(res => {
                this.dataSearch = res.data;
                this.dataSearch.tags.forEach(function (item) {
                    item.thumbnail =
                        "http://localhost:8000/images/tags/" + item.thumbnail;
                });
                this.dataSearch.posts.forEach(function (item) {
                    item.author.avatar =
                        "http://localhost:8000/images/" + item.author.avatar;
                });
                this.dataSearch.questions.forEach(function (item) {
                    item.author.avatar =
                        "http://localhost:8000/images/" + item.author.avatar;
                });
            })
            .catch(err => {
                console.log(err);
            })
        }
    },
});
