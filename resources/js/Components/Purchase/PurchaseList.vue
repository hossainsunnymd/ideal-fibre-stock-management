<script setup>
 import { ref } from 'vue'
 import {router, usePage,Link,useForm} from '@inertiajs/vue3'
 const page=usePage();

 const headers = [
     {text:'ID',value:'id'},
     {text:'Product Name',value:'product_name'},
     {text:'Unit',value:'unit'},
     {text:'Action',value:'action'},
 ]
 const items=ref(page.props.purchases);
 const searchField = ref(["id","product_name"]);
 const searchItem=ref();

 function deletePurchase(purchase_id){
     if(confirm("Are you sure you want to delete this purchase?")){
        router.get(`/delete-purchase?purchase_id=${purchase_id}`);
     }
 }

 const fromDate=new URLSearchParams(window.location.search).get('fromDate');
const toDate=new URLSearchParams(window.location.search).get('toDate');
const form=useForm({
    fromDate: fromDate,
    toDate: toDate,
});
function submitForm() {
    form.get('/list-purchase');
}
</script>

<template>
     <p class="text-2xl font-bold">Purchase List</p>
 <div class="flex justify-between">
    <div class="flex gap-5">
        <input type="text" class="border border-gray-300 rounded-md px-4 py-2 w-[300px]" v-model="searchItem" placeholder="Search here" >
        <Link class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 cursor-pointer" :href="`/list-purchase`">Clear Search</Link>
    </div>
    <div class="flex gap-2">
        <div>

        <label for="fromDate">From:</label>
        <input v-model="form.fromDate" class="w-[200px] border border-gray-300 p-2" type="date">
    </div>
    <div>
        <label for="toDate">To:</label>
        <input v-model="form.toDate" class="w-[200px] border border-gray-300 p-2" type="date">
    </div>
    <div>
        <button @click="submitForm()" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 cursor-pointer">Search</button>
    </div>
    </div>


 </div>
<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :search-field="searchField" :search-value="searchItem">
    <template #item-action="{ id }">
        <Link :href="`/purchase-save-page?purchase_id=${id}`" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Edit</Link>
        <button @click="deletePurchase(id)" class="bg-red-500 text-white font-bold py-2 px-4 rounded ml-1">Delete</button>
    </template>
</EasyDataTable>
<Link :href="`/purchase-save-page?purchase_id=${0}`" class="bg-green-500 text-white  py-2 px-4 rounded w-[130px]">Add Purchase</Link>
</template>

<style scoped>

</style>
