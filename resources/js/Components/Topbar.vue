<template>
     <header class="w-full bg-white border-b">
    <div class="flex items-center justify-between p-4">
      <div class="flex items-center">
        <!-- Tombol untuk meng-collapse sidebar -->
        <button @click="$emit('toggle-sidebar')" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:ring">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
          </svg>
        </button>
        <span class="ml-4 text-lg font-semibold">CJFI</span>
      </div>
      <div class="flex items-center">
        <!-- Profil dan Notifikasi -->
        <img class="w-8 h-8 rounded-full" src="https://via.placeholder.com/40" alt="Profile">
      </div>
    </div>
  </header>
  </template>
  
  <script setup>
  </script>
  