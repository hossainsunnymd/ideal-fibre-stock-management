<template>
    <div class="flex min-h-screen bg-gray-100 font-sans">

      <!-- Mobile Toggle Button -->
      <button
        @click="toggleSidebar"
        class="md:hidden fixed top-4 left-4 z-30 p-2 bg-white rounded-md shadow"
      >
        <span class="material-icons text-gray-700">menu</span>
      </button>

      <!-- Sidebar -->
      <aside
        :class="[
          'w-64 bg-gray-800 text-white fixed inset-y-0 left-0 transform transition-transform duration-300 z-20 shadow-xl',
          sidebarOpen ? 'translate-x-0' : '-translate-x-full',
          'md:translate-x-0'
        ]" class="flex flex-col"
      >
        <div class="p-6 border-b border-gray-700">
          <h1 class="text-2xl font-bold text-white">My Dashboard</h1>
        </div>
        <nav class="p-4 flex-1 overflow-y-auto">
          <ul class="space-y-2">
              <li>
              <Link
                :href="`/list-user`"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors"
              >
                <span class="material-icons">groups</span>
                <span>Users</span>
              </Link>
            </li>
            <li>
              <Link
                :href="`/product-stock-list`"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors"
              >
                <span class="material-icons">inventory</span>
                <span>Product Stock List</span>
              </Link>
            </li>
            <li>
              <Link
                :href="`/list-category`"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors"
              >
                <span class="material-icons">category</span>
                <span>Category</span>
              </Link>
            </li>
            <li>
              <Link
                :href="`/list-product`"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors"
              >
                <span class="material-icons">inventory</span>
                <span>Products</span>
              </Link>
            </li>

            <li>
              <Link
                :href="`/list-requisition`"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors"
              >
                <span class="material-icons">shopping_cart</span>
                <span>Requisitions</span>
              </Link>
            </li>

            <li>
              <Link
                :href="`/requisition-product-list`"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors"
              >
                <span class="material-icons">receipt</span>
                <span>Requisition Products</span>
              </Link>
            </li>

              <li>
              <Link
                :href="`/issue-product-list`"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors"
              >
                <span class="material-icons">remove_shopping_cart</span>
                <span>Issue</span>
              </Link>
            </li>

              <li>
              <Link
                :href="`/list-purchase`"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors"
              >
               <span class="material-icons">shopping_bag</span>
                <span>Purchases</span>
              </Link>
            </li>

                <li>
              <Link
                :href="`/minimum-product-list`"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors"
              >
               <i class="material-icons">warning</i>
                <span>Minimum Stock</span>
              </Link>
            </li>

             <li>
              <Link
                :href="`/requisition-received-request-list`"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors"
              >
                <span class="material-icons text-green-600">check_circle</span>
                <span>Received Requisition Request</span>
              </Link>
            </li>

             <li>
              <Link
                :href="`/damage-product-list`"
                class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors"
              >
                 <span class="material-icons">dangerous</span>
                <span class="text-sm font-medium">Damaged item reported</span>
              </Link>
            </li>
          </ul>
        </nav>
        <div class="p-4 border-t ">
      <Link :href="`/logout`" class="w-full px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600 ">
        Logout
      </Link>
    </div>
      </aside>

      <!-- Main Content -->
      <main class="flex-1 p-6 md:ml-64 bg-gray-50 min-h-screen">
  <div class="bg-white rounded-xl shadow-md p-6  min-h-screen">
    <h2 class="text-3xl font-bold text-gray-800 mb-2">👋 Welcome to Stock Management System</h2>

    <!-- Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
       <slot></slot>
    </div>
  </div>
</main>


    </div>
  </template>

  <script setup>
  import { ref } from 'vue'
  import { Link } from '@inertiajs/vue3'

  const sidebarOpen = ref(false)

  const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value
  }

  const menuItems = [
    { icon: 'person', label: 'Customer' },
    { icon: 'category', label: 'Category' },
    { icon: 'inventory', label: 'Products' },
    { icon: 'receipt', label: 'Invoices' },
    { icon: 'shopping_cart', label: 'Create Sale' },
  ]
  </script>


