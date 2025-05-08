<script setup>
import SideNav from '../../Layout/SideNav.vue';
import { useForm,usePage,router } from '@inertiajs/vue3';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ });
const page = usePage();
const product_id=new URLSearchParams(window.location.search).get('product_id');
const form = useForm({
    issue: '',
    damage: '',
    product_id:product_id ,
})

const submitForm = () => {
    if(confirm('Are you sure to issue this product?')){
       form.post('/issue-product',{
           preserveScroll: true,
           onSuccess: () => {
               if(page.props.flash.status==false){
                   toaster.error(page.props.flash.message);
               }else if(page.props.flash.status==true){
                   toaster.success(page.props.flash.message);
                   router.visit('/list-product');
               }
           }
       });
    }

}
</script>

<template>
<SideNav>
    <!-- component -->
<div class="  flex items-center justify-center p-4">
  <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">

    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Issue and Damage</h2>

    <form @submit.prevent="submitForm" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Issue</label>
        <input v-model="form.issue"
          type="number"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Damage</label>
        <input v-model="form.damage"
          type="number"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
        />
      </div>
      <button type="submit" class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
        Confirm
      </button>
    </form>
  </div>
</div>
</SideNav>

</template>

<style scoped>

</style>
