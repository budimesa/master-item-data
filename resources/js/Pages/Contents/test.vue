<template>
  <div class="card mx-4">
    <!-- Toolbar and DataTable here -->

    <Dialog v-model:visible="brandDialog" :style="{ width: '450px' }" header="Brand Details" :modal="true">
      <div class="flex flex-col gap-6">
        <div>
          <label for="brand_name" class="block font-bold mb-3">Brand Name</label>
          <InputText id="brand_name" v-model.trim="brand.brand_name" required autofocus :invalid="submitted && !brand.brand_name" fluid />
          <small v-if="submitted && !brand.brand_name" class="text-red-500">Brand Name is required.</small>
        </div>
        <div>
          <label for="brand_code" class="block font-bold mb-3">Brand Code</label>
          <InputText id="brand_code" v-model="brand.brand_code" required fluid />
          <small v-if="submitted && !brand.brand_code" class="text-red-500">Brand Code is required.</small>
        </div>
      </div>

      <template #footer>
        <Button label="Cancel" icon="pi pi-times" text @click="hideDialog" />
        <Button label="Save" icon="pi pi-check" @click="save" />
      </template>
    </Dialog>

    <!-- Other Dialogs here -->
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from 'primevue/usetoast';
import axios from 'axios';

const toast = useToast();
const dt = ref();
const brands = ref([]);
const brandDialog = ref(false);
const deleteDialog = ref(false);
const deleteBulkDialog = ref(false);
const brand = ref({});
const selectedItems = ref([]);
const filters = ref({
  'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});
const submitted = ref(false);
const isEditMode = ref(false);

onMounted(() => {
  fetchData();
});

const fetchData = async () => {
  try {
    const response = await axios.get(route('brands.index'));
    brands.value = response.data.brands;
  } catch (error) {
    console.error('Error fetching brands:', error);
  }
};

const openNew = () => {
  brand.value = { brand_name: '', brand_code: '' };
  submitted.value = false;
  isEditMode.value = false;
  brandDialog.value = true;
};

const edit = (brandData) => {
  brand.value = { ...brandData };
  submitted.value = false;
  isEditMode.value = true;
  brandDialog.value = true;
};

const hideDialog = () => {
  brandDialog.value = false;
  submitted.value = false;
  brand.value = {};
};

const save = async () => {
  submitted.value = true;
  
  if (brand.value.brand_name.trim() && brand.value.brand_code.trim()) {
    try {
      if (isEditMode.value) {
        await axios.put(route('brands.update', brand.value.id), {
          brand_name: brand.value.brand_name,
          brand_code: brand.value.brand_code,
        });
        toast.add({ severity: 'success', summary: 'Success', detail: 'Brand updated successfully', life: 3000 });
      } else {
        await axios.post(route('brands.store'), {
          brand_name: brand.value.brand_name,
          brand_code: brand.value.brand_code,
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

const confirmDelete = (brandData) => {
  brand.value = brandData;
  deleteDialog.value = true;
};

const deleteItem = async () => {
  try {
    await axios.delete(route('brands.destroy', brand.value.id));
    brands.value = brands.value.filter(val => val.id !== brand.value.id);
    deleteDialog.value = false;
    toast.add({ severity: 'success', summary: 'Success', detail: 'Brand deleted successfully', life: 3000 });
  } catch (error) {
    console.error('Error deleting brand:', error.response.data);
    toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to delete brand', life: 3000 });
  }
};

const confirmDeleteSelected = () => {
  deleteBulkDialog.value = true;
};


const deleteSelectedItems = async () => {
  try {
    const ids = selectedItems.value.map(item => item.id);
    await axios.post(route('brands.bulk-delete'), { ids });
    brands.value = brands.value.filter(val => !selectedItems.value.includes(val));
    deleteBulkDialog.value = false;
    selectedItems.value = [];
    toast.add({ severity: 'success', summary: 'Success', detail: 'Brands deleted successfully', life: 3000 });
  } catch (error) {
    console.error('Error deleting selected brands:', error.response.data);
    toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to delete selected brands', life: 3000 });
  }
};

const exportCSV = () => {
  dt.value.exportCSV();
};
</script>
