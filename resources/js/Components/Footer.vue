<template>
  <div :class="['border-t', isDarkMode ? 'bg-gray-800 text-white' : 'bg-white text-black']">
    <div class="px-4 py-3 text-center">
      <span class="text-sm">© 2024 Your Company. All rights reserved.</span>
    </div>
  </div>
</template>

<script setup>
import { ref, inject } from 'vue';

const isDarkMode = inject('isDarkMode', ref(false));
</script>

<style scoped>
/* Gaya khusus untuk Footer jika diperlukan */
</style>
