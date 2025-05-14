<script setup>
import { ref } from 'vue'
import { usePage,useForm, router } from '@inertiajs/vue3';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ });
const page = usePage();

const headers = [
{text:'Requisition ID',value:'requisition.id'},
{text:'Product Name',value:'product.name'},
{text:'Total Requistion',value:'total_requisition'},
{text:'Total Received',value:'total_received'},
{text:'Action',value:'action'},
]
const searchItem=ref();
const searchField = ref(["requisition.id","product.name"]);
const items=ref(page.props.requisitionProducts);


const modal = ref(false);

const form = useForm({
    received_qty: '',
    requisition_product_id: '',
})

function showModal(id) {
    form.requisition_product_id = id;
    modal.value = true
}


function confirmAction() {
    if(form.received_qty<=0){
        toaster.error('Received quantity must be greater than 0');
        return;
    }
  if(confirm('Are you sure you want to received this product?')) {
    form.post('/requisition-received-request',{
        preserveScroll: true,
        onSuccess:()=>{
            if(page.props.flash.status==false){
                toaster.error(page.props.flash.message);
            }else if(page.props.flash.status==true){
                toaster.success(page.props.flash.message);
                 showModal.value = false
                 router.visit('/requisition-product-list');
            }
        }
    });
  }

}


</script>

<template>
     <p class="text-2xl font-bold">Requisition Product List</p>
    <input type="text" class="border border-gray-300 rounded-md px-4 py-2 w-[300px]" v-model="searchItem" placeholder="Search here">
<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :serch-field="searchField" :search-value="searchItem">
    <template #item-action="{ id }">
        <button @click="showModal(id)" class="bg-green-500 text-white font-bold py-2 px-4 rounded">Received</button>

    </template>
</EasyDataTable>


  <div>

    <!-- Modal Overlay -->
    <div
      v-if="modal"
      class="fixed inset-0 bg-black/15 bg-opacity-50 flex items-center justify-center z-50"
    >
      <!-- Modal Box -->
      <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
        <h2 class="text-xl font-semibold mb-4">Received Qty</h2>

        <input v-model="form.received_qty" class="border border-gray-300 rounded-md px-4 py-2 w-full" type="number">

        <!-- Action buttons -->
        <div class="flex justify-end mt-6 space-x-2">
          <button
            @click="modal = false"
            class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
          >
            Cancel
          </button>
          <button
            @click="confirmAction"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          >
            Confirm
          </button>
        </div>

        <!-- Close icon -->
        <button
          @click="modal = false"
          class="absolute top-2 right-2 text-gray-500 hover:text-black text-xl"
        >
          &times;
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
