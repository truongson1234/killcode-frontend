<template>
    <div class="reports">
        <ReportItem v-for="report in reports" :key="report.id" :report="report" />
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import ReportItem from "@/components/ui/ReportItem.vue";

const reports = ref([])

onMounted(() => {
    fetchData()
});

const fetchData = () => {
    axios
        .get("/api/reports")
        .then((response) => {
            reports.value = response.data;
            // console.log(reports);
        })
        .catch((error) => {
            console.log(error);
        });
}
</script>

<style lang="scss" scoped>

</style>