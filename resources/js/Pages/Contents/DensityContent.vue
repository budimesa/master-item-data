<template>
    <div>
      <DataTable :items="densities" :columns="columns" @edit-item="editItem" @delete-item="deleteItem">
        <template #actions>
          <PrimaryButton @click="createItem">Add New</PrimaryButton>
        </template>
      </DataTable>
  
      <!-- Modal Edit-->
      <transition name="fade">
        <div v-if="isEditModalOpen" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" @click="closeEditModal">
          <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md" @click.stop>
            <h2 class="text-xl font-semibold mb-4">Edit Density</h2>
            <form @submit.prevent="update">
              <div class="mb-4">
                <label for="density_name" class="block text-sm font-medium text-gray-700">Density Name</label>
                <input type="text" id="density_name" v-model="currentDensity.density_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
              <div class="mb-4">
                <label for="density_code" class="block text-sm font-medium text-gray-700">Density Code</label>
                <input type="text" id="density_code" v-model="currentDensity.density_code" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></input type="text">
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
            <h2 class="text-xl font-semibold mb-4">Create New Density</h2>
            <form @submit.prevent="create">
              <div class="mb-4">
                <label for="new_density_name" class="block text-sm font-medium text-gray-700">Density Name</label>
                <input type="text" id="new_density_name" v-model="newDensity.density_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
              <div class="mb-4">
                <label for="new_density_code" class="block text-sm font-medium text-gray-700">Density Code</label>
                <input type="text" id="new_density_code" v-model="newDensity.density_code" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></input type="text">
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
const currentDensity = ref({ density_name: '', density_code: '' });
const newDensity = ref({ density_name: '', density_code: '' });
const toast = useToast();
const densities = ref([]);
const columns = ref([
  { key: 'density_name', label: 'Density Name' },
  { key: 'density_code', label: 'Density Code' }
]);

const fetchData = async () => {
  try {
    const response = await axios.get(route('densities.index'));
    densities.value = response.data.densities;
  } catch (error) {
    console.error('Error fetching densities:', error);
  }
};

onMounted(() => {
  fetchData();
});

const editItem = (data) => {
  currentDensity.value = { ...data };
  isEditModalOpen.value = true;
};

const closeEditModal = () => (isEditModalOpen.value = false);

const createItem = () => {
  newDensity.value = { density_name: '', density_code: '' };
  isCreateModalOpen.value = true;
};

const closeCreateModal = () => (isCreateModalOpen.value = false);

const update = async () => {
  const url = route('densities.update', currentDensity.value.id);
  try {
    const response = await axios.put(url, {
      density_name: currentDensity.value.density_name,
      density_code: currentDensity.value.density_code,
    });

    await fetchData(); 
    closeEditModal();
    toast.success("Update Density successfully");
  } catch (error) {
    console.error('Error updating Density:', error.response.data);
  }
};

const create = async () => {
  try {
    const response = await axios.post(route('densities.store'), {
      density_name: newDensity.value.density_name,
      density_code: newDensity.value.density_code,
    });
    await fetchData()
    closeCreateModal();
    toast.success("Density created successfully");
  } catch (error) {
    console.error('Error creating Density:', error.response.data);
  }
};

const deleteItem = async (id) => {
  if (confirm('Are you sure you want to delete this item?')) {
    try {
      await axios.delete(`/densities/${id}`);
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
