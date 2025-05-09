
<template>

 <div>


    <!-- Modal Overlay -->
    <div
      v-if="modal"
      class="fixed inset-0 bg-black/15 bg-opacity-50 flex items-center justify-center z-50"
    >
      <!-- Modal Box -->
      <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
        <label for="availabe_qty" >Available Qty</label>
        <input v-model="product.unit" class="border border-gray-300 rounded-md px-4 py-2 w-full" type="text">
        <label for="product_name" >Product Name</label>
        <input v-model="product.name" class="border border-gray-300 rounded-md px-4 py-2 w-full" type="text">
        <label for="requistion_qty" >Requisition Qty</label>
        <input v-model="product.requisition_qty" class="border border-gray-300 rounded-md px-4 py-2 w-full" type="number">
        <label for="qty_type">Qty Type</label>
        <input readonly  v-model="product.unit_type" class="border border-gray-300 rounded-md px-4 py-2 w-full" type="text">

        <!-- Action buttons -->
        <div class="flex justify-end mt-6 space-x-2">
          <button
            @click="modal = false"
            class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
          >
            Cancel
          </button>
          <button
            @click="addProduct"
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




<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>

  <div class=" border border-gray-300 p-6 rounded-lg bg-white shadow-md">
    <div class="text-right">
      <h2 class="text-xl font-semibold text-gray-800">Invoice</h2>
      <p class="text-sm text-gray-600">{{ new Date().toISOString().slice(0, 10) }}</p>
    </div>

    <div class="mt-6">
      <h3 class="text-lg font-semibold text-gray-800">Requisition Order For:</h3>
    </div>

    <div class="overflow-x-auto mt-6">
      <table class="min-w-full border border-gray-300 text-sm text-left text-gray-700">
        <thead class="bg-gray-100 text-gray-800 font-semibold">
          <tr>
            <th class="px-3 py-2 border">No</th>
            <th class="px-3 py-2 border">Name</th>
            <th class="px-3 py-2 border">Qty</th>
            <th class="px-3 py-2 border">Action</th>

          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(product, index) in productList"
            :key="index"
            class="hover:bg-gray-50 transition-colors"
          >
            <td class="px-3 py-2 border">{{ index + 1 }}</td>
            <td class="px-3 py-2 border">{{ product.name }}</td>
            <td class="px-3 py-2 border">{{ product.requisition_qty }}</td>
            <td class="px-3 py-2 border text-center">
              <button
                @click="removeProduct(index)"
                class="text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded"
              >
                Remove
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="mt-6 text-sm text-gray-800 ">
      <p>Total Order By Pcs: <span class="font-semibold">{{ total.total_by_pc }}</span></p>
      <p>Total Order By Kg: <span class="font-semibold">{{ total.total_by_kg }}</span></p>
      <p>Total Order By Feet: <span class="font-semibold">{{ total.total_by_feet }}</span></p>
      <p>Total Order By Coel: <span class="font-semibold">{{ total.total_by_coel }}</span></p>
    </div>
    <button @click="createRequisiton()" class="bg-indigo-500 text-white  py-2 px-4 rounded mt-10 hover:bg-indigo-600 cursor-pointer">
        Confirm
    </button>
  </div>


    </div>
    <div>
        <EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="10" :search-field="searchField" :search-value="searchItem">
            <template #item-action="{ id,unit,name,unit_type }">
                <button @click="showModal(id,unit,name,unit_type)" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Add</button>
            </template>
      </EasyDataTable>
    </div>
</div>
</template>

<style scoped>

</style>


<script setup>
import { usePage,useForm,router } from '@inertiajs/vue3';
import { ref,reactive } from 'vue';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ });
const page = usePage();
const headers = [
    {text:'ID',value:'id'},
    {text:'Product Name',value:'name'},
    {text:'Category',value:'category.name'},
    {text:'Quantity',value:'unit'},
    {text:'Action',value:'action'},
]
const modal = ref(false);
const product=reactive({
    id: '',
    unit: '',
    unit_type: '',
    name: '',
    requisition_qty: 0,
})
function showModal(id,unit,name,unit_type) {
    product.id=id;
    product.unit=unit;
    product.name=name;
    product.unit_type=unit_type;
    modal.value = true
}

const items=ref(page.props.products);
const searchField = ref(["id","name"]);
const searchItem=ref();

const productList = ref([]);
 function addProduct(){
    const ifExist = productList.value.find(item => item.id === product.id);
    if(ifExist){
        toaster.error('Product Already Added');
        modal.value=false;
    }else if(product.requisition_qty==0){
        toaster.error('Minimum Quantity is 1');
    }
    else if(product.requisition_qty<=product.unit){
       const confirmProduct = {
            id: product.id,
            unit: product.unit,
            name: product.name,
            unit_type: product.unit_type,
            requisition_qty: product.requisition_qty,
        }
    productList.value.push(confirmProduct);
    modal.value=false;
     calculateTotal();
    }else{
        alert('Enter Valid Quantity');
    }
 }

function removeProduct(index) {
    productList.value.splice(index, 1);
    calculateTotal();
}

const total=reactive({
    total_by_coel: 0,
    total_by_feet: 0,
    total_by_kg: 0,
    total_by_pc: 0,
})

function calculateTotal() {
    total.total_by_coel = productList.value
        .filter(product => product.unit_type == 'coel')
        .reduce((sum, product) => sum + parseFloat(product.requisition_qty), 0);

    total.total_by_feet = productList.value
        .filter(product => product.unit_type == 'feet')
        .reduce((sum, product) => sum + parseFloat(product.requisition_qty), 0);

    total.total_by_kg = productList.value
        .filter(product => product.unit_type == 'kg')
        .reduce((sum, product) => sum + parseFloat(product.requisition_qty), 0);

    total.total_by_pc = productList.value
        .filter(product => product.unit_type == 'pc')
        .reduce((sum, product) => sum + parseFloat(product.requisition_qty), 0);
}


const form = useForm({
    products: '',
    total_by_coel: 0,
    total_by_feet: 0,
    total_by_kg: 0,
    total_by_pc: 0,
})
function createRequisiton(){
    form.products=productList.value;
    form.total_by_coel=total.total_by_coel;
    form.total_by_feet=total.total_by_feet;
    form.total_by_kg=total.total_by_kg;
    form.total_by_pc=total.total_by_pc;

    form.post('/create-requisition',{
        preserveScroll: true,
        onSuccess: () => {
            if(page.props.flash.status==false){
                toaster.error(page.props.flash.message);
            }else if(page.props.flash.status==true){
                toaster.success(page.props.flash.message);
                router.visit('/list-requisition');
            }
        }
    });

}
</script>
