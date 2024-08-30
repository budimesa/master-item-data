<template>
  <div>
    <DataTable
      :items="itemDatas"
      :columns="columns"
      :totalPages="totalPages"
      :totalItems="totalItems"
      :currentPage="currentPage"
      @update:pageChange="handlePageChange"
      @update:itemsPerPage="handleItemsPerPageChange"
    >
      <template #actions>
        <PrimaryButton @click="createItem">Add New</PrimaryButton>
      </template>
    </DataTable>
  </div>
</template>
  
  <script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import DataTable from '@/Components/DataTable2.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const itemDatas = ref([]);
const currentPage = ref(1);
const totalPages = ref(1);
const totalItems = ref(0);
const itemsPerPage = ref(10); // Default items per page

const columns = ref([
  { key: 'qty_safty', label: 'Qty Safety' },
  { key: 'safety_m', label: 'Safety M' },
  { key: 'dol_trade', label: 'DOL Trade' },
  { key: 'price_type', label: 'Price Type' },
  { key: 'std_cost', label: 'Standard Cost' },
  { key: 'qty_std_l', label: 'Qty Std L' },
  { key: 'durability', label: 'Durability' },
  { key: 'qty_pack', label: 'Qty Pack' },
  { key: 'std_wgt', label: 'Standard Weight' },
  { key: 'size_code', label: 'Size Code' },
  { key: 'unit_po', label: 'Unit PO' },
  { key: 'vend_proc', label: 'Vendor Process' },
  { key: 'unit_stk', label: 'Unit Stock' },
  { key: 'item_name', label: 'Item Name' },
  { key: 'item_code', label: 'Item Code' },
  { key: 'item_type', label: 'Item Type' },
  { key: 'item_spec', label: 'Item Spec' },
  { key: 'brand_code', label: 'Brand Code' },
  { key: 'unit_pr', label: 'Unit Price' },
  { key: 'lead_time', label: 'Lead Time' },
  { key: 'clr_tol_code', label: 'Color Tolerance Code' },
  { key: 'unit_prod', label: 'Unit Production' },
  { key: 'item_grade', label: 'Item Grade' },
  { key: 'series_type', label: 'Series Type' },
  { key: 'unit_sales', label: 'Unit Sales' },
  { key: 'phanton', label: 'Phanton' },
  { key: 'unit_usg', label: 'Unit Usage' },
  { key: 'color_code', label: 'Color Code' },
  { key: 'density_code', label: 'Density Code' },
  { key: 'size_tol_code', label: 'Size Tolerance Code' },
  { key: 'qty_min', label: 'Quantity Min' },
  { key: 'level_code', label: 'Level Code' },
  { key: 'created_by', label: 'Created By' },
  { key: 'updated_by', label: 'Updated By' },
  { key: 'usage_to', label: 'Usage To' },
  { key: 'plus_minus_percentage', label: 'Plus Minus Percentage' },
  { key: 'standar_plus_minus', label: 'Standard Plus Minus' },
  { key: 'kw_1_xx_percentage', label: 'KW 1 XX Percentage' }
]);

const fetchData = async (page = 1, perPage = 10) => {
  try {
    const response = await axios.get(route('item-datas.index', { page, perPage }));
    itemDatas.value = response.data.data; // Data item untuk halaman ini
    totalPages.value = response.data.last_page; // Total halaman
    totalItems.value = response.data.total; // Total item
  } catch (error) {
    console.error('Error fetching Item Data:', error);
  }
};


const handlePageChange = (page) => {
  if (page > 0 && page <= totalPages.value) {
    currentPage.value = page;
    fetchData(currentPage.value, itemsPerPage.value); 
  }
};

const handleItemsPerPageChange = (newItemsPerPage) => {
  itemsPerPage.value = newItemsPerPage;
  currentPage.value = 1; // Reset ke halaman 1 saat mengubah jumlah item per halaman
  fetchData(currentPage.value, itemsPerPage.value); // Fetch data dengan jumlah item baru
};

onMounted(() => {
  fetchData(currentPage.value, itemsPerPage.value);
});
</script>
  
  <style scoped>
  /* Tambahkan CSS khusus untuk halaman jika diperlukan */
  </style>
