<template>
    <div>
        <input
            v-model="newTag"
            @input="searchTags"
            placeholder="Nhập tên quyền cần thêm..."
            class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md text-sm focus:border-black"
            :readonly="isReadonly"
            :style="isReadonly ? ['background: rgba(0,0,0,0.1)', 'pointer-events: none'] : ''"
        />
        <ul v-if="showAutocomplete" class="border-t-2 border-l-2 border-r-2 rounded-md mt-1">
            <li
                class="cursor-pointer hover:bg-gray-100 px-2 py-2 border-b-2"
                v-for="tag in matchingTags"
                :key="tag.id"
                @click="addTagFromAutocomplete(tag)"
            >
                {{ tag.name }}
            </li>
        </ul>
        <!-- <div v-for="tag in tags" :key="tag.id">
            <span  class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                {{ tag.name }} <span @click="removeTag(tag)"><i class='bx bx-x'></i></span>
            </span>
        </div> -->
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "TagInput",
    props: {
        initialTags: {
            type: Array,
            default: () => [],
        },
        apiUrl: {
            type: String,
            default: "",
        },
        isReadonly: {
            type: Boolean,
            default: "",
        },
    },
    data() {
        return {
            tags: [],
            newTag: "",
            matchingTags: [],
            showAutocomplete: false,
        };
    },
    created() {
        this.tags = this.initialTags.map((tag) => ({ name: tag }));
    },
    methods: {
        addTag() {
            // Check for duplicates
            const existingTag = this.tags.find(
                (tag) => tag.name.toLowerCase() === this.newTag.toLowerCase()
            );
            if (existingTag) {
                this.newTag = "";
                return;
            }

            // Add new tag
            this.tags.push({ name: this.newTag });
            this.newTag = "";
            this.emitTagsUpdated()
        },
        removeTag(tag) {
            const index = this.tags.indexOf(tag);
            if (index !== -1) {
                this.tags.splice(index, 1);
            }
            this.emitTagsUpdated()
        },
        searchTags() {
            if (this.newTag === "") {
                this.matchingTags = [];
                this.showAutocomplete = false;
                return;
            }

            axios
                .get(this.apiUrl + "?q=" + this.newTag)
                .then((response) => {
                    this.matchingTags = response.data.filter((tag) => {
                        // Exclude tags that already exist
                        return !this.tags.some(
                            (t) =>
                                t.name.toLowerCase() === tag.name.toLowerCase()
                        );
                    });
                    this.showAutocomplete = true;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        addTagFromAutocomplete(tag) {
            // Check for duplicates
            const existingTag = this.tags.find(
                (t) => t.name.toLowerCase() === tag.name.toLowerCase()
            );
            if (existingTag) {
                this.newTag = "";
                this.showAutocomplete = false;
                return;
            }

            // Add new tag
            this.tags.push({ name: tag.name });
            this.newTag = "";
            this.showAutocomplete = false;
<<<<<<< HEAD
            this.emitTagsUpdated()
        },
        emitTagsUpdated() {
            this.$emit('tags-updated', this.tags.map(tag => tag.name))
=======
            this.$emit('add-item', {name: tag.name, id: tag.id})
>>>>>>> 58c5b7fa3ea70407975e7994381ed19dcc4e8f08
        }
    },
};
</script>
