<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
const page = usePage();
const headers = [
    {text:'ID',value:'id'},
    {text:'Product Name',value:'product.name'},
    {text:'Total Requistion',value:'requisition_product.total_requisition'},
    {text:'Received Qty',value:'received_qty'},
    {text:'Status',value:'status'},
    {text:'Action',value:'action'},
]
const items=ref(page.props.recievedRequests);
</script>

<template>
<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5">
    <template #item-action="{ id }">
        <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Edit</button>
    </template>
</EasyDataTable>
</template>

<style scoped>

</style>
