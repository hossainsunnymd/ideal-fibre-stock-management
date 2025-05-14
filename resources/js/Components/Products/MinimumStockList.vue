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
     <p class="text-2xl font-bold">Minimum Stock List</p>
    <div class="flex flex-col gap-3 md:flex-row md:justify-between md:items-center">
    <!-- Search Input -->
    <div>
        <input
            type="text"
            class="border border-gray-300 rounded-md px-4 py-2 w-full md:w-[300px]"
            v-model="searchItem"
            placeholder="Search by name"
        >
    </div>

</div>

<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :search-field="searchField" :search-value="searchItem">
</EasyDataTable>
</template>

<style scoped>

</style>
