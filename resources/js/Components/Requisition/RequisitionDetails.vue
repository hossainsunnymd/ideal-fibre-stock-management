<script setup>
const props = defineProps({
    products: Object,
    modal: Boolean,
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
    <div
        v-if="modal"
        class="fixed inset-0 z-50 flex items-center justify-center"
    >
        <div
            id="modal-content"
            class="bg-white w-[500px] max-w-full rounded-xl shadow-2xl p-6 relative print:w-full print:shadow-none print:p-0 h-[500px] overflow-auto"
        >
            <!-- Close Button -->
            <button
                @click="$emit('update:modal', false)"
                class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-2xl print:hidden"
            >
                &times;
            </button>

            <!-- Print Button -->
            <button
                @click="printModal"
                class="absolute top-3 left-3 text-sm bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition print:hidden"
            >
                🖨️ Print
            </button>

            <!-- Title -->
            <h1 class="text-2xl font-bold text-center pb-2">
                Ideal Fibre Industries Ltd.
            </h1>
            <h1 class="text-sm font-bold text-center pb-2">
                Madya Norshingpur, Kashipur,Fatullah,Nayaranganj
            </h1>
            <h1 class="text-1xl font-bold text-center mb-6 border-b pb-2">
                Store PURCHASE REQUISITION
            </h1>
            <div class="flex flex-col items-end mb-2">
                <h1 class="w-[150px] border">Indent No:</h1>
                <h1 class="w-[150px] border print:text-left">Date:</h1>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto overflow-y-auto">
                <table class="w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border text-center">#</th>
                            <th class="px-4 py-2 border text-center">
                                Name of Item
                            </th>
                            <th class="px-4 py-2 border text-center">Size</th>
                            <th class="px-4 py-2 border text-center">Unit</th>
                            <th class="px-4 py-2 border text-center">
                                Required Quantity
                            </th>
                            <th class="px-4 py-2 border text-center">
                                Present Stock
                            </th>
                            <th class="px-4 py-2 border text-center">
                                Store Code
                            </th>
                            <th class="px-4 py-2 border text-center">
                                Where to be use
                            </th>
                            <th class="px-4 py-2 border text-center">
                                Remarks
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(product, index) in props.products
                                .requisition_products"
                            :key="product.id"
                            class="hover:bg-gray-50 border-1 print:border-2"
                        >
                            <td class="px-4 py-2 border">{{ index + 1 }}</td>
                            <td class="px-4 py-2 border">
                                {{ product.product.name }}
                            </td>
                            <td class="px-4 py-2 border">{{}}</td>
                            <td class="px-4 py-2 border">
                                {{ product.product.unit_type }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ product.total_requisition }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ product.product.unit }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ product.store_code }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ product.where_to_use }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ product.remarks }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center text-xs text-gray-500 print:hidden">
                Press the Print button or Ctrl+P to print this summary.
            </div>
            <div class="absolute bottom-2 text-sm font-bold w-full hidden print:block">
                <div class="flex justify-between">
                    <p class="border-t-1">Prepared by</p>
                    <p class="border-t-1">Manager(store)</p>
                    <p class="border-t-1">Manager(Maintenence)</p>
                    <p class="border-t-1">Manager(Prodt.)</p>
                    <p class="border-t-1">G M(F & A)</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@media print {
    th,
    td {
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
