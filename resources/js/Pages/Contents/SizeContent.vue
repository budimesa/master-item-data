<template>
    <div>
      <DataTable :items="sizes" :columns="columns" @edit-item="editItem" @delete-item="deleteItem">
        <template #actions>
          <PrimaryButton @click="createItem">Add New</PrimaryButton>
        </template>
      </DataTable>
  
      <!-- Modal Edit-->
      <transition name="fade">
        <div v-if="isEditModalOpen" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" @click="closeEditModal">
          <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md" @click.stop>
            <h2 class="text-xl font-semibold mb-4">Edit Size</h2>
            <form @submit.prevent="update">
              <div class="mb-4">
                <label for="fg_width" class="block text-sm font-medium text-gray-700">FG Width</label>
                <input type="text" id="fg_width" v-model="currentSize.fg_width" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
              <div class="mb-4">
                <label for="fg_length" class="block text-sm font-medium text-gray-700">FG Length</label>
                <input type="text" id="fg_length" v-model="currentSize.fg_length" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
              <div class="mb-4">
                <label for="size_name" class="block text-sm font-medium text-gray-700">Size Name</label>
                <input type="text" id="size_name" v-model="currentSize.size_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
              <div class="mb-4">
                <label for="size_code" class="block text-sm font-medium text-gray-700">Size Code</label>
                <input type="text" id="size_code" v-model="currentSize.size_code" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></input type="text">
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
            <h2 class="text-xl font-semibold mb-4">Create New Size</h2>
            <form @submit.prevent="create">
                <div class="mb-4">
                  <div class="mb-4">
                  <label for="new_fg_width" class="block text-sm font-medium text-gray-700">FG Width</label>
                  <input type="text" id="new_fg_width" v-model="newSize.fg_width" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
                <div class="mb-4">
                  <label for="new_fg_length" class="block text-sm font-medium text-gray-700">FG Length</label>
                  <input type="text" id="new_fg_length" v-model="newSize.fg_length" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
                <label for="new_size_name" class="block text-sm font-medium text-gray-700">Size Name</label>
                <input type="text" id="new_size_name" v-model="newSize.size_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              </div>
              <div class="mb-4">
                <label for="new_size_code" class="block text-sm font-medium text-gray-700">Size Code</label>
                <input type="text" id="new_size_code" v-model="newSize.size_code" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></input type="text">
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
const currentSize = ref({ size_name: '', size_code: '', fg_width: '', fg_length: '' });
const newSize = ref({ size_name: '', size_code: '', fg_width: '', fg_length: '' });
const toast = useToast();
const sizes = ref([]);
const columns = ref([
  { key: 'size_name', label: 'Size Name' },
  { key: 'size_code', label: 'Size Code' },
  { key: 'fg_width', label: 'FG Width' },
  { key: 'fg_length', label: 'FG Length' },
]);

const fetchData = async () => {
  try {
    const response = await axios.get(route('sizes.index'));
    sizes.value = response.data.sizes;
  } catch (error) {
    console.error('Error fetching sizes:', error);
  }
};

onMounted(() => {
  fetchData();
});

const editItem = (data) => {
  currentSize.value = { ...data };
  isEditModalOpen.value = true;
};

const closeEditModal = () => (isEditModalOpen.value = false);

const createItem = () => {
  newSize.value = { size_name: '', size_code: '' };
  isCreateModalOpen.value = true;
};

const closeCreateModal = () => (isCreateModalOpen.value = false);

const update = async () => {
  const url = route('sizes.update', currentSize.value.id);
  try {
    const response = await axios.put(url, {
      size_name: currentSize.value.size_name,
      size_code: currentSize.value.size_code,
      fg_width: currentSize.value.fg_width,
      fg_length: currentSize.value.fg_length,
    });

    await fetchData(); 
    closeEditModal();
    toast.success("Update Size successfully");
  } catch (error) {
    console.error('Error updating Size:', error.response.data);
  }
};

const create = async () => {
  try {
    const response = await axios.post(route('sizes.store'), {
      size_name: newSize.value.size_name,
      size_code: newSize.value.size_code,
      fg_width: newSize.value.fg_width,
      fg_length: newSize.value.fg_length,
    });
    await fetchData()
    closeCreateModal();
    toast.success("Size created successfully");
  } catch (error) {
    console.error('Error creating Size:', error.response.data);
  }
};

const deleteItem = async (id) => {
  if (confirm('Are you sure you want to delete this item?')) {
    try {
      await axios.delete(`/sizes/${id}`);
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
