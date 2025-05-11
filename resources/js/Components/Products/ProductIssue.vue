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
<div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-end">
    <!-- Search & Clear -->
    <div class="flex flex-col gap-3 md:flex-row md:items-center">
        <input
            type="text"
            class="border border-gray-300 rounded-md px-4 py-2 w-full md:w-[300px]"
            v-model="searchItem"
            placeholder="Search here"
        >
        <Link
            class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 text-center md:inline-block w-full md:w-auto"
            :href="`/issue-product-list`"
        >
            Clear Search
        </Link>
    </div>

    <!-- Date Filter & Button -->
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
        <div>
            <button
                @click="submitForm()"
                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 w-full md:w-auto"
            >
                Search
            </button>
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
