<template>
  <div class="card mx-4">
    <Toolbar class="mb-6">
      <template #start>
        <Button label="New" icon="pi pi-plus" severity="success" class="mr-2" @click="openNew" />
      </template>
      <template #end>
        <Button label="Export" icon="pi pi-upload" severity="help" @click="exportCSV($event)" />
      </template>
    </Toolbar>
    <DataTable
      ref="dt"
      v-model:selection="selectedItems"
      :value="items"
      dataKey="id"
      :paginator="true"
      :rows="10" 
      :totalRecords="120"
      :filters="filters"
      :paginatorTemplate="paginatorTemplate"
      :rowsPerPageOptions="[5, 10, 25, 50, 100]"
      currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
      @update:rows="updateRows"
      @page="handlePageChange"
    >
      <template #header>
        <div class="flex flex-wrap gap-2 items-center justify-between">
          <h4 class="m-0">Manage Brands</h4>
          <IconField>
            <InputIcon>
              <i class="pi pi-search" />
            </InputIcon>
            <InputText v-model="filters['global'].value" placeholder="Search..." />
          </IconField>
        </div>
      </template>
      <!-- Columns definition -->
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
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from 'primevue/usetoast';
import axios from 'axios';

const rows = ref(10); // Default rows per page
const first = ref(0); // Index of the first record on the current page
const totalRecords = ref(0); // Total number of records
const currentPage = ref(1); // Current page number
const rowsPerPageOptions = [5, 10, 25]; // Options for rows per page
const paginatorTemplate = 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown';

const items = ref([]);
const selectedItems = ref([]);
const filters = ref({
  'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});
const toast = useToast();

onMounted(() => {
  fetchData();
});

const fetchData = async () => {
  try {
    const response = await axios.get(route('item-datas.index'), {
      params: {
        perPage: rows.value,
        first: first.value,
      },
    });
    items.value = response.data.data;
    totalRecords.value = response.data.total; // Assuming response includes total count
    console.log(totalRecords.value);
  } catch (error) {
    console.error('Error fetching brands:', error);
  }
};

const updateRows = (newRows) => {
  rows.value = newRows;
  fetchData();
};

const handlePageChange = (event) => {
  first.value = event.first;
  currentPage.value = event.page + 1; // PrimeVue page is 0-based
  fetchData();
};

watch([rows, first], () => {
  fetchData();
});

const openNew = () => {
  item.value = { brand_name: '', brand_code: '' };
  submitted.value = false;
  isEditMode.value = false;
  formDialog.value = true;
};

const edit = (data) => {
  item.value = { ...data };
  isEditMode.value = true;
  formDialog.value = true;
};

const confirmDelete = (data) => {
  // Implementation for delete confirmation
};

const exportCSV = (event) => {
  // Implementation for CSV export
};

</script>

<style scoped>
/* Add your styles here */
</style>


<!-- safety_m	            decimal(4,2)	true	false	[NULL]	0		[NULL]	
std_cost	            decimal(18,2)	true	false	[NULL]	0		[NULL]	
qty_std_l	            decimal(18,2)	true	false	[NULL]	0		[NULL]	
durability	            decimal(18,0)	true	false	[NULL]	0		[NULL]	
qty_pack	            decimal(18,2)	true	false	[NULL]	0		[NULL]	
std_wgt	                decimal(18,2)	true	false	[NULL]	0		[NULL]	
lead_time	            decimal(4,2)	true	false	[NULL]	0		[NULL]	
qty_min	                decimal(18,2)	true	false	[NULL]	0		[NULL]	
plus_minus_percentage	decimal(18,0)	true	false	[NULL]	0		[NULL]	
standar_plus_minus	    decimal(18,0)	true	false	[NULL]	0		[NULL]	
kw_1_xx_percentage	    decimal(18,0)	true	false	[NULL]	0		[NULL]	
qty_safety	            decimal(18,6)	false	false	[NULL]	NULL    [NULL]	
fixed_lot   	        decimal(18,6)	true	false	[NULL]	0		[NULL] -->