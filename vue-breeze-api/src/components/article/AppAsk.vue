<template>
    <tags-input v-model="tags" :autocomplete-items="existingTags"></tags-input>
</template>

<script>
import TagsInput from "@voerro/vue-tagsinput";

export default {
    components: { TagsInput },
    data() {
        return {
            tags: [],
            existingTags: [
                "Apple",
                "Banana",
                "Orange",
                "Pineapple",
                "Watermelon",
            ],
        };
    },
};
</script>
