<template>
    <DashboardLayout>
      <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">General Data</h1>        
        <Tabs :value="activeTab">
          <TabList>
            <Tab value="0" @click="selectTab('0')">Brand</Tab>
            <Tab value="1" @click="selectTab('1')">Color</Tab>
            <Tab value="2" @click="selectTab('2')">Color Tol</Tab>
            <Tab value="3" @click="selectTab('3')">Density</Tab>
            <Tab value="4" @click="selectTab('4')">Item Type</Tab>
            <Tab value="5" @click="selectTab('5')">Series Type</Tab>
            <Tab value="6" @click="selectTab('6')">Size</Tab>
            <Tab value="7" @click="selectTab('7')">Size Tol</Tab>
            <Tab value="8" @click="selectTab('8')">Inventory Type</Tab>
          </TabList>
          <TabPanels>
              <TabPanel value="0">
                <BrandContent />
              </TabPanel>
              <TabPanel value="1">
                <ColorContent />
              </TabPanel>
              <TabPanel value="2">
                <ColorTolContent />
              </TabPanel>
              <TabPanel value="3">
                <DensityContent />
              </TabPanel>
              <TabPanel value="4">
                <ItemTypeContent />
              </TabPanel>
              <TabPanel value="5">
                <SeriesTypeContent />
              </TabPanel>
              <TabPanel value="6">
                <SizeContent />
              </TabPanel>
              <TabPanel value="7">
                <SizeTolContent />
              </TabPanel>
              <TabPanel value="8">
                <InventoryTypeContent />
              </TabPanel>
          </TabPanels>
      </Tabs>
      </div>
    </DashboardLayout>
  </template>
  
  <script setup>
  import DashboardLayout from '@/Layouts/DashboardLayout.vue';
  import BrandContent from './Contents/BrandContent.vue';
  import ColorContent from './Contents/ColorContent.vue';
  import ColorTolContent from './Contents/ColorTolContent.vue';
  import ItemTypeContent from './Contents/ItemTypeContent.vue';
  import SizeContent from './Contents/SizeContent.vue';
  import SizeTolContent from './Contents/SizeTolContent.vue';
  import SeriesTypeContent from './Contents/SeriesTypeContent.vue';
  import InventoryTypeContent from './Contents/InventoryTypeContent.vue';
  import DensityContent from './Contents/DensityContent.vue';
  import { onMounted, ref } from 'vue';
  
  
  const getInitialTab = () => {
    const storedTab = localStorage.getItem('activeTab');
    return storedTab ? storedTab : '0'; // Default to '0' if no value is found
  };
  
  // Initialize activeTab from localStorage
  const activeTab = ref(getInitialTab());
  
  // Function to handle tab selection
  const selectTab = (tabValue) => {
    activeTab.value = tabValue;
    localStorage.setItem('activeTab', tabValue); // Save selected tab to localStorage
  };
  
  </script>
  