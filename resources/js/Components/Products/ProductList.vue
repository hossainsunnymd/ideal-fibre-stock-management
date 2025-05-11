<script setup>
import { usePage,Link,router } from '@inertiajs/vue3';
import { createToaster } from "@meforma/vue-toaster";
import { ref } from 'vue';
const toaster = createToaster({ });
const page=usePage();

const headers = [
    {text:'ID',value:'id'},
    {text:'Product Name',value:'name'},
    {text:'Category',value:'category.name'},
    {text:'Quantity',value:'unit'},
    {text:'Action',value:'action'},
]
const items=ref(page.props.products);
const searchField = ref(["id","name"]);
const searchItem=ref();

function deleteProduct(porduct_id){
    if(confirm("Are you sure you want to delete this product?")){
        router.visit(`/delete-product?product_id=${porduct_id}`);
    }
}

if(page.props.flash.status==true){
    toaster.success(page.props.flash.message);
}else if(page.props.flash.status==false){
    toaster.error(page.props.flash.message);

}

</script>

<template>
     <p class="text-2xl font-bold">Product List</p>
   <div class="flex flex-col md:flex-row md:justify-between gap-3 md:items-center">
    <div class="w-full md:w-auto">
        <input
            type="text"
            class="border border-gray-300 rounded-md px-4 py-2 w-full md:w-[300px]"
            v-model="searchItem"
            placeholder="Search by name"
        >
    </div>
    <div class="w-full md:w-auto">
        <Link
            :href="`/product-save-page?product_id=${0}`"
            class="bg-green-500 text-white py-2 px-4 rounded block text-center md:inline-block w-full md:w-auto"
        >
            Add Product
        </Link>
    </div>
</div>

<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :search-field="searchField" :search-value="searchItem">

    <template #item-action="{ id }">
        <Link :href="`/product-save-page?product_id=${id}`" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Edit</Link>
        <button @click="deleteProduct(id)" class="bg-red-500 text-white font-bold py-2 px-4 rounded ml-1">Delete</button>
        <Link :href="`/product-issue-page?product_id=${id}`" class="bg-indigo-500 text-white font-bold py-2 px-4 rounded ml-1">Issue</Link>
    </template>

</EasyDataTable>
</template>

<style scoped>

</style>
