<template>
    <div :class="['flex flex-col h-screen bg-gray-50', isDarkMode ? 'bg-gray-800 text-white' : 'bg-white text-black']">
    <!-- Topbar Full Width -->
    <Topbar @toggle-sidebar="toggleSidebar" />

    <div class="flex flex-1 overflow-hidden">
      <!-- Sidebar -->
      <Sidebar :is-collapsed="isSidebarCollapsed" />

      <!-- Main Content Area -->
      <Toast />
      <main :class="['flex-1 p-4 overflow-y-auto']">
        <slot />
      </main>
    </div>
    
    <Footer />
  </div>
  </template>
  
  <script setup>
  import Sidebar from '@/Components/Sidebar.vue';
  import Topbar from '@/Components/Topbar.vue';
  import Footer from '@/Components/Footer.vue';
  import { ref, inject } from 'vue';

const isDarkMode = inject('isDarkMode', ref(false));
  // State untuk mengatur apakah sidebar collapsed atau tidak
  const isSidebarCollapsed = ref(false);
  
  function toggleSidebar() {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
  }
  </script>
  
  <style scoped>
  /* No custom styles needed unless for specific adjustments */
  </style>
  