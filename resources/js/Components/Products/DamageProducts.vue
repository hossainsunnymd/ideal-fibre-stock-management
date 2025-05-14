<script setup>
import { ref } from 'vue'
import { usePage,useForm,Link } from '@inertiajs/vue3';
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
const items=ref(page.props.damageProducts.data);
const searchField = ref(["id","product.name"]);
const searchItem=ref();

const fromDate=new URLSearchParams(window.location.search).get('fromDate');
const toDate=new URLSearchParams(window.location.search).get('toDate');
const form=useForm({
    fromDate: fromDate,
    toDate: toDate,
});
function submitForm() {
    form.get('/damage-product-list');
}
</script>

<template>
 <p class="text-2xl font-bold">Damage Product List</p>
<div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center">
    <!-- Search and Clear Section -->
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-5">
        <input
            type="text"
            class="border border-gray-300 rounded-md px-4 py-2 w-full md:w-[300px]"
            v-model="searchItem"
            placeholder="Search here"
        >
        <Link
            class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 cursor-pointer text-center block md:inline-block"
            :href="`/damage-product-list`"
        >
            Clear Search
        </Link>
    </div>

    <!-- Date and Submit Section -->
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-2">
        <div>
            <label class="block md:inline-block mb-1 md:mb-0" for="fromDate">From:</label>
            <input
                v-model="form.fromDate"
                class="w-full md:w-[200px] border border-gray-300 p-2 rounded-md"
                type="date"
            >
        </div>
        <div>
            <label class="block md:inline-block mb-1 md:mb-0" for="toDate">To:</label>
            <input
                v-model="form.toDate"
                class="w-full md:w-[200px] border border-gray-300 p-2 rounded-md"
                type="date"
            >
        </div>
        <div>
            <button
                @click="submitForm()"
                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 cursor-pointer w-full md:w-auto"
            >
                Search
            </button>
        </div>
    </div>
</div>


<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :search-field="searchField" :search-value="searchItem">
    <template #item-damage_date="{ created_at }">
          {{ formatDate(created_at) }}
    </template>
</EasyDataTable>
<div class="flex justify-center gap-4 mt-6">
  <Link
    v-if="page.props.damageProducts.prev_page_url"
    :href="page.props.damageProducts.prev_page_url"
    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md shadow-sm transition"
  >
    ← Prev
  </Link>

  <Link
    v-if="page.props.damageProducts.next_page_url"
    :href="page.props.damageProducts.next_page_url"
    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md shadow-sm transition"
  >
    Next →
  </Link>
</div>

</template>

<style scoped>

</style>
