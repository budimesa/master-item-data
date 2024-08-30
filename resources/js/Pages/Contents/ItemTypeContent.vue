<template>
    <div>
      <DataTable :items="itemTypes" :columns="columns" @edit-item="editItem" @delete-item="deleteItem">
        <template #actions>
          <PrimaryButton @click="createItem">Add New</PrimaryButton>
        </template>
      </DataTable>
  
      <!-- Modal Edit-->
      <transition name="fade">
        <div v-if="isEditModalOpen" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" @click="closeEditModal">
          <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md" @click.stop>
            <h2 class="text-xl font-semibold mb-4">Edit Item Type</h2>
            <form @submit.prevent="update">
              <div class="mb-4">
                <label for="type_name" class="block text-sm font-medium text-gray-700">Item Type Name</label>
                <input type="text" id="type_name" v-model="currentItemType.type_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
              <div class="mb-4">
                <label for="type_code" class="block text-sm font-medium text-gray-700">Item Type Code</label>
                <input type="text" id="type_code" v-model="currentItemType.type_code" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></input type="text">
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
            <h2 class="text-xl font-semibold mb-4">Create New Item Type</h2>
            <form @submit.prevent="create">
              <div class="mb-4">
                <label for="new_type_name" class="block text-sm font-medium text-gray-700">Item Type Name</label>
                <input type="text" id="new_type_name" v-model="newItemType.type_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
              <div class="mb-4">
                <label for="new_type_code" class="block text-sm font-medium text-gray-700">Item Type Code</label>
                <input type="text" id="new_type_code" v-model="newItemType.type_code" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></input type="text">
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
const currentItemType = ref({ type_name: '', type_code: '' });
const newItemType = ref({ type_name: '', type_code: '' });
const toast = useToast();
const itemTypes = ref([]);
const columns = ref([
  { key: 'type_name', label: 'Item Type Name' },
  { key: 'type_code', label: 'Item Type Code' }
]);

const fetchData = async () => {
  try {
    const response = await axios.get(route('item-types.index'));
    itemTypes.value = response.data.itemTypes;
  } catch (error) {
    console.error('Error fetching itemTypes:', error);
  }
};

onMounted(() => {
  fetchData();
});

const editItem = (data) => {
  currentItemType.value = { ...data };
  isEditModalOpen.value = true;
};

const closeEditModal = () => (isEditModalOpen.value = false);

const createItem = () => {
  newItemType.value = { type_name: '', type_code: '' };
  isCreateModalOpen.value = true;
};

const closeCreateModal = () => (isCreateModalOpen.value = false);

const update = async () => {
  const url = route('item-types.update', currentItemType.value.id);
  try {
    const response = await axios.put(url, {
      type_name: currentItemType.value.type_name,
      type_code: currentItemType.value.type_code,
    });

    await fetchData(); 
    closeEditModal();
    toast.success("Update Item Type successfully");
  } catch (error) {
    console.error('Error updating Item Type:', error.response.data);
  }
};

const create = async () => {
  try {
    const response = await axios.post(route('item-types.store'), {
      type_name: newItemType.value.type_name,
      type_code: newItemType.value.type_code,
    });
    await fetchData()
    closeCreateModal();
    toast.success("Item Type created successfully");
  } catch (error) {
    console.error('Error creating Item Type:', error.response.data);
  }
};

const deleteItem = async (id) => {
  if (confirm('Are you sure you want to delete this item?')) {
    try {
      await axios.delete(`/itemTypes/${id}`);
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
