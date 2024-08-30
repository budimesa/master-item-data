<template>
    <div>
      <DataTable :items="sizeTols" :columns="columns" @edit-item="editItem" @delete-item="deleteItem">
        <template #actions>
          <PrimaryButton @click="createItem">Add New</PrimaryButton>
        </template>
      </DataTable>
  
      <!-- Modal Edit-->
      <transition name="fade">
        <div v-if="isEditModalOpen" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" @click="closeEditModal">
          <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md" @click.stop>
            <h2 class="text-xl font-semibold mb-4">Edit Size Tols</h2>
            <form @submit.prevent="update">
              <div class="mb-4">
                <label for="size_tol_name" class="block text-sm font-medium text-gray-700">Size Tols Name</label>
                <input type="text" id="size_tol_name" v-model="currentSizeTol.size_tol_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
              <div class="mb-4">
                <label for="size_tol_code" class="block text-sm font-medium text-gray-700">Size Tols Code</label>
                <input type="text" id="size_tol_code" v-model="currentSizeTol.size_tol_code" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></input type="text">
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
            <h2 class="text-xl font-semibold mb-4">Create New Size Tols</h2>
            <form @submit.prevent="create">
              <div class="mb-4">
                <label for="new_size_tol_name" class="block text-sm font-medium text-gray-700">Size Tols Name</label>
                <input type="text" id="new_size_tol_name" v-model="newSizeTol.size_tol_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
              <div class="mb-4">
                <label for="new_size_tol_code" class="block text-sm font-medium text-gray-700">Size Tols Code</label>
                <input type="text" id="new_size_tol_code" v-model="newSizeTol.size_tol_code" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></input type="text">
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
const currentSizeTol = ref({ size_tol_name: '', size_tol_code: '' });
const newSizeTol = ref({ size_tol_name: '', size_tol_code: '' });
const toast = useToast();
const sizeTols = ref([]);
const columns = ref([
  { key: 'size_tol_name', label: 'Size Tols Name' },
  { key: 'size_tol_code', label: 'Size Tols Code' }
]);

const fetchData = async () => {
  try {
    const response = await axios.get(route('size-tols.index'));
    sizeTols.value = response.data.sizeTols;
  } catch (error) {
    console.error('Error fetching sizeTols:', error);
  }
};

onMounted(() => {
  fetchData();
});

const editItem = (data) => {
  currentSizeTol.value = { ...data };
  isEditModalOpen.value = true;
};

const closeEditModal = () => (isEditModalOpen.value = false);

const createItem = () => {
  newSizeTol.value = { size_tol_name: '', size_tol_code: '' };
  isCreateModalOpen.value = true;
};

const closeCreateModal = () => (isCreateModalOpen.value = false);

const update = async () => {
  const url = route('size-tols.update', currentSizeTol.value.id);
  try {
    const response = await axios.put(url, {
      size_tol_name: currentSizeTol.value.size_tol_name,
      size_tol_code: currentSizeTol.value.size_tol_code,
    });

    await fetchData(); 
    closeEditModal();
    toast.success("Update Size Tols successfully");
  } catch (error) {
    console.error('Error updating Size Tols:', error.response.data);
  }
};

const create = async () => {
  try {
    const response = await axios.post(route('size-tols.store'), {
      size_tol_name: newSizeTol.value.size_tol_name,
      size_tol_code: newSizeTol.value.size_tol_code,
    });
    await fetchData()
    closeCreateModal();
    toast.success("Size Tols created successfully");
  } catch (error) {
    console.error('Error creating Size Tols:', error.response.data);
  }
};

const deleteItem = async (id) => {
  if (confirm('Are you sure you want to delete this item?')) {
    try {
      await axios.delete(`/size-tols/${id}`);
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
