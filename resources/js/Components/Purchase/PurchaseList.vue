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
 const items=ref(page.props.purchases.data);
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
<div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-end">
    <!-- Search Input + Clear Button -->
    <div class="flex flex-col gap-3 md:flex-row md:items-center">
        <input
            type="text"
            class="border border-gray-300 rounded-md px-4 py-2 w-full md:w-[300px]"
            v-model="searchItem"
            placeholder="Search here"
        >
        <Link
            class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 text-center md:w-auto"
            :href="`/list-purchase`"
        >
            Clear Search
        </Link>
    </div>

    <!-- Date Range + Search Button -->
    <div class="flex flex-col gap-3 md:flex-row md:items-center">
        <div>
            <label for="fromDate" class="block mb-1">From:</label>
            <input
                v-model="form.fromDate"
                class="w-full md:w-[200px] border border-gray-300 p-2 rounded"
                type="date"
            >
        </div>
        <div>
            <label for="toDate" class="block mb-1">To:</label>
            <input
                v-model="form.toDate"
                class="w-full md:w-[200px] border border-gray-300 p-2 rounded"
                type="date"
            >
        </div>
            <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 w-full md:w-auto mt-[23px]">view all</button>
        <div>
            <button
                @click="submitForm()"
                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 w-full md:w-auto mt-[23px]"
            >
                Search
            </button>
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

<div class="flex justify-center gap-4 mt-6">
  <Link
    v-if="page.props.purchases.prev_page_url"
    :href="page.props.purchases.prev_page_url"
    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md shadow-sm transition"
  >
    ← Prev
  </Link>

  <Link
    v-if="page.props.purchases.next_page_url"
    :href="page.props.purchases.next_page_url"
    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md shadow-sm transition"
  >
    Next →
  </Link>
</div>

</template>

<style scoped>

</style>
