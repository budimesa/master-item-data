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
      <DataTable :value="items" :rows="rows">
        <Column v-for="col in columns" :key="col.field" :field="col.field" :header="col.header" sortable style="min-width: 12rem"></Column>
              <Column field="id" header="ID" sortable style="min-width: 12rem"></Column>
              <Column field="qty_safety" header="Qty Safety" sortable style="min-width: 12rem"></Column>
              <Column field="safety_m" header="Safety M" sortable style="min-width: 12rem"></Column>
              <Column field="dol_trade" header="DOL Trade" sortable style="min-width: 12rem"></Column>
              <Column field="price_type" header="Price Type" sortable style="min-width: 12rem"></Column>
              <Column field="std_cost" header="Standard Cost" sortable style="min-width: 12rem"></Column>
              <Column field="durability" header="Durability" sortable style="min-width: 12rem"></Column>
              <Column field="unit_po" header="Unit PO" sortable style="min-width: 12rem"></Column>
              <Column field="vend_proc" header="Vendor Process" sortable style="min-width: 12rem"></Column>
              <Column field="unit_stk" header="Unit Stock" sortable style="min-width: 12rem"></Column>
              <Column field="item_name" header="Item Name" sortable style="min-width: 12rem"></Column>
              <Column field="item_code" header="Item Code" sortable style="min-width: 12rem"></Column>
              <Column field="item_spec" header="Item Spec" sortable style="min-width: 12rem"></Column>
              <Column field="unit_pr" header="Unit Price" sortable style="min-width: 12rem"></Column>
              <Column field="lead_time" header="Lead Time" sortable style="min-width: 12rem"></Column>
              <Column field="unit_prod" header="Unit Production" sortable style="min-width: 12rem"></Column>
              <Column field="series_type" header="Series Type" sortable style="min-width: 12rem"></Column>
              <Column field="unit_sales" header="Unit Sales" sortable style="min-width: 12rem"></Column>
              <Column field="phanton" header="Phanton" sortable style="min-width: 12rem"></Column>
              <Column field="unit_usg" header="Unit Usage" sortable style="min-width: 12rem"></Column>
              <Column field="qty_min" header="Quantity Min" sortable style="min-width: 12rem"></Column>
              <Column field="level_code" header="Level Code" sortable style="min-width: 12rem"></Column>
              <Column field="created_at" header="Created At" sortable style="min-width: 12rem"></Column>
              <Column field="created_by" header="Created By" sortable style="min-width: 12rem"></Column>
              <Column field="updated_at" header="Updated At" sortable style="min-width: 12rem"></Column>
              <Column field="updated_by" header="Updated By" sortable style="min-width: 12rem"></Column>
              <Column field="usage_to" header="Usage To" sortable style="min-width: 12rem"></Column>
              <Column field="plus_minus_percentage" header="Plus Minus Percentage" sortable style="min-width: 12rem"></Column>
              <Column field="standar_plus_minus" header="Standard Plus Minus" sortable style="min-width: 12rem"></Column>
              <Column field="kw_1_xx_percentage" header="KW 1 XX Percentage" sortable style="min-width: 12rem"></Column>
              <Column field="fixed_lot" header="Fixed Lot" sortable style="min-width: 12rem"></Column>
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
        <div class="mb-1">
          <div class="flex items-center mb-1">
            <label class="w-32 font-semibold">Item Code</label>
            <div class="flex-1">
              <InputText v-model.trim="item.item_code" class="w-full" required autofocus :invalid="submitted && !item.item_code" fluid/>
            </div>
          </div>
          <small v-if="submitted && !item.item_code" class="text-red-500 block mt-1 ml-32">Item Code is required.</small>
        </div>
      </div>
      <div class="col-span-4">
        <div class="mb-1">
          <div class="flex items-center mb-1">
            <label class="w-32 font-semibold">Unit STK</label>
            <div class="flex-1">
              <InputText v-model.trim="item.unit_stk" class="w-full" disabled/>
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-2">
        <div class="mb-1">
          <div class="flex items-center mb-1">
            <label class="w-32 font-semibold">Level Code</label>
            <div class="flex-1">
              <InputText v-model.trim="item.level_code" class="w-full" disabled />
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-2">
        <div class="mb-1">
          <div class="flex items-center mb-1">
            <label class="w-32 font-semibold">Unit Prod</label>
            <div class="flex-1">
              <InputText v-model.trim="item.unit_prod" class="w-full" disabled/>
            </div>
          </div>
        </div>
      </div>

      <!-- Row 2 (col-span-6) -->
      <div class="col-span-8">
        <div class="mb-1">
          <div class="flex items-center mb-1">
            <label class="w-32 font-semibold">Item Spec</label>
            <div class="flex-1">
              <InputText v-model.trim="item.item_spec" class="w-full" required autofocus :invalid="submitted && !item.item_spec" fluid/>
            </div>
          </div>
          <small v-if="submitted && !item.item_spec" class="text-red-500 block mt-1 ml-32">Item Spec is required.</small>
        </div>
      </div>
      <div class="col-span-2">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Unit PO</label>
          <InputText v-model.trim="item.unit_po" class="flex-1 w-full" disabled/>
        </div>
      </div>
      <div class="col-span-2">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Unit Sales</label>
          <InputText v-model.trim="item.unit_sales" class="flex-1 w-full" disabled/>
        </div>
      </div>

      <!-- Row 3 (col-span-6) -->
      <div class="col-span-8">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Item Name</label>
          <InputText v-model.trim="item.item_name" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-2">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Unit PR</label>
          <InputText v-model.trim="item.unit_pr" class="flex-1 w-full" disabled/>
        </div>
      </div>
      <div class="col-span-2">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Unit Usage</label>
          <InputText v-model.trim="item.unit_usg" class="flex-1 w-full"/>
        </div>
      </div>

      <!-- Row 4 DST -->
      <div class="col-span-4">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Seri. Type</label>
          <!-- <InputText v-model.trim="item.series_type" class="flex-1 w-full" /> -->
          <!-- <Dropdown 
            v-model="selectedSeriesType" 
            :options="seriesTypeOptions" 
            option-label="label" 
            option-value="value" 
            class="flex-1 w-full"
          /> -->
          <Select 
            v-model="selectedSeriesType" 
            :options="seriesTypeOptions" 
            filter 
            optionLabel="label" 
            placeholder="Select a Series Type" 
            class="flex-1 w-full md:w-56"
          >
            <template #value="slotProps">
              <div v-if="slotProps.value" class="flex items-center">                
                <div>{{ slotProps.value.label }}</div>
              </div>
              <span v-else>
                {{ slotProps.placeholder }}
              </span>
            </template>
            <template #option="slotProps">
              <div class="flex items-center">
                <div>{{ slotProps.option.label }}</div>
              </div>
            </template>
          </Select>
        </div>
      </div>
      <div class="col-span-4">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Seri. Name</label>
          <InputText v-model.trim="item.series_name" class="flex-1 w-full" disabled/>
        </div>
      </div>
      <div class="col-span-4">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Qty. Min</label>
          <InputText v-model.trim="item.qty_min" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Usage T.O</label>
          <InputText v-model.trim="item.usage_to" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Safety M.</label>
          <InputText v-model.trim="item.safety_m" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Lead Time</label>
          <InputText v-model.trim="item.lead_time" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Qty. Safety</label>
          <InputText v-model.trim="item.qty_safety" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Plus/Minus %</label>
          <InputText v-model.trim="item.plus_minus_percentage" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Durability</label>
          <InputText v-model.trim="item.durability" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="mb-1 flex items-center">
          <label class="w-32 font-semibold">Std. Plus/Minus</label>
          <InputText v-model.trim="item.standar_plus_minus" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="mb-1 flex items-center">
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
  </template>
  
  <script setup>
  import { ref, onMounted, watch, computed } from 'vue';
  import axios from 'axios';
  
  const items = ref([]);
  const item = ref({});
  const formDialog = ref(false);
  const rows = ref(10);
  const first = ref(0);
  const totalRecords = ref(0);
  const submitted = ref(false);
  const isEditMode = ref(false);
  
  const pagination = ref({
    total: 0,
    per_page: 10,
    current_page: 1,
    from: 1,
    last: 0
  });

  // Fungsi untuk memproses item_code
