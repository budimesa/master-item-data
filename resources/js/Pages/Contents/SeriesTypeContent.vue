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
              :rowsPerPageOptions="[5, 10, 25, 50, 100]"
              currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries">
          
              <template #header>
                  <div class="flex flex-wrap gap-2 items-center justify-between">
                      <h4 class="m-0">Manage Series Types</h4>
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
            <Column field="series_type_name" header="Series Type Name" sortable style="min-width: 16rem"></Column>
            <Column field="series_type_code" header="Series Type Code" sortable style="min-width: 12rem"></Column>
            <Column field="created_at" header="Created At" sortable style="min-width: 12rem"></Column>
            <Column field="created_by" header="Created By" sortable style="min-width: 12rem"></Column>
            <Column field="updated_at" header="Update At" sortable style="min-width: 12rem"></Column>
            <Column field="updated_by" header="Update By" sortable style="min-width: 12rem"></Column>
            <Column :exportable="false" style="min-width: 12rem" header="Actions" alignFrozen="right" frozen>
            <template #body="slotProps">
                <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="edit(slotProps.data)" />
                <Button icon="pi pi-trash" outlined rounded severity="danger" @click="confirmDelete(slotProps.data)" />
            </template>
        </Column>
      </DataTable>
  </div>

    <Dialog v-model:visible="formDialog" :style="{ width: '450px' }" header="Series Type Details" :modal="true">
      <div class="flex flex-col gap-6">
        <div>
          <label for="series_type_name" class="block font-bold mb-3">Series Type Name</label>
          <InputText id="series_type_name" v-model.trim="item.series_type_name" required autofocus :invalid="submitted && !item.series_type_name" fluid />
          <small v-if="submitted && !item.series_type_name" class="text-red-500">Series Type Name is required.</small>
        </div>
        <div>
          <label for="series_type_code" class="block font-bold mb-3">Series Type Code</label>
          <InputText id="series_type_code" v-model="item.series_type_code" required fluid />
          <small v-if="submitted && !item.series_type_code" class="text-red-500">Series Type Code is required.</small>
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
              <span v-if="item">Are you sure you want to delete the selected Series Types?</span>
          </div>
          <template #footer>
              <Button label="No" icon="pi pi-times" text @click="deleteBulkDialog = false" />
              <Button label="Yes" icon="pi pi-check" text @click="deleteSelectedItems" />
          </template>
      </Dialog>
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
        const response = await axios.get(route('series-types.index'));
        items.value = response.data.seriesTypes;
    } catch (error) {
        console.error('Error fetching Series Types:', error);
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
    item.value = { series_type_name: '', series_type_code: '' };
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
  
  if (item.value.series_type_name.trim() && item.value.series_type_code.trim()) {
    try {
      if (isEditMode.value) {
        await axios.put(route('series-types.update', item.value.id), {
          series_type_name: item.value.series_type_name,
          series_type_code: item.value.series_type_code,
        });
        toast.add({ severity: 'success', summary: 'Success', detail: 'Series Type updated successfully', life: 3000 });
      } else {
        await axios.post(route('series-types.store'), {
          series_type_name: item.value.series_type_name,
          series_type_code: item.value.series_type_code,
        });
        toast.add({ severity: 'success', summary: 'Success', detail: 'Series Type created successfully', life: 3000 });
      }
      fetchData();
      hideDialog();
    } catch (error) {
      console.error('Error saving Series Type:', error.response.data);
      toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to save Series Type', life: 3000 });
    }
  }
};
const edit = (seriesTypeData) => {
  item.value = { ...seriesTypeData };
  submitted.value = false;
  isEditMode.value = true;
  formDialog.value = true;
};
const confirmDelete = (emp) => {
  item.value = emp;
  deleteDialog.value = true;
};
const deleteItem = async () => {
  await axios.delete(route('series-types.destroy', item.value.id));
  deleteDialog.value = false;
  fetchData();
  toast.add({severity:'success', summary: 'Successful', detail: 'Series Type Deleted', life: 3000});
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
  toast.add({severity:'success', summary: 'Successful', detail: 'Series Types Deleted', life: 3000});
};
</script>

<style scoped>


</style>