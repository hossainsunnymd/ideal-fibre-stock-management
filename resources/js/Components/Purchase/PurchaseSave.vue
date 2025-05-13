<script setup>
import { usePage, useForm, router } from "@inertiajs/vue3";
import { ref,computed } from "vue";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({});
const page = usePage();

const errors = computed(() => page.props.flash.errors || {});

const purchase_id = new URLSearchParams(window.location.search).get("purchase_id");
const purchaseProduct = page.props.purchaseProduct;

let URL = "/create-purchase";

const form = useForm({
  product_name: "",
  unit: 0,
  unit_type: "",
  purchase_id: purchase_id,
  seltected_product_id:0
});

if (purchase_id != 0 && purchaseProduct != null) {
  form.product_name = purchaseProduct.product_name;
  form.unit = purchaseProduct.unit;
  URL = "/update-purchase";
}

function submitForm() {
    if(form.seltected_product_id==0){
        toaster.error("Please select a product");
        return;

    }

  form.post(URL, {
    preserveScroll: true,
    onSuccess: () => {
      if (page.props.flash.status == false) {
        toaster.error(page.props.flash.message);
      } else if (page.props.flash.status == true) {
        toaster.success(page.props.flash.message);
        router.get("/list-purchase");
      }
    },
  });
}
function selectProduct(name,id){
    form.product_name=name
    form.seltected_product_id=id
}

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
     <div class="p-6 max-w-2xl">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Add Purchase Entry</h2>

    <form  class="space-y-5">

      <!-- Product Name -->
      <div>
        <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
        <input
          v-model="form.product_name"
          type="text"
          class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
          readonly
        />
      </div>


      <!-- Quantity -->
      <div>
        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
        <input
          v-model="form.unit"
          type="number"
          class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
        <p v-if="errors.unit" class="text-red-500">{{ errors.unit[0] }}</p>
      </div>

      <!-- Submit Button -->
      <div class="pt-3">
        <button @click="submitForm"
          type="button"
          class="w-full bg-green-600 text-white py-2 rounded-xl hover:bg-green-700 transition duration-300"
        >
          {{ purchase_id == 0 ? 'Add to Stock' : 'Update Product' }}
        </button>
      </div>

    </form>
  </div>
   <div class="mt-10">
       <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Select Product From Here</h2>
       <input type="text" class="border border-gray-300 rounded-md px-4 py-2 w-[300px] mb-2" v-model="searchItem" placeholder="Search here">
      <EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :search-field="searchField" :search-value="searchItem">

    <template #item-action="{ name,id }">

        <button @click="selectProduct(name,id)" class="bg-green-500 text-white font-bold py-2 px-4 rounded ml-1">Select</button>

    </template>

</EasyDataTable>
   </div>
 </div>
</template>

<style scoped></style>
