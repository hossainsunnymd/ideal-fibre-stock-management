<script setup>
 import { ref } from 'vue'
 import {router, usePage,Link} from '@inertiajs/vue3'
 const page=usePage();

 const headers = [
     {text:'ID',value:'id'},
     {text:'Product Name',value:'product_name'},
     {text:'Unit',value:'unit'},
     {text:'Action',value:'action'},
 ]
 const items=ref(page.props.purchases);
 const searchField = ref(["id","product.name"]);
 const searchItem=ref();

 function deletePurchase(purchase_id){
     if(confirm("Are you sure you want to delete this purchase?")){
        router.get(`/delete-purchase?purchase_id=${purchase_id}`);
     }
 }
</script>

<template>
<div class="flex justify-between">
    <div>
        <input type="text" class="border border-gray-300 rounded-md px-4 py-2 w-[300px]" v-model="searchItem" placeholder="Search here" >
    </div>
    <div>
        <Link :href="`/purchase-save-page?purchase_id=${0}`" class="bg-green-500 text-white  py-2 px-4 rounded">Add Purchase</Link>
    </div>
</div>
<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :search-field="searchField" :search-value="searchItem">
    <template #item-action="{ id }">
        <Link :href="`/purchase-save-page?purchase_id=${id}`" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Edit</Link>
        <button @click="deletePurchase(id)" class="bg-red-500 text-white font-bold py-2 px-4 rounded ml-1">Delete</button>
    </template>
</EasyDataTable>
</template>

<style scoped>

</style>
