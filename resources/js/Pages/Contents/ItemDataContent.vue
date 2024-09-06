<template>
  <div class="card">
    <!-- DataTable Component -->
    <DataTable :value="items" :rows="rows">
      <Column v-for="col in columns" :key="col.field" :field="col.field" :header="col.header" sortable style="min-width: 12rem"></Column>
            <Column field="id" header="ID" sortable style="min-width: 12rem"></Column>
            <Column field="qty_safety" header="Qty Safety" sortable style="min-width: 12rem"></Column>
            <Column field="safety_m" header="Safety M" sortable style="min-width: 12rem"></Column>
            <Column field="dol_trade" header="DOL Trade" sortable style="min-width: 12rem"></Column>
            <Column field="price_type" header="Price Type" sortable style="min-width: 12rem"></Column>
            <Column field="std_cost" header="Standard Cost" sortable style="min-width: 12rem"></Column>
            <Column field="qty_std_l" header="Qty Std L" sortable style="min-width: 12rem"></Column>
            <Column field="durability" header="Durability" sortable style="min-width: 12rem"></Column>
            <Column field="qty_pack" header="Qty Pack" sortable style="min-width: 12rem"></Column>
            <Column field="std_wgt" header="Standard Weight" sortable style="min-width: 12rem"></Column>
            <Column field="size_code" header="Size Code" sortable style="min-width: 12rem"></Column>
            <Column field="unit_po" header="Unit PO" sortable style="min-width: 12rem"></Column>
            <Column field="vend_proc" header="Vendor Process" sortable style="min-width: 12rem"></Column>
            <Column field="unit_stk" header="Unit Stock" sortable style="min-width: 12rem"></Column>
            <Column field="item_name" header="Item Name" sortable style="min-width: 12rem"></Column>
            <Column field="item_code" header="Item Code" sortable style="min-width: 12rem"></Column>
            <Column field="item_type" header="Item Type" sortable style="min-width: 12rem"></Column>
            <Column field="item_spec" header="Item Spec" sortable style="min-width: 12rem"></Column>
            <Column field="brand_code" header="Brand Code" sortable style="min-width: 12rem"></Column>
            <Column field="unit_pr" header="Unit Price" sortable style="min-width: 12rem"></Column>
            <Column field="lead_time" header="Lead Time" sortable style="min-width: 12rem"></Column>
            <Column field="clr_tol_code" header="Color Tolerance Code" sortable style="min-width: 12rem"></Column>
            <Column field="unit_prod" header="Unit Production" sortable style="min-width: 12rem"></Column>
            <Column field="item_grade" header="Item Grade" sortable style="min-width: 12rem"></Column>
            <Column field="series_type" header="Series Type" sortable style="min-width: 12rem"></Column>
            <Column field="unit_sales" header="Unit Sales" sortable style="min-width: 12rem"></Column>
            <Column field="phanton" header="Phanton" sortable style="min-width: 12rem"></Column>
            <Column field="unit_usg" header="Unit Usage" sortable style="min-width: 12rem"></Column>
            <Column field="color_code" header="Color Code" sortable style="min-width: 12rem"></Column>
            <Column field="density_code" header="Density Code" sortable style="min-width: 12rem"></Column>
            <Column field="size_tol_code" header="Size Tolerance Code" sortable style="min-width: 12rem"></Column>
            <Column field="qty_min" header="Quantity Min" sortable style="min-width: 12rem"></Column>
            <Column field="level_code" header="Level Code" sortable style="min-width: 12rem"></Column>
            <Column field="created_by" header="Created By" sortable style="min-width: 12rem"></Column>
            <Column field="updated_by" header="Updated By" sortable style="min-width: 12rem"></Column>
            <Column field="usage_to" header="Usage To" sortable style="min-width: 12rem"></Column>
            <Column field="plus_minus_percentage" header="Plus Minus Percentage" sortable style="min-width: 12rem"></Column>
            <Column field="standar_plus_minus" header="Standard Plus Minus" sortable style="min-width: 12rem"></Column>
            <Column field="kw_1_xx_percentage" header="KW 1 XX Percentage" sortable style="min-width: 12rem"></Column>

            <Column :exportable="false" style="min-width: 12rem" header="Actions" alignFrozen="right" frozen>
            <template #body="slotProps">
                <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="edit(slotProps.data)" />
                <Button icon="pi pi-trash" outlined rounded severity="danger" @click="confirmDelete(slotProps.data)" />
            </template>
          </Column>
    </DataTable>

    <!-- Paginator Component -->
    <Paginator
      v-model:rows="rows"
      :totalRecords="totalRecords"
      :first="first"
      :rowsPerPageOptions="[10, 20, 30]"
      @page="handlePageChange"
    ></Paginator>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

const items = ref([]);
const rows = ref(10);
const first = ref(0);
const totalRecords = ref(0);

const pagination = ref({
  total: 0,
  per_page: 10,
  current_page: 1,
  from: 1,
  last: 0
});

const fetchData = async (page = 1) => {
  try {
    // console.log('Fetching data for page:', page);
    const response = await axios.get(route('item-datas.index'), {
      params: {
        page: page,
        per_page: pagination.value.per_page
      }
    });

    items.value = response.data.data;
    pagination.value = {
      total: response.data.total,
      per_page: response.data.per_page,
      current_page: response.data.current_page,
      from: response.data.from,
      last: response.data.last_page
    };

    totalRecords.value = response.data.total;
    first.value = (pagination.value.current_page - 1) * pagination.value.per_page;
  } catch (error) {
    console.error('Error fetching data:', error);
  }
};

const handlePageChange = (event) => {
  // console.log('Page changed to:', event.page + 1);
  fetchData(event.page + 1);
};

// const handleRowsPerPageChange = (event) => {
//   console.log('Rows per page changed to:', event.rows);
//   pagination.value.per_page = event.rows;
//   fetchData(1); // Fetch data for the first page with the new per_page value
// };

// Watch for changes in rows
watch(rows, (newValue) => {
  console.log('Rows per page changed to:', newValue);
  pagination.value.per_page = newValue;
  fetchData(1); // Fetch data for the first page with the new per_page value
});

onMounted(() => {
  fetchData();
});
</script>

<style>
.card {
  padding: 20px;
}
</style>

<style>
.card {
  padding: 20px;
}
</style>
