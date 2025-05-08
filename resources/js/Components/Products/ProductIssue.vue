<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
const page = usePage();

const headers = [
{text:'Id',value:'id'},
{text:'Product Name',value:'product.name'},
{text:'Issue Qty',value:'unit'},
{text:'Issue Date',value:'issue_date'},

]
const items=ref(page.props.issueProducts);
const searchField = ref(["id","product.name"]);
const searchItem=ref();
const formatDate = (date) => {
  const d = new Date(date).toLocaleString();
  return d;
};
</script>

<template>
 <EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :serch-field="searchField" :search-value="searchItem">
   <template #item-issue_date="{ created_at }">
          {{ formatDate(created_at) }}
        </template>
 </EasyDataTable>
</template>

<style scoped>

</style>
