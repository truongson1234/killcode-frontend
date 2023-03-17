<template>
    <div>
        <input
            v-model="newTag"
            @input="searchTags"
            @keydown.enter="addTag"
            placeholder="Add a tag..."
        />
        <ul v-if="showAutocomplete">
            <li
                v-for="tag in matchingTags"
                :key="tag.id"
                @click="addTagFromAutocomplete(tag)"
            >
                {{ tag.name }}
            </li>
        </ul>
        <div v-for="tag in tags" :key="tag.id" class="tag">
            {{ tag.name }} <span @click="removeTag(tag)">x</span>
        </div>
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
            this.emitTagsUpdated()
        },
        emitTagsUpdated() {
            this.$emit('tags-updated', this.tags.map(tag => tag.name))
        }
    },
};
</script>
