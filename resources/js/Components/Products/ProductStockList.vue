<script setup>
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";
const page=usePage();
const headers = [
    { text: 'Available stock', value: 'available_unit' },
    { text: 'Name', value: 'product_name' },
    { text: 'Total Received', value: 'total_received' },
    { text: 'Total Issue', value: 'total_issue' },
]
const items=ref(page.props.productList);
const searchField = ref(["available_unit","product_name","total_received","total_issue"]);
const searchItem=ref();
</script>

<template>
<input type="text" class="border border-gray-300 rounded-md px-4 py-2 w-[300px]" v-model="searchItem" placeholder="Search here" >
<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :search-field="searchField" :search-value="searchItem">

</EasyDataTable>

</template>

<style scoped>

</style>
