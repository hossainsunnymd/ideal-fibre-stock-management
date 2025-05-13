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
    fromDate: fromDate,
    toDate: toDate,
    category_id:category_id
});


function submitForm(){
    form.get('/product-stock-list');
}

</script>

<template>
     <p class="text-2xl font-bold">All Product Stock List</p>
<div class="flex flex-col gap-4 lg:flex-row lg:justify-between">
  <!-- Left Section -->
  <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:gap-5 w-full">
    <!-- Search input -->
    <input
      type="text"
      class="border border-gray-300 rounded-md px-4 py-2 w-full lg:w-[250px]"
      v-model="searchItem"
      placeholder="Search here"
    />

    <!-- Category select -->
    <select
      v-model="form.category_id"
      class="border border-gray-300 rounded-md px-4 py-2 w-full lg:w-[250px]"
    >
      <option>Select Category</option>
      <option
        v-for="category in page.props.categories"
        :value="category.id"
        :key="category.id"
      >
        {{ category.name }}
      </option>
    </select>

    <!-- Clear Search button -->
    <Link
      class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 text-center w-full lg:w-auto"
      :href="`/product-stock-list`"
    >
      Clear Search
    </Link>
  </div>

  <!-- Right Section -->
  <div class="flex flex-col gap-4 lg:flex-row lg:items-end w-full lg:w-auto">
    <!-- From Date -->
    <div class="flex flex-col w-full lg:w-[200px]">
      <label for="fromDate" class="mb-1">From:</label>
      <input
        v-model="form.fromDate"
        id="fromDate"
        class="border border-gray-300 p-2 rounded w-full"
        type="date"
      />
    </div>

    <!-- To Date -->
    <div class="flex flex-col w-full lg:w-[200px]">
      <label for="toDate" class="mb-1">To:</label>
      <input
        v-model="form.toDate"
        id="toDate"
        class="border border-gray-300 p-2 rounded w-full"
        type="date"
      />
    </div>

    <!-- Search Button -->
    <div class="w-full lg:w-auto">
      <button
        @click="submitForm()"
        class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 w-full lg:w-auto"
      >
        Search
      </button>
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
