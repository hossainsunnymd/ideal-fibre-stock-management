<script setup>
import {usePage,useForm,router } from '@inertiajs/vue3';
import { computed } from 'vue';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ });
const page=usePage();
const user_id=new URLSearchParams(window.location.search).get('user_id');
const user=page.props.users;
const errors=computed(() => page.props.flash.errors || {});
const form=useForm({
    user_id:user_id,
    name:'',
    email:'',
    password:'',
    role:'',
    phone:'',
})

let URL='/create-user';
if(user_id != 0 && user != null){
    form.name=user.name;
    form.email=user.email;
    form.role=user.role;
    form.phone=user.phone;
    URL='/update-user';
}

function submitForm() {

  form.post(URL, {
    preserveScroll: true,
    onSuccess: () => {
      if (page.props.flash.status == false) {
        toaster.error(page.props.flash.message);
      } else if (page.props.flash.status == true) {
        toaster.success(page.props.flash.message);
        router.get('/list-user');
      }
    },

  });
}
</script>

<template>


<div class=" flex  justify-center ">
  <div class="max-w-xl w-full bg-white p-6 rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">{{ user_id==0?'User Registration':'Update User' }}</h2>

    <form  class="space-y-4">
      <!-- Name -->
      <div>
        <label class="block text-gray-700 font-semibold mb-1">Name</label>
        <input v-model="form.name" type="text"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" >
      </div>
      <p v-if="errors.name" class="text-red-500">{{errors.name[0]  }}</p>

      <!-- Email -->
      <div>
        <label class="block text-gray-700 font-semibold mb-1">Email</label>
        <input v-model="form.email" type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" :readonly="user_id!=0" >
      </div>
      <p v-if="errors.email" class="text-red-500">{{errors.email[0] }}</p>

      <!-- Password -->
      <div>
        <label class="block text-gray-700 font-semibold mb-1">Password</label>
        <input v-model="form.password" type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" >
           <p v-if="errors.password" class="text-red-500">{{ errors.password[0]}}</p>
      </div>


      <!-- Role -->
      <div>
        <label class="block text-gray-700 font-semibold mb-1">Role</label>
        <select v-model="form.role" name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" >
          <option value="">Select Role</option>
          <option value="superadmin">Super Admin</option>
          <option value="admin">Admin</option>
          <option value="moderator">Moderator</option>
        </select>
      </div>
      <p v-if="errors.role" class="text-red-500">{{ errors.role[0] }}</p>

      <!-- Phone -->
      <div>
        <label class="block text-gray-700 font-semibold mb-1">Phone</label>
        <input v-model="form.phone" type="tel" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" >
      </div>

      <!-- Submit Button -->
      <div>
        <button @click="submitForm" type="button" class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
          {{ user_id==0?'Register':'Update' }}
        </button>
      </div>
    </form>
  </div>
</div>




</template>

<style scoped>

</style>
