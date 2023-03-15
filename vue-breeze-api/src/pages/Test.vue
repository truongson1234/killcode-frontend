<script setup>
import { ref, watch, onMounted, computed } from 'vue'
import { useRolesStore } from '@/stores/roles.js'
import "bootstrap-table/dist/bootstrap-table.min.css";
import "bootstrap-table/dist/bootstrap-table.min.js";
const data_ = [
    {
        id: 1,
        name: 'John',
        price: '123-456-7890'
    },
    {
        id: 2,
        name: 'AD',
        price: '456-789-1230'
    },
]
onMounted(() => {
    $("#table123").bootstrapTable({
        data: data_,
    });
})
</script>
<template>
    <div>
        <table id="table123" data-toggle="table" >
            <thead>
                <tr>
                    <th data-field="id" data-sortable="true">ID</th>
                    <th data-field="name" data-sortable="true">Item Name</th>
                    <th data-field="price" data-sortable="true">Item Price</th>
                </tr>
            </thead>
        </table>
    </div>
</template>