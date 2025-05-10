<script setup>
import { usePage,Link,router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ });
const page = usePage();
const headers = [
    {text:'ID',value:'id'},
    {text:'Product Name',value:'product.name'},
    {text:'Total Requistion',value:'requisition_product.total_requisition'},
    {text:'Received Qty',value:'received_qty'},
    {text:'Status',value:'status'},
    {text:'Action',value:'action'},
]
const items=ref(page.props.recievedRequests);

function approvedRequest(received_id) {
    if(confirm('Are you sure you want to approved this request?')){
        router.visit(`/requisition-approve-request?received_id=${received_id} & status=approved`);
    }
}
function cancelRequest(received_id) {
    if(confirm('Are you sure you want to Cancel this request?')){
        router.visit(`/requisition-approve-request?received_id=${received_id} & status=cancel`);
    }
}

if(page.props.flash.status==true){
    toaster.success(page.props.flash.message);
}else if(page.props.flash.status==false){
    toaster.error(page.props.flash.message);

}
</script>

<template>
<EasyDataTable :headers="headers" :items="items" alternating :rows-per-page="5">
    <template #item-action="{ id }">
        <Link :href="`/edit-requisition-request-page?id=${id}`"  class="bg-blue-500 text-white font-bold py-2 px-4 rounded cursor-pointer">Edit</Link>
        <button @click="approvedRequest(id)" class="bg-green-500 text-white font-bold py-2 px-4 rounded mx-1">Approved</button>
        <button @click="cancelRequest(id)" class="bg-red-500 text-white font-bold py-2 px-4 rounded">Cancel</button>
    </template>
</EasyDataTable>
</template>

<style scoped>

</style>