const processItemCode = (code) => {
  if (!code || typeof code !== 'string') return '';

  const parts = code.split('.');
  
  // Jika ada 3 bagian, format "0.XX.YYYY" atau "0.XX.ZZZ"
  if (parts.length === 3) {
    return parseInt(parts[1], 10); // Ambil dua digit pertama dan ubah menjadi angka
  }
  
  // Jika ada 2 bagian, format "RW.BO.006"
  if (parts.length === 2) {
    return parts[1]; // Ambil nilai BO dan kembalikan
  }

  // Format tidak dikenali
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
      fixed_lot: 0,
    };
    submitted.value = false;
    isEditMode.value = false;
    formDialog.value = true;
    fetchSeriesTypes();
 };

  const selectedSeriesType = ref(null);
  const seriesTypeOptions = ref([]);

  const fetchSeriesTypes = async () => {
    try {
      const response = await axios.get(route('series-types.index')); // Sesuaikan URL dengan endpoint Anda
      seriesTypeOptions.value = response.data.seriesTypes.map(type => ({
        label: type.series_type_code + ' | ' + type.series_type_name, // Untuk display di dropdown
        value: type.series_type_code,   // Nilai yang dipilih
      }));
    } catch (error) {
      console.error('Failed to fetch series types:', error);
    }
  };

 const hideDialog = () => {
  formDialog.value = false;
  submitted.value = false;
};
  

  const fetchData = async (page = 1) => {
    try {
      // console.log('Fetching data for page:', page);
      const response = await axios.get(route('raw-materials.index'), {
        params: {
          page: page,
          per_page: pagination.value.per_page
        }
      });
  
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

  const processedValue = computed(() => {
    if (!item.value.item_code) return '';

    // Pisahkan item_code berdasarkan titik ('.')
    const parts = item.value.item_code.split('.');

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
      } else if (parts[0] === 'RW' && parts.length === 3) {
        // Format "RW.BO.006"
        return parts[1]; // Ambil nilai BO dan kembalikan
      }
    }

    // Format tidak dikenali atau tidak sesuai dengan kriteria
    return '';
  });


  const save = async () => {
  submitted.value = true;

  const processedItemCode = processItemCode(item.value.item_code);
  
  if (item.value.item_code.trim() && item.value.item_spec.trim()) {
    try {
      if (isEditMode.value) {
        await axios.put(route('raw-materials.update', item.value.id), {
          item_code: item.value.item_code,
          item_spec: item.value.item_spec,
          item_name: item.value.item_name,
          qty_min: item.value.qty_min,
          usage_to: item.value.usage_to,
          safety_m: item.value.safety_m,
          lead_time: item.value.lead_time,
          qty_safety: item.value.qty_safety,
          plus_minus_percentage: item.value.plus_minus_percentage,
          durability: item.value.durability,
          standar_plus_minus: item.value.standar_plus_minus,
          unit_stk: item.value.unit_stk,
          level_code: item.value.level_code,
          unit_prod: item.value.unit_prod,
          unit_po: item.value.unit_po,
          unit_pr: item.value.unit_pr,
          unit_sales: item.value.unit_sales,
          unit_usg: item.value.unit_usg,
        });
        toast.add({ severity: 'success', summary: 'Success', detail: 'Color updated successfully', life: 3000 });
      } else {
        await axios.post(route('raw-materials.store'), {
          item_code: item.value.item_code,
          item_spec: item.value.item_spec,
          item_name: item.value.item_name,
          qty_min: item.value.qty_min,
          usage_to: item.value.usage_to,
          safety_m: item.value.safety_m,
          lead_time: item.value.lead_time,
          qty_safety: item.value.qty_safety,
          plus_minus_percentage: item.value.plus_minus_percentage,
          durability: item.value.durability,
          standar_plus_minus: item.value.standar_plus_minus,
          unit_stk: item.value.unit_stk,
          level_code: item.value.level_code,
          unit_prod: item.value.unit_prod,
          unit_po: item.value.unit_po,
          unit_pr: item.value.unit_pr,
          unit_sales: item.value.unit_sales,
          unit_usg: item.value.unit_usg,
          dol_trade: '',
          series_type: item.value.series_type,
          phanton: 'Y',
          std_cost: 0,
          vend_proc: processedItemCode.toString() // Update item_code with processed value
        });
        toast.add({ severity: 'success', summary: 'Success', detail: 'Color created successfully', life: 3000 });
      }
      fetchData();
      hideDialog();
    } catch (error) {
      console.error('Error saving color:', error.response.data);
      toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to save color', life: 3000 });
    }
  }
};


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
  