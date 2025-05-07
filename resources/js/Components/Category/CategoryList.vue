<script setup>
import { ref } from 'vue'
import {usePage} from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
const page=usePage()
console.log(page.props.categories)

const headers = [
    { text: 'ID', value: 'id' },
    { text: 'Name', value: 'name' },
    { text: 'Action', value: 'action' },
];

const items=ref(page.props.categories);
const searchField = ref("name");
const searchItem=ref();


</script>

<template>
<input type="text" class="border border-gray-300 rounded-md px-4 py-2 w-[300px]" v-model="searchItem" placeholder="Search by name">
<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :search-field="searchField" :search-value="searchItem">
    <template #item-action="{ id }">
        <Link :href="`category`" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Edit</Link>
        <button   class="bg-red-500 text-white font-bold py-2 px-4 rounded ml-1">Delete</button>
    </template>

</EasyDataTable>
</template>

<style scoped>

</style>
