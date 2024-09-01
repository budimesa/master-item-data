<template>
  <div :class="{ 'dark': isDarkMode.value, 'light': !isDarkMode.value }">
    <slot />
  </div>
</template>

<script setup>
import { ref, provide, onMounted } from 'vue';

// State untuk mode gelap
const isDarkMode = ref(false);

// Toggle tema
const toggleTheme = () => {
  isDarkMode.value = !isDarkMode.value;
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark');
    localStorage.setItem('theme', 'dark');
  } else {
    document.documentElement.classList.remove('dark');
    localStorage.setItem('theme', 'light');
  }
};

// Provide theme state and toggle function
provide('isDarkMode', isDarkMode);
provide('toggleTheme', toggleTheme);

// Memeriksa preferensi tema saat komponen dimuat
onMounted(() => {
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme === 'dark') {
    isDarkMode.value = true;
    document.documentElement.classList.add('dark');
  } else {
    isDarkMode.value = false;
    document.documentElement.classList.remove('dark');
  }
});
</script>

<style scoped>
/* Gaya umum untuk ThemeProvider jika diperlukan */
</style>
