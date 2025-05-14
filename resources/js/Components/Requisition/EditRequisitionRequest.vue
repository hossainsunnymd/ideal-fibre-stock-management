<script setup>
import { usePage, useForm, router } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({});

const page = usePage();
const id = new URLSearchParams(window.location.search).get("id");
const requisition = page.props.requisition;
const form = useForm({
  received_qty:requisition.received_qty,
  id:id
});


function submitForm() {
  if(form.received_qty<=0){
      toaster.error('Received quantity must be greater than 0');
      return;

  }
  form.post('/update-requisition-request', {
    preserveScroll: true,
    onSuccess: () => {
      if (page.props.flash.status == false) {
        toaster.error(page.props.flash.message);
      } else if (page.props.flash.status == true) {
        toaster.success(page.props.flash.message);
        router.get(`requisition-received-request-list`);
      }
    },
  });
}
</script>

<template>
<div class="p-6 max-w-2xl w-full mx-auto">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Update Received Quantity</h2>

  <form @submit.prevent="submitForm" class="space-y-5">

    <div>
      <label for="received_qty" class="block text-sm font-medium text-gray-700 mb-1">Received Quantity</label>
      <input v-model="form.received_qty" type="number"
             class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400" />

    </div>

    <div class="pt-3">
      <button type="submit"
              class="w-full bg-green-600 text-white py-2 rounded-xl hover:bg-green-700 transition duration-300">
       Update
      </button>
    </div>

  </form>
</div>


</template>

<style scoped></style>
