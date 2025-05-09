<script setup>
import { usePage,Link } from '@inertiajs/vue3';
import { ref } from 'vue';
const page=usePage();

const headers = [
    { text: 'ID', value: 'id' },
    { text: 'Created By', value: 'created_by' },
    { text: 'Total By KG', value: 'total_by_kg' },
    { text: 'Total By Pc', value: 'total_by_pc' },
    { text: 'Total By Feet', value: 'total_by_feet' },
    { text: 'Total By Coel', value: 'total_by_coel' },
    { text: 'Action', value: 'action' },
]
const items=ref(page.props.requisitions);
const searchField = ref("id");
const searchItem=ref();
</script>

<template>
<input type="text" class="border border-gray-300 rounded-md px-4 py-2 w-[300px]" v-model="searchItem" placeholder="Search here" >
<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :search-field="searchField" :search-value="searchItem">>
    <template #item-action="{ id }">
        <Link :href="`/requisition-save-page?requisition_id=${id}`" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Edit</Link>
        <button @click="deleteRequisition(id)" class="bg-red-500 text-white font-bold py-2 px-4 rounded ml-1">Delete</button>
    </template>
</EasyDataTable>
<Link :href="`/requisition-save-page`" class="bg-green-500 text-white  py-2 px-4 rounded w-[200px]">Create new Requisition</Link>
</template>

<style scoped>

</style>
