<script setup>
import { computed } from "vue";
import { usePage, useForm, router } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({});

const page = usePage();

const product_id = new URLSearchParams(window.location.search).get("product_id");
const product = page.props.product;
const errors = computed(() => page.props.flash.errors || {});


let URL = "/create-product";

const form = useForm({
  name: "",
  category_id: "",
  unit: 0,
  unit_type: "",
  product_id: product_id,
  minimum_stock:0,
  parts_no: "",
  rack_no: "",
  column_no: "",
  row_no: "",
});



if (product_id != 0 && product != null) {
  form.name = product.name;
  form.category_id = product.category_id;
  form.unit = product.unit;
  form.unit_type = product.unit_type;
  form.minimum_stock=product.minimum_stock;
  form.parts_no=product.parts_no;
  form.rack_no=product.rack_no;
  form.column_no=product.column_no;
  form.row_no=product.row_no;
  URL = "/update-product";
}

function submitForm() {

  form.post(URL, {
    preserveScroll: true,
    onSuccess: () => {
      if (page.props.flash.status == false) {
        toaster.error(page.props.flash.message);
      } else if (page.props.flash.status == true) {
        toaster.success(page.props.flash.message);
        router.get("/list-product");
      }
    },
  });
}
</script>

<template>
  <div class="p-6 max-w-2xl w-full mx-auto">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Add Stock Entry</h2>

    <form  class="space-y-5">

      <!-- Product Name -->
      <div>
        <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
        <input
          v-model="form.name"
          type="text"
          class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
        <p v-if="errors.name" class="text-red-500">{{ errors.name[0] }}</p>
      </div>

      <!-- Category -->
      <div>
        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
        <select
          v-model="form.category_id"
          class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
        >
          <option value="" disabled>Select Category</option>
          <option
            v-for="category in page.props.category"
            :key="category.id"
            :value="category.id"
          >
            {{ category.name }}
          </option>
        </select>
         <p v-if="errors.category_id" class="text-red-500">{{ errors.category_id[0] }}</p>
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

       <div>
        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Minimum Quantity</label>
        <input
          v-model="form.minimum_stock"
          type="number"
          class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
         <p v-if="errors.minimum_stock" class="text-red-500">{{ errors.minimum_stock[0] }}</p>
      </div>

       <div>
        <label for="parts_no" class="block text-sm font-medium text-gray-700 mb-1">Parts No</label>
        <input
          v-model="form.parts_no"
          type="text"
          class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

       <div>
        <label for="rack_no" class="block text-sm font-medium text-gray-700 mb-1"> Rack No</label>
        <input
          v-model="form.rack_no"
          type="text"
          class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

       <div>
        <label for="column_no" class="block text-sm font-medium text-gray-700 mb-1"> Column No</label>
        <input
          v-model="form.column_no"
          type="text"
          class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

       <div>
        <label for="row_no" class="block text-sm font-medium text-gray-700 mb-1"> Row No</label>
        <input
          v-model="form.row_no"
          type="text"
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
         <p v-if="errors.unit_type" class="text-red-500">{{ errors.unit_type[0] }}</p>
      </div>

      <!-- Submit Button -->
      <div class="pt-3">
        <button @click="submitForm"
          type="button"
          class="w-full bg-green-600 text-white py-2 rounded-xl hover:bg-green-700 transition duration-300"
        >
          {{ product_id == 0 ? 'Add to Stock' : 'Update Product' }}
        </button>
      </div>

    </form>
  </div>
</template>

<style scoped></style>
