<template>
    <div>
        <input
            v-model="newTag"
            @input="searchTags"
            :placeholder="placeholder"
            class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md text-sm focus:border-black"
            :readonly="isReadonly"
            :style="isReadonly ? ['background: rgba(0,0,0,0.1)', 'pointer-events: none'] : ''"
        />
        <ul v-if="autocomplete != false" class="border-t-2 border-l-2 border-r-2 rounded-md mt-1">
            <li
                class="cursor-pointer hover:bg-gray-100 px-2 py-2 border-b-2"
                v-for="tag in matchingTags"
                :key="tag.id"
                @click="addTagFromAutocomplete(tag)"
            >
                {{ tag.name }}
            </li>
        </ul>
    </div>
</template>

<script>
import axios from "axios";
import { watchEffect } from "vue";
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
            default: false,
        },
        placeholder: {
            type: String,
            default: "Nhập tên quyền cần thêm...",
        },
    },
    setup(props) {
        watchEffect(() => {
        });
    },
    data() {
        return {
            newTag: "",
            matchingTags: [],
            showAutocomplete: true,
        };
    },
    computed: {
        tags() {
            return this.initialTags
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
                        return this.initialTags.map(
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
            this.$emit('add-item', {name: tag.name, id: tag.id})
            const existingTag = this.tags.find(
                (t) => t.name.toLowerCase() === tag.name.toLowerCase()
            );
            if (existingTag) {
                this.newTag = "";
                this.showAutocomplete = false;
                // console.log(this.showAutocomplete)
                return;
            }

            // Add new tag
            this.newTag = "";
            this.showAutocomplete = false;
            this.emitTagsUpdated()
        },
        emitTagsUpdated() {
            this.$emit('add-item', {name: tag.name, id: tag.id})
        }
    },
};
</script>
