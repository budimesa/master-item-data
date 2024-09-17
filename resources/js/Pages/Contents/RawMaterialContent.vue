<template>
    <div class="card">
     <Toolbar class="mb-6">
          <template #start>
              <Button label="New" icon="pi pi-plus" severity="success" class="mr-2" @click="openNew" />
              <!-- <Button label="Delete" icon="pi pi-trash" severity="danger" @click="confirmDeleteSelected" :disabled="!selectedItems || !selectedItems.length" /> -->
          </template>
          <template #end>
              <Button label="Export" icon="pi pi-upload" severity="help" @click="exportCSV($event)" />
          </template>
      </Toolbar>
      <!-- DataTable Component -->
        <DataTable v-model:filters="filters" :value="items" :rows="rows" dataKey="id" filterDisplay="row"
              :reorderableColumns="true">
              <!-- <Column v-for="col in columns" :key="col.field" :field="col.field" :header="col.header" style="min-width: 12rem"></Column> -->
              <Column header="No." style="min-width: 4rem">
                  <template #body="{ index }">
                      {{ pagination.offset + index + 1 }}
                  </template>
              </Column>
              <Column field="item_code" header="Item Code" style="min-width: 12rem">
                  <template #body="{ data }">
                      {{ data.item_code }}
                  </template>
                  <template #filter="{ filterModel, filterCallback }">
                      <InputText v-model="filterModel.value" type="text" @input="filterCallback()" placeholder="Search by code" />
                  </template>
              </Column>
              <Column field="item_name" header="Item Name" style="min-width: 12rem">
                <template #body="{ data }">
                    {{ data.item_name }}
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" placeholder="Search by name" />
                </template>
              </Column>
              <Column field="item_spec" header="Item Spec" style="min-width: 12rem"></Column>
              <Column field="qty_safety" header="Qty Safety" style="min-width: 12rem"></Column>
              <Column field="safety_m" header="Safety M" style="min-width: 12rem"></Column>
              <Column field="dol_trade" header="DOL Trade" style="min-width: 12rem"></Column>
              <Column field="price_type" header="Price Type" style="min-width: 12rem"></Column>
              <Column field="std_cost" header="Standard Cost" style="min-width: 12rem"></Column>
              <Column field="durability" header="Durability" style="min-width: 12rem"></Column>
              <Column field="unit_po" header="Unit PO" style="min-width: 12rem"></Column>
              <Column field="vend_proc" header="Vendor Process" style="min-width: 12rem"></Column>
              <Column field="unit_stk" header="Unit Stock" style="min-width: 12rem"></Column>
              <Column field="unit_pr" header="Unit Price" style="min-width: 12rem"></Column>
              <Column field="lead_time" header="Lead Time" style="min-width: 12rem"></Column>
              <Column field="unit_prod" header="Unit Production" style="min-width: 12rem"></Column>
              <Column field="series_type" header="Series Type" style="min-width: 12rem"></Column>
              <Column field="unit_sales" header="Unit Sales" style="min-width: 12rem"></Column>
              <Column field="phanton" header="Phanton" style="min-width: 12rem"></Column>
              <Column field="unit_usg" header="Unit Usage" style="min-width: 12rem"></Column>
              <Column field="qty_min" header="Quantity Min" style="min-width: 12rem"></Column>
              <Column field="level_code" header="Level Code" style="min-width: 12rem"></Column>
              <Column field="created_at" header="Created At" style="min-width: 12rem"></Column>
              <Column field="created_by" header="Created By" style="min-width: 12rem"></Column>
              <Column field="updated_at" header="Updated At" style="min-width: 12rem"></Column>
              <Column field="updated_by" header="Updated By" style="min-width: 12rem"></Column>
              <Column field="usage_to" header="Usage To" style="min-width: 12rem"></Column>
              <Column field="plus_minus_percentage" header="Plus Minus Percentage" style="min-width: 12rem"></Column>
              <Column field="standar_plus_minus" header="Standard Plus Minus" style="min-width: 12rem"></Column>
              <Column field="kw_1_xx_percentage" header="KW 1 XX Percentage" style="min-width: 12rem"></Column>
              <Column field="fixed_lot" header="Fixed Lot" style="min-width: 12rem"></Column>
              <Column :exportable="false" style="min-width: 12rem" header="Actions" alignFrozen="right" frozen>
              <template #body="slotProps">
                  <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="edit(slotProps.data)" />
                  <Button icon="pi pi-trash" outlined rounded severity="danger" @click="confirmDelete(slotProps.data)" />
              </template>
            </Column>
      </DataTable>
  
      <!-- Paginator Component -->
      <Paginator
        v-model:rows="rows"
        :totalRecords="totalRecords"
        :first="first"
        :rowsPerPageOptions="[10, 20, 30]"
        @page="handlePageChange"
      ></Paginator>
    </div>

    <Dialog v-model:visible="formDialog" modal header="Raw Material Details" :modal="true" :style="{ width: '80rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
      <div class="grid grid-cols-12 gap-4 mt-1">
      <!-- Row 1 -->
      <div class="col-span-4">
          <div class="flex items-center">
            <label class="w-32 font-semibold">Item Code</label>
            <div class="flex-1">
              <InputText v-model.trim="item.item_code" class="w-full" required autofocus :invalid="submitted && !item.item_code" fluid/>
            </div>
          </div>
          <small v-if="submitted && !item.item_code" class="text-red-500 block mt-1 ml-32">Item Code is required.</small>
      </div>
      <div class="col-span-4">
          <div class="flex items-center">
            <label class="w-32 font-semibold">Unit STK</label>
            <div class="flex-1">
              <InputText v-model.trim="item.unit_stk" class="w-full" disabled/>
            </div>
          </div>
      </div>
      <div class="col-span-2">
          <div class="flex items-center">
            <label class="w-32 font-semibold">Level Code</label>
            <div class="flex-1">
              <InputText v-model.trim="item.level_code" class="w-full" disabled />
            </div>
          </div>
      </div>
      <div class="col-span-2">
          <div class="flex items-center">
            <label class="w-32 font-semibold">Unit Prod</label>
            <div class="flex-1">
              <InputText v-model.trim="item.unit_prod" class="w-full" disabled/>
            </div>
          </div>
      </div>

      <!-- Row 2 (col-span-6) -->
      <div class="col-span-8">
          <div class="flex items-center">
            <label class="w-32 font-semibold">Item Spec</label>
            <div class="flex-1">
              <InputText v-model.trim="item.item_spec" class="w-full" required autofocus :invalid="submitted && !item.item_spec" fluid/>
            </div>
          </div>
          <small v-if="submitted && !item.item_spec" class="text-red-500 block mt-1 ml-32">Item Spec is required.</small>
      </div>
      <div class="col-span-2">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Unit PO</label>
          <InputText v-model.trim="item.unit_po" class="flex-1 w-full" disabled/>
        </div>
      </div>
      <div class="col-span-2">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Unit Sales</label>
          <InputText v-model.trim="item.unit_sales" class="flex-1 w-full" disabled/>
        </div>
      </div>

      <!-- Row 3 (col-span-6) -->
      <div class="col-span-8">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Item Name</label>
          <InputText v-model.trim="item.item_name" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-2">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Unit PR</label>
          <InputText v-model.trim="item.unit_pr" class="flex-1 w-full" disabled/>
        </div>
      </div>
      <div class="col-span-2">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Unit Usage</label>
          <InputText v-model.trim="item.unit_usg" class="flex-1 w-full"/>
        </div>
      </div>

      <!-- Row 4 DST -->
      <div class="col-span-8">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Seri. Type</label>
          <multiselect
            class="flex-1 w-full md:w-56 custom-multiselect border border-surface-300 dark:border-surface-700 rounded-md bg-surface-100 dark:bg-surface-800 text-surface-800 dark:text-surface-200"
            v-model="selectedSeriesType"
            :options="seriesTypeOptions"
            :searchable="true"
            :closeOnSelect="true"
            :clearOnSelect="true"
            placeholder=""
            label="label"
            track-by="code"
          />
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Qty. Min</label>
          <InputText v-model.trim="item.qty_min" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Usage T.O</label>
          <InputText v-model.trim="item.usage_to" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Safety M.</label>
          <InputText v-model.trim="item.safety_m" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Lead Time</label>
          <InputText v-model.trim="item.lead_time" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Qty. Safety</label>
          <InputText v-model.trim="item.qty_safety" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Plus/Minus %</label>
          <InputText v-model.trim="item.plus_minus_percentage" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Durability</label>
          <InputText v-model.trim="item.durability" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Std. Plus/Minus</label>
          <InputText v-model.trim="item.standar_plus_minus" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Fixed Lot</label>
          <InputText v-model.trim="item.fixed_lot" class="flex-1 w-full" />
        </div>
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
  </template>
  
  <script setup>
  import { ref, onMounted, watch, computed } from 'vue';
  import { FilterMatchMode } from '@primevue/core/api';
  import axios from 'axios';
  import Multiselect from 'vue-multiselect'
  import { useToast } from 'primevue/usetoast';
  import { debounce } from 'lodash';

  
  const items = ref([]);
  const item = ref({});
  const formDialog = ref(false);
  const deleteDialog = ref(false);
  const rows = ref(10);
  const first = ref(0);
  const totalRecords = ref(0);
  const submitted = ref(false);
  const isEditMode = ref(false);
  const toast = useToast();
  const inventoryTypeId = 8 // id inventory type raw material
  const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    item_code: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    item_name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  });

  // Create a debounced function for filtering
  const debouncedFilter = debounce((filters) => {
    fetchData(1); // Fetch data for the first page when filters change
  }, 300); // Adjust the delay as needed

  // // Watch for changes in filters and call the debounced function
  watch(filters, (newFilters) => {
    debouncedFilter(newFilters);
  }, { deep: true });  
  
  const pagination = ref({
    total: 0,
    per_page: 10,
    current_page: 1,
    from: 1,
    last: 0,
    offset: 0, 
  });

  // Fungsi untuk memproses item_code
  const processItemCode = (code) => {
    if (!code) return '';
    
    // Pisahkan item_code berdasarkan titik ('.')
    const parts = code.split('.');
    
    // Periksa apakah item_code dimulai dengan '0' atau 'RW'
    if (parts.length > 0 && (parts[0] === '0' || parts[0] === 'RW')) {
      // Jika format dimulai dengan '0'
      if (parts[0] === '0') {
        // Periksa apakah bagian kedua adalah '45'
        if (parts.length === 3 && parts[1] === '45') {
          // Jika ya, kembalikan '43'
          return '43';
        }
        // Jika format "0.XX.YYYY" atau "0.XX.ZZZ"
        if (parts.length === 3) {
          return parseInt(parts[1], 10); // Ambil nilai XX dan ubah menjadi angka
        }
      } 
      else if (parts[0] === 'RW' && parts.length === 3) {
          return parts[1]; // Ambil nilai BO dan kembalikan
        }
      }
      // Format tidak dikenali atau tidak sesuai dengan kriteria
      return '';
  };

  const openNew = () => {
    item.value = { 
      item_code: '',
      item_spec: '',
      dol_trade: '',
      std_cost: 0,
      series_type: '',
      series_name: '',
      item_name: '',
      qty_min: 0,
      usage_to: 0,
      safety_m: 0,
      lead_time: 0,
      qty_safety: 0, 
      plus_minus_percentage: 0,
      durability: 0,
      standar_plus_minus: 0,
      unit_stk: 'KG',
      level_code: 'N',
      unit_prod: 'KG',
      unit_po: 'KG',
      unit_pr: 'KG',
      unit_sales: 'KG',
      unit_usg: 'KG',
      phanton: 'Y',
      st_cost: 0,
      fixed_lot: 0,
    };
    selectedSeriesType.value = {label: '', code: ''};
    submitted.value = false;
    isEditMode.value = false;
    formDialog.value = true;
    fetchSeriesTypes(inventoryTypeId);
  };

  const selectedSeriesType = ref({label: '', code: ''});
  const seriesTypeOptions = ref([]);
  const fetchSeriesTypes = async (inventoryTypeId) => {
    try {
        const response = await axios.get(route('series-types-by-inventory-type'), {
            params: {
                inventory_type_id: inventoryTypeId
            }
        });
        seriesTypeOptions.value = response.data.seriesTypes.map(type => ({
          label: (type.series_type_code.trimEnd() + ' | ' + type.series_type_name), // Untuk display di dropdown
          code: type.series_type_code.trimEnd(), // Nilai yang dipilih
        }));
    } catch (error) {
        console.error('Failed to fetch series types:', error);
    }
}

 const hideDialog = () => {
  formDialog.value = false;
  submitted.value = false;
};
  

  const fetchData = async (page = 1) => {
    try {
      const response = await axios.get(route('raw-materials.index'), {
        params: {
          page: page,
          per_page: pagination.value.per_page,
          filters: filters.value
        }
      });
  
      items.value = response.data.data;
      pagination.value = {
        total: response.data.total,
        per_page: response.data.per_page,
        current_page: response.data.current_page,
        from: response.data.from,
        last: response.data.last_page,
        offset: response.data.offset,
      };
  
      totalRecords.value = response.data.total;
      first.value = (pagination.value.current_page - 1) * pagination.value.per_page;
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  };
  
  const handlePageChange = (event) => {
    fetchData(event.page + 1);
  };
  
  // Watch for changes in rows
  watch(rows, (newValue) => {
    pagination.value.per_page = newValue;
    fetchData(1); // Fetch data for the first page with the new per_page value
  });
  
  onMounted(() => {
    fetchData();
  });
  const save = async () => {
    submitted.value = true;
    const processedItemCode = processItemCode(item.value.item_code);
    
    if (item.value.item_code.trim() && item.value.item_spec.trim()) {
      try {
        if (isEditMode.value) {
          await axios.put(route('raw-materials.update', item.value.id), {
            ...item.value, // Mengambil semua nilai dari item.value
            series_type: selectedSeriesType.value.code.toString(),
            vend_proc: processedItemCode.toString()
          });
          toast.add({ severity: 'success', summary: 'Success', detail: 'Raw Material updated successfully', life: 3000 });
        } else {
          await axios.post(route('raw-materials.store'), {
            ...item.value, // Mengambil semua nilai dari item.value
            series_type: selectedSeriesType.value.code.toString(),
            vend_proc: processedItemCode.toString() 
          });
          toast.add({ severity: 'success', summary: 'Success', detail: 'Raw Material created successfully', life: 3000 });
        }
        fetchData();
        hideDialog();
      } catch (error) {
        console.error('Error saving raw material:', error.response.data);
        // toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to save raw material', life: 3000 });
      }
    }
  };

  const edit = async (rawMaterialData) => {
    await fetchSeriesTypes(inventoryTypeId); // Tunggu hingga data selesai di-fetch
    item.value = { ...rawMaterialData };
    // Check if series_type is empty or not
    if (item.value.series_type === '' || item.value.series_type === null) {
      selectedSeriesType.value = { label: '', code: '' };
    } else {
      const selectedOption = seriesTypeOptions.value.find(option => option.code.trim() === item.value.series_type.trim());
      if (selectedOption) {
        selectedSeriesType.value = selectedOption;
      }
    }

    submitted.value = false;
    isEditMode.value = true;
    formDialog.value = true;
  };

  const confirmDelete = (emp) => {
    item.value = emp;
    deleteDialog.value = true;
  };
  const deleteItem = async () => {
    await axios.delete(route('raw-materials.destroy', item.value.id));
    deleteDialog.value = false;
    fetchData();
    toast.add({severity:'success', summary: 'Successful', detail: 'Raw Material Deleted', life: 3000});
  };
  </script>
  
  <style>
  .card {
    padding: 20px;
  }
  </style>
