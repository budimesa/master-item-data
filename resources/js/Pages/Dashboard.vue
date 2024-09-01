<template>
    <ThemeProvider>
      <div :class="isDarkMode ? 'bg-gray-900 text-white' : 'bg-gray-50 text-black'" class="flex flex-col h-screen">
        <!-- Topbar Full Width -->
        <Topbar @toggle-sidebar="toggleSidebar" />
  
        <div class="flex flex-1 overflow-hidden">
          <!-- Sidebar -->
          <Sidebar :is-collapsed="isSidebarCollapsed" />
  
          <!-- Main Content Area -->
          <main class="flex-1 p-4 overflow-y-auto">
            <slot />
          </main>
        </div>
        
        <!-- Footer (Optional) -->
        <Footer class="p-4" />
      </div>
    </ThemeProvider>
  </template>
  
  <script setup>
  import { ref, inject } from 'vue';
  import ThemeProvider from '@/Components/ThemeProvider.vue';
  import Sidebar from '@/Components/Sidebar.vue';
  import Topbar from '@/Components/Topbar.vue';
  import Footer from '@/Components/Footer.vue';
  
  const isSidebarCollapsed = ref(false);
  const isDarkMode = inject('isDarkMode');
  
  function toggleSidebar() {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
  }
  </script>
  