<script setup>
import { usePage, useForm, router } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({});

const page = usePage();

const purchase_id = new URLSearchParams(window.location.search).get("purchase_id");
const purchaseProduct = page.props.purchaseProduct;
console.log(purchaseProduct);

let URL = "/create-purchase";

const form = useForm({
  product_name: "",
  unit: 0,
  unit_type: "",
  purchase_id: purchase_id,
});

if (purchase_id != 0 && purchaseProduct != null) {
  form.product_name = purchaseProduct.product_name;
  form.unit = purchaseProduct.unit;
  form.unit_type = purchaseProduct.unit_type;
  URL = "/update-purchase";
}

function submitForm() {

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
</script>

<template>
  <div class="p-6 max-w-2xl w-full mx-auto">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Add Purchase Entry</h2>

    <form  class="space-y-5">

      <!-- Product Name -->
      <div>
        <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
        <input
          v-model="form.product_name"
          type="text"
          class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
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
      </div>

      <!-- Unit type -->
      <div>
        <label for="unit_type" class="block text-sm font-medium text-gray-700 mb-1">Unit Type</label>
        <select
          v-model="form.unit_type"
          class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
        >
          <option value="kg">Kg</option>
          <option value="feet">Feet</option>
          <option value="Coel">Coel</option>
          <option value="Pc">pc</option>
        </select>
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
</template>

<style scoped></style>
