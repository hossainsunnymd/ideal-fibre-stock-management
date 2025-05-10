<script setup>
const props = defineProps({
    products: Object,
    modal: Boolean
});

const emit = defineEmits(["update:modal"]);

const printModal = () => {
  const printContents = document.getElementById("modal-content").innerHTML;
  const originalContents = document.body.innerHTML;

  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
  location.reload();
};
</script>

<template>
  <div v-if="modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/30">
    <div id="modal-content" class="bg-white w-[500px] max-w-full rounded-xl shadow-2xl p-6 relative print:w-full print:shadow-none print:p-0">

      <!-- Close Button -->
      <button @click="$emit('update:modal', false)" class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-2xl print:hidden">
        &times;
      </button>

      <!-- Print Button -->
      <button @click="printModal" class="absolute top-3 left-3 text-sm bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition print:hidden">
        🖨️ Print
      </button>

      <!-- Title -->
      <h2 class="text-2xl font-bold text-center mb-6 border-b pb-2 print:text-left">🧾 Requisition Summary</h2>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-2 border-b text-left">#</th>
              <th class="px-4 py-2 border-b text-left">Product Name</th>
              <th class="px-4 py-2 border-b text-left">Quantity</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(product, index) in props.products.requisition_products" :key="product.id" class="hover:bg-gray-50">
              <td class="px-4 py-2 border-b">{{ index + 1 }}</td>
              <td class="px-4 py-2 border-b">{{ product.product.name }}</td>
              <td class="px-4 py-2 border-b">{{ product.total_requisition }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Footer -->
      <div class="mt-6 text-center text-xs text-gray-500 print:hidden">
        Press the Print button or Ctrl+P to print this summary.
      </div>

    </div>
  </div>
</template>

<style scoped>

</style>
