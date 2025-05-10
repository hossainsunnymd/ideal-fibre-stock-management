<script setup>
import {usePage,useForm,Link} from "@inertiajs/vue3";
import {ref} from "vue";
const page=usePage();
const headers = [
    { text: 'Name', value: 'product_name' },
    { text: 'Available stock', value: 'available_unit' },
    { text: 'Total Received', value: 'total_received' },
    { text: 'Total Issue', value: 'total_issue' },
]

const items=ref(page.props.productList);
const searchField = ref(["available_unit","product_name","total_received","total_issue"]);
const searchItem=ref();
const fromDate=new URLSearchParams(window.location.search).get('fromDate');
const toDate=new URLSearchParams(window.location.search).get('toDate');
const category_id=new URLSearchParams(window.location.search).get('category_id');
const category_name=page.props.category_name;

const form=useForm({
    fromDate: fromDate?fromDate:'',
    toDate: toDate?toDate:'',
    category_id:category_id
});


function submitForm(){
    form.get('/product-stock-list');
}

</script>

<template>
 <div class="flex justify-between">
    <div class="flex gap-5">
        <input type="text" class="border border-gray-300 rounded-md px-4 py-2 w-[300px]" v-model="searchItem" placeholder="Search here" >
        <select v-model="form.category_id" class="border border-gray-300 rounded-md px-4 py-2 w-[300px]" >
            <option>Select Category</option>
            <option v-for="category in page.props.categories" :value="category.id" >{{category.name}}</option>
        </select>
        <Link class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 cursor-pointer" :href="`/product-stock-list`">Clear Search</Link>
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
  <p>Period : {{ fromDate?fromDate:'-' }} To {{ toDate?toDate:'-' }}</p>
  <p>Selected Category : {{ category_name?category_name:'-' }} </p>
<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :search-field="searchField" :search-value="searchItem">

</EasyDataTable>

</template>

<style scoped>

</style>
