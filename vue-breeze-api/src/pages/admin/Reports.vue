<template>
    <div class="reports">
        <ReportItem v-for="report in reports" :key="report.id" :report="report" @click-item="removeReport"/>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import ReportItem from "@/components/admin/ui/ReportItem.vue";

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

const removeReport = async (id) => {
    axios.delete(`/api/reports/${id}`)
    .then((response) => {
        console.log('me');
        fetchData()
    })
}
</script>

<style scoped>
.reports{
    padding: 25px;
    border-radius: 10px;
    background-color: #596cff;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
}
</style>