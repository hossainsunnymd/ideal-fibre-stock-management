<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3';
const page = usePage();

const headers = [
    {text:'ID',value:'id'},
    {text:'Product Name',value:'product.name'},
    {text:'Damage Qty',value:'unit'},
    {text:'Damage Date',value:'damage_date'},
]
const formatDate = (date) => {
  const d = new Date(date).toLocaleString();
  return d;
};
const items=ref(page.props.damageProducts);
</script>

<template>
<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5">
    <template #item-damage_date="{ created_at }">
          {{ formatDate(created_at) }}
    </template>
</EasyDataTable>
</template>

<style scoped>

</style>
