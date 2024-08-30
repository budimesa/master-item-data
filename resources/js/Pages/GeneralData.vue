<template>
  <dashboard-layout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">General Data</h1>        
      <!-- Card with Nav Tabs from Flowbite -->
      <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800" id="defaultTab" role="tablist">
          <li class="me-2">
            <button id="brand-tab" data-tabs-target="#brand" type="button" role="tab" aria-controls="brand" aria-selected="true" class="inline-block px-4 py-3 rounded-ss-lg tab-active" data-tab="brand">Brand</button>
          </li>
          <li class="me-2">
            <button id="color-tab" data-tabs-target="#color" type="button" role="tab" aria-controls="color" aria-selected="false" class="inline-block px-4 py-3 tab-inactive" data-tab="color">Color</button>
          </li>
          <li class="me-2">
            <button id="color-tol-tab" data-tabs-target="#color-tol" type="button" role="tab" aria-controls="color-tol" aria-selected="false" class="inline-block px-4 py-3 tab-inactive" data-tab="color-tol">Color Tol</button>
          </li>
          <li class="me-2">
            <button id="density-tab" data-tabs-target="#density" type="button" role="tab" aria-controls="density" aria-selected="false" class="inline-block px-4 py-3 tab-inactive" data-tab="density">Density</button>
          </li>
          <li class="me-2">
            <button id="item-type-tab" data-tabs-target="#item-type" type="button" role="tab" aria-controls="item-type" aria-selected="false" class="inline-block px-4 py-3 tab-inactive" data-tab="item-type">Item Type</button>
          </li>
          <li class="me-2">
            <button id="series-type-tab" data-tabs-target="#series-type" type="button" role="tab" aria-controls="series-type" aria-selected="false" class="inline-block px-4 py-3 tab-inactive" data-tab="series-type">Series Type</button>
          </li>
          <li class="me-2">
            <button id="size-tab" data-tabs-target="#size" type="button" role="tab" aria-controls="size" aria-selected="false" class="inline-block px-4 py-3 tab-inactive" data-tab="size">Size</button>
          </li>
          <li class="me-2">
            <button id="size-tol-tab" data-tabs-target="#size-tol" type="button" role="tab" aria-controls="size-tol" aria-selected="false" class="inline-block px-4 py-3 tab-inactive" data-tab="size-tol">Size Tol</button>
          </li>
        </ul>
        <div id="defaultTabContent">
          <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="brand" role="tabpanel" aria-labelledby="brand-tab">
            <BrandContent />
          </div>
          <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="color" role="tabpanel" aria-labelledby="color-tab">
            <!-- <ColorContent /> -->
          </div>
          <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="color-tol" role="tabpanel" aria-labelledby="color-tol-tab">
            <!-- <ColorTolContent /> -->
          </div>
          <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="density" role="tabpanel" aria-labelledby="density-tab">
            <!-- <DensityContent /> -->
          </div>
          <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="item-type" role="tabpanel" aria-labelledby="item-type-tab">
            <!-- <ItemTypeContent /> -->
          </div>
          <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="series-type" role="tabpanel" aria-labelledby="series-type-tab">
            <!-- <SeriesTypeContent /> -->
          </div>
          <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="size" role="tabpanel" aria-labelledby="size-tab">
            <!-- <SizeContent /> -->
          </div>
          <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="size-tol" role="tabpanel" aria-labelledby="size-tol-tab">
            <!-- <SizeTolContent /> -->
          </div>
        </div>
      </div>
    </div>
  </dashboard-layout>
</template>
  
  <script setup>
  import DashboardLayout from '@/Layouts/DashboardLayout.vue';
  import BrandContent from './Contents/BrandContent.vue';
  // import ColorContent from './Contents/ColorContent.vue';
  // import ColorTolContent from './Contents/ColorTolContent.vue';
  // import DensityContent from './Contents/DensityContent.vue';
  // import ItemTypeContent from './Contents/ItemTypeContent.vue';
  // import SizeContent from './Contents/SizeContent.vue';
  // import SizeTolContent from './Contents/SizeTolContent.vue';
  // import SeriesTypeContent from './Contents/SeriesTypeContent.vue';
  import { onMounted } from 'vue';
  
  onMounted(() => {
  // Get the last selected tab from localStorage
  const lastSelectedTab = localStorage.getItem('lastSelectedTab') || 'brand';

  // Function to handle tab switching
  const handleTabClick = (event) => {
    const targetTab = event.currentTarget.dataset.tab;

    // Hide all tab panels
    document.querySelectorAll('[role="tabpanel"]').forEach(panel => {
      panel.classList.add('hidden');
    });

    // Show the target panel
    const targetPanel = document.querySelector(`#${targetTab}`);
    if (targetPanel) {
      targetPanel.classList.remove('hidden');
    }

    // Remove active class from all tabs
    document.querySelectorAll('[role="tab"]').forEach(tab => {
      tab.classList.remove('tab-active');
      tab.classList.add('tab-inactive');
    });

    // Add active class to the clicked tab
    event.currentTarget.classList.add('tab-active');
    event.currentTarget.classList.remove('tab-inactive');

    // Save the selected tab to localStorage
    localStorage.setItem('lastSelectedTab', targetTab);
  }

  // Attach click event listeners to all tab buttons
  document.querySelectorAll('[data-tab]').forEach(button => {
    button.addEventListener('click', handleTabClick);
  });

  // Set the default tab as active
  const defaultTabButton = document.querySelector(`[data-tab="${lastSelectedTab}"]`);
  if (defaultTabButton) {
    defaultTabButton.click();
  }
});
  </script>
  <style scoped>
  /* Kelas untuk tab aktif */
  .tab-active {
    background-color: white;
    color: black; /* Teks putih untuk tab aktif */
    border-bottom: 2px solid #666; /* Garis bawah abu-abu untuk menunjukkan tab aktif */
  }
  
  /* Kelas untuk tab tidak aktif */
  .tab-inactive {
    /* background-color: #f5f5f5; Warna latar belakang terang untuk tab tidak aktif */
    color: white; /* Teks gelap untuk tab tidak aktif */
  }
  </style>
  