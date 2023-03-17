<template>
    <div>
        <tag-input
            :initial-tags="tags"
            :api-url="'/api/tags/search'"
            @tags-updated="selectedTags = $event"
        ></tag-input>
        <div>Selected tags: {{ selectedTags }}</div>
    </div>
</template>

<script>
import axios from "axios";
import TagInput from "@/components/ui/TagInput.vue";
export default {
    components: {
        TagInput,
    },
    data() {
        return {
            tags: [],
            apiUrl: '/api/tags/search',
            selectedTags: [],
        };
    },
};
</script>
