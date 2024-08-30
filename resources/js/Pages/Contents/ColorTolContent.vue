<template>
    <div>
      <DataTable :items="colorTols" :columns="columns" @edit-item="editItem" @delete-item="deleteItem">
        <template #actions>
          <PrimaryButton @click="createItem">Add New</PrimaryButton>
        </template>
      </DataTable>
  
      <!-- Modal Edit-->
      <transition name="fade">
        <div v-if="isEditModalOpen" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" @click="closeEditModal">
          <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md" @click.stop>
            <h2 class="text-xl font-semibold mb-4">Edit Color Tol</h2>
            <form @submit.prevent="update">
              <div class="mb-4">
                <label for="color_tol_name" class="block text-sm font-medium text-gray-700">Color Tol Name</label>
                <input type="text" id="color_tol_name" v-model="curentColorTols.color_tol_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
              <div class="mb-4">
                <label for="color_tol_code" class="block text-sm font-medium text-gray-700">Color Tol Code</label>
                <input type="text" id="color_tol_code" v-model="curentColorTols.color_tol_code" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></input type="text">
              </div>
              <div class="flex justify-end space-x-2">
                <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
                <button type="button" @click="closeEditModal" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </transition>

      <!-- Modal Create -->
      <transition name="fade">
        <div v-if="isCreateModalOpen" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" @click="closeCreateModal">
          <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md" @click.stop>
            <h2 class="text-xl font-semibold mb-4">Create New Color Tol</h2>
            <form @submit.prevent="create">
              <div class="mb-4">
                <label for="new_color_tol_name" class="block text-sm font-medium text-gray-700">Color Tol Name</label>
                <input type="text" id="new_color_tol_name" v-model="newColorTols.color_tol_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
              <div class="mb-4">
                <label for="new_color_tol_code" class="block text-sm font-medium text-gray-700">Color Tol Code</label>
                <input type="text" id="new_color_tol_code" v-model="newColorTols.color_tol_code" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></input type="text">
              </div>
              <div class="flex justify-end space-x-2">
                <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Create</button>
                <button type="button" @click="closeCreateModal" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </transition>
    </div>
  </template>
  
  <script setup>
import { defineProps, ref, onMounted } from 'vue';
import axios from 'axios';
import DataTable from '@/Components/DataTable.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useToast } from 'vue-toastification';

const isEditModalOpen = ref(false);
const isCreateModalOpen = ref(false);
const curentColorTols = ref({ color_tol_name: '', color_tol_code: '' });
const newColorTols = ref({ color_tol_name: '', color_tol_code: '' });
const toast = useToast();
const colorTols = ref([]);
const columns = ref([
  { key: 'color_tol_name', label: 'Color Tol Name' },
  { key: 'color_tol_code', label: 'Color Tol Code' }
]);

const fetchData = async () => {
  try {
    const response = await axios.get(route('color-tols.index'));
    colorTols.value = response.data.colorTols;
  } catch (error) {
    console.error('Error fetching color Tols:', error);
  }
};

onMounted(() => {
  fetchData();
});

const editItem = (data) => {
  curentColorTols.value = { ...data };
  isEditModalOpen.value = true;
};

const closeEditModal = () => (isEditModalOpen.value = false);

const createItem = () => {
  newColorTols.value = { color_tol_name: '', color_tol_code: '' };
  isCreateModalOpen.value = true;
};

const closeCreateModal = () => (isCreateModalOpen.value = false);

const update = async () => {
  const url = route('color-tols.update', curentColorTols.value.id);
  try {
    const response = await axios.put(url, {
      color_tol_name: curentColorTols.value.color_tol_name,
      color_tol_code: curentColorTols.value.color_tol_code,
    });

    await fetchData(); 
    closeEditModal();
    toast.success("Update Color Tol successfully");
  } catch (error) {
    console.error('Error updating Color Tol:', error.response.data);
  }
};

const create = async () => {
  try {
    const response = await axios.post(route('color-tols.store'), {
      color_tol_name: newColorTols.value.color_tol_name,
      color_tol_code: newColorTols.value.color_tol_code,
    });
    await fetchData()
    closeCreateModal();
    toast.success("Color Tol created successfully");
  } catch (error) {
    console.error('Error creating Color Tol:', error.response.data);
  }
};

const deleteItem = async (id) => {
  if (confirm('Are you sure you want to delete this item?')) {
    try {
      await axios.delete(`/color-tols/${id}`);
      await fetchData(); 
      toast.success("Item deleted successfully");
    } catch (error) {
      console.error('Failed to delete item:', error);
    }
  }
};
</script>
  
  <style scoped>
  /* Tambahkan CSS khusus untuk halaman jika diperlukan */
  </style>
