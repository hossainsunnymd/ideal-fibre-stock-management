<script setup>
import RequisitionDetails from './RequisitionDetails.vue';
import { usePage,Link,router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ });
const page=usePage();

const headers = [
    { text: 'ID', value: 'id' },
    { text: 'Created By', value: 'created_by' },
    { text: 'Total By KG', value: 'total_by_kg' },
    { text: 'Total By Pc', value: 'total_by_pc' },
    { text: 'Total By Feet', value: 'total_by_feet' },
    { text: 'Total By Coel', value: 'total_by_coel' },
    { text: 'Action', value: 'action' },
]
const items=ref(page.props.requisitions.data);
const searchField = ref("id");
const searchItem=ref();

const modal = ref(false);
const products=ref();

function showModal(id) {
    products.value=items.value.find(item=>item.id==id);
    modal.value = true
    console.log(products.value);
}

function deleteRequisition(id) {

    if(confirm('Are you sure you want to delete this Requisition?')){
        router.get(`/delete-requisition?requisition_id=${id}`);

    }
}

if(page.props.flash.status==true){
    toaster.success(page.props.flash.message);
}else if(page.props.flash.status==false){
    toaster.error(page.props.flash.message);

}
</script>

<template>
     <p class="text-2xl font-bold">Requisition List</p>
    <RequisitionDetails v-model:modal="modal" :products="products"/>
<input type="text" class="border border-gray-300 rounded-md px-4 py-2 w-[300px]" v-model="searchItem" placeholder="Search here" >
<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5" :search-field="searchField" :search-value="searchItem">>
    <template #item-action="{ id }">
        <button @click="showModal(id)" class="cursor-pointer" ><i class="material-icons text-gray-600 text-xl">visibility</i></button>
        <button v-if="page.props.user.role=='superadmin'" @click="deleteRequisition(id)" class="cursor-pointer" ><i class="material-icons text-red-600 text-xl">delete</i></button>
    </template>
</EasyDataTable>
<Link v-if="page.props.user.role!='admin'" :href="`/requisition-save-page`" class="bg-green-500 text-white  py-2 px-4 rounded w-[200px]">Create new Requisition</Link>

<div class="flex justify-end gap-4 mt-6">
  <Link
    v-if="page.props.requisitions.prev_page_url"
    :href="page.props.requisitions.prev_page_url"
    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md shadow-sm transition"
  >
    ← Prev
  </Link>

  <Link
    v-if="page.props.requisitions.next_page_url"
    :href="page.props.requisitions.next_page_url"
    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md shadow-sm transition"
  >
    Next →
  </Link>
</div>

</template>

<style scoped>

</style>
