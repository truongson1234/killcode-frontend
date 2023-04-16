<template>
    <div class="wrapper container py-5">
        <h1 class="mb-4 text-uppercase">Chủ đề ({{ tags.length }})</h1>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 grid-cols-1 gap-4 mb-5 list-tag">
            <div v-for="tag in displayedItems" :key="tag.id"
                class="col-span-1 p-4 rounded item-tag">
                <TagItem :data="tag" />
            </div>
        </div>
        <div v-if="tags.length > itemsPerPageTag">
            <v-pagination v-model="pageTag" :pages="totalPagesTag" :range-size="1"
                active-color="#0074FF" class="my-3"
                @update:modelValue="onPageChanged" />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import TagItem from "@/components/ui/TagItem.vue";
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import "@/assets/admin/css/pagination-styles.css";
import { pageLoading, pageLoaded } from '@/assets/js/app.js'
export default {
    components: {
        TagItem,
        VPagination
    },
    data() {
        return {
            tags: [], 
            currentPage: 1,
            pageTag: 1,
            itemsPerPageTag: 8
        };
    },
    created() {
        pageLoading(2000)
    },
    mounted() {
        this.fetchData();
        pageLoaded()
    },
    computed: {
        totalPagesTag() {
            if (this.tags != null) {
                return Math.ceil(this.tags.length / this.itemsPerPageTag);
            }
        },
        displayedItems() {
            if (this.tags != null) {
                var startIndex = (this.currentPage - 1) * this.itemsPerPageTag;
                var endIndex = startIndex + this.itemsPerPageTag;
                if (endIndex > this.tags.length) {
                    endIndex = this.tags.length
                }
                return this.tags.slice(startIndex, endIndex);
            }
        }
    },
    methods: {
        fetchData() {
            axios
                .get("/api/followed-tags")
                .then((response) => {
                    this.tags = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        onPageChanged(page) {
            this.currentPage = page;
            // axios
            //     .get("/api/followed-tags", {
            //         params: {
            //             page: this.currentPage,
            //             perPage: this.totalPages,
            //         },
            //     })
            //     .then((response) => {
            //         this.tags = response.data.data;
            //         this.currentPage = response.data.currentPage;
            //     })
            //     .catch((error) => {
            //         console.log(error);
            //     });
        },
        
    },
};
</script>
<style scoped>
.list-tag .item-tag {
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}
</style>

