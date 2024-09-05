<template>
  <div class="card">
    <!-- DataTable Component -->
    <DataTable :value="items" :rows="rows">
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

    <!-- Paginator Component -->
    <Paginator
      :rows="rows"
      :totalRecords="totalRecords"
      :first="first"
      :rowsPerPageOptions="[10, 20, 30]"
      @page="handlePageChange"
    ></Paginator>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
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
    console.log('Fetching data for page:', page);
    const response = await axios.get(route('series-types.index'), {
      params: {
        page: page,
        per_page: pagination.value.per_page
      }
    });

    console.log('Response data:', response.data);

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
  console.log('Page changed to:', event.page + 1);
  fetchData(event.page + 1);
};

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
