<template>
    <div>
        <tag-input
            :initial-tags="tags"
            :api-url="'/api/tags/search'"
        ></tag-input>
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
        };
    },
    created() {
        // Get initial tags from server
        axios
            .get("/api/tags")
            .then((response) => {
                this.tags = response.data.map((tag) => tag.name);
            })
            .catch((error) => {
                console.log(error);
            });
    },
};
</script>
