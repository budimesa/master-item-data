<template>
  <DashboardLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">General Data</h1>
      <Tabs :value="activeTab">
        <TabList>
          <Tab v-for="(tab, index) in tabs" :key="index" :value="index.toString()" @click="selectTab(index.toString())">
            {{ tab.name }}
          </Tab>
        </TabList>
        <TabPanels>
          <TabPanel v-for="(tab, index) in tabs" :key="index" :value="index.toString()">
            <component :is="tab.component" />
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

const tabs = ref([
  { name: 'Brand', component: BrandContent },
  { name: 'Color', component: ColorContent },
  { name: 'Color Tol', component: ColorTolContent },
  { name: 'Density', component: DensityContent },
  { name: 'Item Type', component: ItemTypeContent },
  { name: 'Series Type', component: SeriesTypeContent },
  { name: 'Size', component: SizeContent },
  { name: 'Size Tol', component: SizeTolContent },
  { name: 'Inventory Type', component: InventoryTypeContent },
]);

const getInitialTab = () => {
  const storedTab = localStorage.getItem('activeTab');
  return storedTab ? storedTab : '0'; // Default to '0' if no value is found
};

const activeTab = ref(getInitialTab());

const selectTab = (tabValue) => {
  activeTab.value = tabValue;
  localStorage.setItem('activeTab', tabValue); // Save selected tab to localStorage
};
</script>