<script setup>
import { ref } from 'vue'
import {router, usePage,Link} from '@inertiajs/vue3'
import { createToaster } from "@meforma/vue-toaster";

const toaster = createToaster({ });
const page=usePage()

const headers = [
    { text: 'ID', value: 'id' },
    { text: 'Name', value: 'name' },
    { text: 'Action', value: 'action' },
];

const items=ref(page.props.categories);
const searchField = ref("name");
const searchItem=ref();

function deleteCategory(id){
    if(confirm("Are you sure you want to delete this category?")){
        router.visit(`/delete-category?category_id=${id}`);
    }
}

if(page.props.flash.status==true){
    toaster.success(page.props.flash.message);
}else if(page.props.flash.status==false){
    toaster.error(page.props.flash.message);

}


</script>

<template>
<div class="flex justify-between">
    <div>
        <input type="text" class="border border-gray-300 rounded-md px-4 py-2 w-[300px]" v-model="searchItem" placeholder="Search by name">
    </div>
    <div>
        <Link :href="`/category-save-page?category_id=${0}`" class="bg-green-500 text-white  py-2 px-4 rounded">Add Category</Link>
    </div>
</div>
<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :search-field="searchField" :search-value="searchItem">
    <template #item-action="{ id }">
        <Link :href="`/category-save-page?category_id=${id}`" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Edit</Link>
        <button @click="deleteCategory(id)" class="bg-red-500 text-white font-bold py-2 px-4 rounded ml-1">Delete</button>
    </template>

</EasyDataTable>
</template>

<style scoped>

</style>
