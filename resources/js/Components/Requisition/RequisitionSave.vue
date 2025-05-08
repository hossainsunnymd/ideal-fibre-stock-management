<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
const page = usePage();
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
</script>

<template>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>

  <div class=" border border-gray-300 p-6 rounded-lg bg-white shadow-md">
    <div class="text-right">
      <h2 class="text-xl font-semibold text-gray-800">Invoice</h2>
      <p class="text-sm text-gray-600">{{ new Date().toISOString().slice(0, 10) }}</p>
    </div>

    <!-- <div class="mt-6">
      <h3 class="text-lg font-semibold text-gray-800">Work Order For:</h3>
      <p class="text-gray-700">Name: <span class="font-medium">{{ customer.name }}</span></p>
      <p class="text-gray-700">Mobile: <span class="font-medium">{{ customer.mobile }}</span></p>
    </div> -->

    <div class="overflow-x-auto mt-6">
      <table class="min-w-full border border-gray-300 text-sm text-left text-gray-700">
        <thead class="bg-gray-100 text-gray-800 font-semibold">
          <tr>
            <th class="px-3 py-2 border">No</th>
            <th class="px-3 py-2 border">Description</th>
            <th class="px-3 py-2 border">Qty/Pc</th>
            <th class="px-3 py-2 border">Qty/Kg</th>
            <th class="px-3 py-2 border">Weight</th>
            <th class="px-3 py-2 border">Size</th>
            <th class="px-3 py-2 border">Rate</th>
            <th class="px-3 py-2 border">Total</th>
            <th class="px-3 py-2 border">Action</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr
            v-for="(product, index) in productList"
            :key="index"
            class="hover:bg-gray-50 transition-colors"
          >
            <td class="px-3 py-2 border">{{ index + 1 }}</td>
            <td class="px-3 py-2 border">{{ product.description }}</td>
            <td class="px-3 py-2 border">{{ product.qty_by_pc }}</td>
            <td class="px-3 py-2 border">{{ product.qty_by_kg }}</td>
            <td class="px-3 py-2 border">{{ product.weight }}</td>
            <td class="px-3 py-2 border">{{ product.size }}</td>
            <td class="px-3 py-2 border">{{ product.rate }}</td>
            <td class="px-3 py-2 border">{{ product.order_price }}</td>
            <td class="px-3 py-2 border text-center">
              <button
                @click="removeProduct(index)"
                class="text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded"
              >
                Remove
              </button>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>

    <div class="mt-6 space-y-4">
      <div class="flex flex-wrap gap-4">
        <!-- <label class="flex flex-col text-sm text-gray-700">
          Delivery Date:
          <input
            v-model="form.delivery_date"
            type="date"
            class="mt-1 px-3 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none"
          />
        </label> -->

        <!-- <label class="flex flex-col text-sm text-gray-700">
          Delivery Place:
          <input
            v-model="form.delivery_place"
            type="text"
            class="mt-1 px-3 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none"
          />
        </label> -->
      </div>

      <div>
        <!-- <label class="block text-sm text-gray-700 mb-1">Note (Remark):</label>
        <textarea
          v-model="form.note"
          class="w-full p-3 border rounded-md h-24 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
          placeholder="Add note here"
        ></textarea> -->
      </div>
    </div>

    <div class="mt-6 text-sm text-gray-800 space-y-1">
      <p>Total Order By Pcs: <span class="font-semibold"></span></p>
      <p>Total Order By Kg: <span class="font-semibold"></span></p>
    </div>
  </div>


    </div>
    <div>
        <EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :search-field="searchField" :search-value="searchItem">
            <template #item-action="{ id }">
                <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Add</button>
            </template>
      </EasyDataTable>
    </div>
</div>
</template>

<style scoped>

</style>
