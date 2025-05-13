<script setup>
const props = defineProps({
    items: Array,
    modal: Boolean,
    fromDate: String,
    toDate: String
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
  <div v-if="modal" class="fixed inset-0 z-50 flex items-center justify-center">
    <div id="modal-content" class="bg-white w-[500px] max-w-full rounded-xl shadow-2xl p-6 relative print:w-full print:shadow-none print:p-0 h-[500px] overflow-auto">

      <!-- Close Button -->
      <button @click="$emit('update:modal', false)" class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-2xl print:hidden">
        &times;
      </button>

      <!-- Print Button -->
      <button @click="printModal" class="absolute top-3 left-3 text-sm bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition print:hidden">
        🖨️ Print
      </button>

      <!-- Title -->
      <h1 class="text-2xl font-bold text-center  pb-2"> Ideal Fibre Industries Ltd. </h1>
      <h1 class="text-sm font-bold text-center  pb-2">Report Date: {{props.fromDate}} to {{props.toDate}}</h1>

      <!-- Table -->
      <div class=" overflow-x-auto overflow-y-auto ">
        <table class="w-full border border-gray-300 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-2 border text-center ">#</th>
              <th class="px-4 py-2 border text-center ">Name of Item</th>
              <th class="px-4 py-2 border text-center ">Category</th>
              <th class="px-4 py-2 border text-center ">Parts No</th>
              <th class="px-4 py-2 border text-center ">Rack No</th>
              <th class="px-4 py-2 border text-center ">Column No</th>
              <th class="px-4 py-2 border text-center ">Row No</th>
              <th class="px-4 py-2 border text-center ">Available Stock</th>
              <th class="px-4 py-2 border text-center ">Total Received</th>
              <th class="px-4 py-2 border text-center ">Total Issue</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in props.items" :key="index" class="hover:bg-gray-50 border-1 print:border-2">
              <td class="px-4 py-2 border">{{ index + 1 }}</td>
              <td class="px-4 py-2 border">{{ item.product_name }}</td>
              <td class="px-4 py-2 border">{{ item.category_name }}</td>
              <td class="px-4 py-2 border">{{ item.parts_no }}</td>
              <td class="px-4 py-2 border">{{ item.rack_no }}</td>
              <td class="px-4 py-2 border">{{ item.column_no }}</td>
              <td class="px-4 py-2 border">{{ item.row_no }}</td>
              <td class="px-4 py-2 border">{{item.available_unit }}</td>
              <td class="px-4 py-2 border">{{item.total_received  }}</td>
              <td class="px-4 py-2 border">{{ item.total_issue }}</td>
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
@media print {
  th, td {
    border: 2px solid black !important;
    font-weight: bold !important;
    color: black !important;
  }

  table {
    page-break-inside: auto;
    width: 100% !important;
    border-collapse: collapse !important;
  }

  tr {
    page-break-inside: avoid;
    page-break-after: auto;
  }

  thead {
    display: table-header-group;
  }
}

</style>
