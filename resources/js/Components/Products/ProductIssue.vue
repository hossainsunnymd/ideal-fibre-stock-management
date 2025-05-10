<script setup>
import { usePage,useForm,Link } from '@inertiajs/vue3';
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
const fromDate=new URLSearchParams(window.location.search).get('fromDate');
const toDate=new URLSearchParams(window.location.search).get('toDate');
const form=useForm({
    fromDate: fromDate,
    toDate: toDate,
});
function submitForm() {
    form.get('/issue-product-list');
}
</script>

<template>
 <p class="text-2xl font-bold">Product Issue List</p>
 <div class="flex justify-between">
    <div class="flex gap-5">
        <input type="text" class="border border-gray-300 rounded-md px-4 py-2 w-[300px]" v-model="searchItem" placeholder="Search here" >
        <Link class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 cursor-pointer" :href="`/issue-product-list`">Clear Search</Link>
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
   <template #item-issue_date="{ created_at }">
          {{ formatDate(created_at) }}
        </template>
 </EasyDataTable>
</template>

<style scoped>

</style>
