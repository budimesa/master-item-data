<template>
  <div class="card mx-4">
      <Toolbar class="mb-6">
          <template #start>
              <Button label="New" icon="pi pi-plus" severity="success" class="mr-2" @click="openNew" />
              <!-- <Button label="Delete" icon="pi pi-trash" severity="danger" @click="confirmDeleteSelected" :disabled="!selectedItems || !selectedItems.length" /> -->
          </template>
          <template #end>
              <Button label="Export" icon="pi pi-upload" severity="help" @click="exportCSV($event)" />
          </template>
      </Toolbar>
      <DataTable ref="dt"
              v-model:selection="selectedItems"
              :value="items"
              dataKey="id"
              :paginator="true"
              :rows="10"
              :filters="filters"
              paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
              :rowsPerPageOptions="[5, 10, 25]"
              currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries">
          
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
            <!-- <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column> -->
            <Column field="id" header="ID" sortable style="min-width: 12rem"></Column>
            <Column field="qty_safty" header="Qty Safety" sortable style="min-width: 12rem"></Column>
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

    <!-- <Dialog v-model:visible="formDialog" :style="{ width: '450px' }" header="Brand Details" :modal="true">
      <div class="flex flex-col gap-6">
        <div>
          <label for="brand_name" class="block font-bold mb-3">Brand Name</label>
          <InputText id="brand_name" v-model.trim="item.brand_name" required autofocus :invalid="submitted && !item.brand_name" fluid />
          <small v-if="submitted && !item.brand_name" class="text-red-500">Brand Name is required.</small>
        </div>
        <div>
          <label for="brand_code" class="block font-bold mb-3">Brand Code</label>
          <InputText id="brand_code" v-model="item.brand_code" required fluid />
          <small v-if="submitted && !item.brand_code" class="text-red-500">Brand Code is required.</small>
        </div>
      </div>

      <template #footer>
        <Button label="Cancel" icon="pi pi-times" text @click="hideDialog" />
        <Button label="Save" icon="pi pi-check" @click="save" />
      </template>
    </Dialog>

      <Dialog v-model:visible="deleteDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
          <div class="flex items-center gap-4">
              <i class="pi pi-exclamation-triangle !text-3xl" />
              <span v-if="item"
                  >Are you sure you want to delete <b>{{ item.name }}</b
                  >?</span
              >
          </div>
          <template #footer>
              <Button label="No" icon="pi pi-times" text @click="deleteDialog = false" />
              <Button label="Yes" icon="pi pi-check" @click="deleteItem" />
          </template>
      </Dialog>

      <Dialog v-model:visible="deleteBulkDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
          <div class="flex items-center gap-4">
              <i class="pi pi-exclamation-triangle !text-3xl" />
              <span v-if="item">Are you sure you want to delete the selected brands?</span>
          </div>
          <template #footer>
              <Button label="No" icon="pi pi-times" text @click="deleteBulkDialog = false" />
              <Button label="Yes" icon="pi pi-check" text @click="deleteSelectedItems" />
          </template>
      </Dialog> -->
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from 'primevue/usetoast';
import axios from 'axios';

onMounted(() => {
  fetchData();
});

const fetchData = async () => {
    try {
        const response = await axios.get(route('item-datas.index'));
        items.value = response.data.data;
    } catch (error) {
        console.error('Error fetching brands:', error);
    }
};


const toast = useToast();
const dt = ref();
const items = ref([]);
const formDialog = ref(false);
const deleteDialog = ref(false);
const deleteBulkDialog = ref(false);
const item = ref({});
const selectedItems = ref([]);
const filters = ref({
  'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});
const submitted = ref(false);
const isEditMode = ref(false);

const openNew = () => {
    item.value = { brand_name: '', brand_code: '' };
    submitted.value = false;
    isEditMode.value = false;
    formDialog.value = true;
};
const hideDialog = () => {
  formDialog.value = false;
  submitted.value = false;
};
const save = async () => {
  submitted.value = true;
  
  if (item.value.brand_name.trim() && item.value.brand_code.trim()) {
    try {
      if (isEditMode.value) {
        await axios.put(route('item-datas.update', item.value.id), {
          brand_name: item.value.brand_name,
          brand_code: item.value.brand_code,
        });
        toast.add({ severity: 'success', summary: 'Success', detail: 'Brand updated successfully', life: 3000 });
      } else {
        await axios.post(route('item-datas.store'), {
          brand_name: item.value.brand_name,
          brand_code: item.value.brand_code,
        });
        toast.add({ severity: 'success', summary: 'Success', detail: 'Brand created successfully', life: 3000 });
      }
      fetchData();
      hideDialog();
    } catch (error) {
      console.error('Error saving brand:', error.response.data);
      toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to save brand', life: 3000 });
    }
  }
};
const edit = (brandData) => {
  item.value = { ...brandData };
  submitted.value = false;
  isEditMode.value = true;
  formDialog.value = true;
};
const confirmDelete = (emp) => {
  item.value = emp;
  deleteDialog.value = true;
};
const deleteItem = async () => {
  await axios.delete(route('item-datas.destroy', item.value.id));
  deleteDialog.value = false;
  fetchData();
  toast.add({severity:'success', summary: 'Successful', detail: 'Brand Deleted', life: 3000});
};

const exportCSV = () => {
  dt.value.exportCSV();
};
const confirmDeleteSelected = () => {
  deleteBulkDialog.value = true;
};
const deleteSelectedItems = () => {
  items.value = items.value.filter((val) => !selectedItems.value.includes(val));
  deleteBulkDialog.value = false;
  selectedItems.value = null;
  toast.add({severity:'success', summary: 'Successful', detail: 'Brands Deleted', life: 3000});
};
</script>

<style scoped>


</style>