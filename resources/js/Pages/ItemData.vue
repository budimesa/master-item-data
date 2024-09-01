<template>
    <DashboardLayout>
      <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Item Data</h1>        
        <Tabs value="0">
          <TabList>
              <Tab value="0">Brand</Tab>
              <Tab value="1">Color</Tab>
              <Tab value="2">Color Tol</Tab>
              <Tab value="3">Density</Tab>
              <Tab value="4">Item Type</Tab>
              <Tab value="5">Series Type</Tab>
              <Tab value="6">Size</Tab>
              <Tab value="7">Size Tol</Tab>
          </TabList>
          <TabPanels>
              <TabPanel value="0">
                <BrandContent />
              </TabPanel>
              <TabPanel value="1">
              </TabPanel>
              <TabPanel value="2">
              </TabPanel>
              <TabPanel value="3">
              </TabPanel>
              <TabPanel value="4">
              </TabPanel>
              <TabPanel value="5">
              </TabPanel>
              <TabPanel value="6">
              </TabPanel>
              <TabPanel value="7">
              </TabPanel>
          </TabPanels>
      </Tabs>
      </div>
    </DashboardLayout>
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
  </script>
  