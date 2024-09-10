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
        <Column v-for="col in columns" :key="col.field" :field="col.field" :header="col.header" style="min-width: 12rem"></Column>
              <Column field="id" header="ID" style="min-width: 12rem"></Column>
              <Column field="std_cost" header="Standard Cost" sortable style="min-width: 12rem"></Column>
              <Column field="qty_pack" header="Qty Pack" sortable style="min-width: 12rem"></Column>
              <Column field="std_wgt" header="Standard Weight" sortable style="min-width: 12rem"></Column>
              <Column field="size_code" header="Size Code" sortable style="min-width: 12rem"></Column>
              <Column field="unit_po" header="Unit PO" sortable style="min-width: 12rem"></Column>
              <Column field="vend_proc" header="Vendor Process" sortable style="min-width: 12rem"></Column>
              <Column field="unit_stk" header="Unit Stock" sortable style="min-width: 12rem"></Column>
              <Column field="item_name" header="Item Name" sortable style="min-width: 12rem"></Column>
              <Column field="item_code" header="Item Code" sortable style="min-width: 12rem"></Column>
              <Column field="item_spec" header="Item Spec" sortable style="min-width: 12rem"></Column>
              <Column field="brand_code" header="Brand Code" sortable style="min-width: 12rem"></Column>
              <Column field="unit_pr" header="Unit Price" sortable style="min-width: 12rem"></Column>
              <Column field="unit_prod" header="Unit Production" sortable style="min-width: 12rem"></Column>
              <Column field="series_type" header="Series Type" sortable style="min-width: 12rem"></Column>
              <Column field="unit_sales" header="Unit Sales" sortable style="min-width: 12rem"></Column>
              <Column field="phanton" header="Phanton" sortable style="min-width: 12rem"></Column>
              <Column field="unit_usg" header="Unit Usage" sortable style="min-width: 12rem"></Column>
              <Column field="color_code" header="Color Code" sortable style="min-width: 12rem"></Column>
              <Column field="density_code" header="Density Code" sortable style="min-width: 12rem"></Column>
              <Column field="level_code" header="Level Code" sortable style="min-width: 12rem"></Column>
              <Column field="created_at" header="Created At" sortable style="min-width: 12rem"></Column>
              <Column field="created_by" header="Created By" sortable style="min-width: 12rem"></Column>
              <Column field="updated_at" header="Updated At" sortable style="min-width: 12rem"></Column>
              <Column field="updated_by" header="Updated By" sortable style="min-width: 12rem"></Column>
              <Column field="plus_minus_percentage" header="Plus Minus Percentage" sortable style="min-width: 12rem"></Column>
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

    <Dialog v-model:visible="formDialog" modal header="WFG Details" :modal="true" :style="{ width: '80rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
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
          <label class="w-32 font-semibold">Qty. Pack</label>
          <InputText v-model.trim="item.qty_pack" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-8">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Brand Code</label>
          <multiselect
            class="flex-1 w-full md:w-56 custom-multiselect border border-surface-300 dark:border-surface-700 rounded-md bg-surface-100 dark:bg-surface-800 text-surface-800 dark:text-surface-200"
            v-model="selectedBrand"
            :options="brandOptions"
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
          <label class="w-32 font-semibold">Std. Weight</label>
          <InputText v-model.trim="item.std_wgt" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-8">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Size Code</label>
          <InputText v-model.trim="item.size_code" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Plus/Minus %</label>
          <InputText v-model.trim="item.plus_minus_percentage" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-8">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Color Code</label>
          <InputText v-model.trim="item.color_code" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Fixed Lot</label>
          <InputText v-model.trim="item.fixed_lot" class="flex-1 w-full" />
        </div>
      </div>
      <div class="col-span-8">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Density Code</label>
          <InputText v-model.trim="item.density_code" class="flex-1 w-full" />
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
  import axios from 'axios';
  import Multiselect from 'vue-multiselect'
  import { useToast } from 'primevue/usetoast';
  
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

  const pagination = ref({
    total: 0,
    per_page: 10,
    current_page: 1,
    from: 1,
    last: 0
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
    fetchSeriesTypes();
    fetchBrands();
  };

  const selectedSeriesType = ref({label: '', code: ''});
  const seriesTypeOptions = ref([]);
  const fetchSeriesTypes = async () => {
      try {
        const response = await axios.get(route('series-types.index'));
        seriesTypeOptions.value = response.data.seriesTypes.map(type => ({
          label: (type.series_type_code.trimEnd() + ' | ' + type.series_type_name), // Untuk display di dropdown
          code: type.series_type_code.trimEnd(), // Nilai yang dipilih
        }));
      } catch (error) {
        console.error('Failed to fetch series types:', error);
      }
  };

  const selectedBrand = ref({label: '', code: ''});
  const brandOptions = ref([]);
  const fetchBrands = async () => {
      try {
        const response = await axios.get(route('brands.index'));
        brandOptions.value = response.data.brands.map(brand => ({
          label: (brand.brand_code.trimEnd() + ' | ' + brand.brand_name), // Untuk display di dropdown
          code: brand.brand_code.trimEnd(), // Nilai yang dipilih
        }));
        console.log(brandOptions.value)
      } catch (error) {
        console.error('Failed to fetch brands:', error);
      }
  };

  const selectedSize = ref({label: '', code: ''});
  const sizeOptions = ref([]);

  const fetchSizes = async () => {
      try {
          const response = await axios.get(route('sizes.index'));
          sizeOptions.value = response.data.sizes.map(size => ({
              label: (size.size_code.trimEnd() + ' | ' + size.size_name), // Untuk display di dropdown
              code: size.size_code.trimEnd(), // Nilai yang dipilih
          }));
      } catch (error) {
          console.error('Failed to fetch sizes:', error);
      }
  };

  const selectedColor = ref({label: '', code: ''});
const colorOptions = ref([]);

const fetchColors = async () => {
    try {
        const response = await axios.get(route('colors.index'));
        colorOptions.value = response.data.colors.map(color => ({
            label: (color.color_code.trimEnd() + ' | ' + color.color_name), // Untuk display di dropdown
            code: color.color_code.trimEnd(), // Nilai yang dipilih
        }));
    } catch (error) {
        console.error('Failed to fetch colors:', error);
    }
};

const selectedDensity = ref({label: '', code: ''});
const densityOptions = ref([]);

const fetchDensities = async () => {
    try {
        const response = await axios.get(route('densities.index'));
        densityOptions.value = response.data.densities.map(density => ({
            label: (density.density_code.trimEnd() + ' | ' + density.density_name), // Untuk display di dropdown
            code: density.density_code.trimEnd(), // Nilai yang dipilih
        }));
    } catch (error) {
        console.error('Failed to fetch densities:', error);
    }
};



 const hideDialog = () => {
  formDialog.value = false;
  submitted.value = false;
};
  

  const fetchData = async (page = 1) => {
    try {
      const response = await axios.get(route('wfgs.index'), {
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
  const save = async () => {
    submitted.value = true;
    const processedItemCode = processItemCode(item.value.item_code);
    
    if (item.value.item_code.trim() && item.value.item_spec.trim()) {
      try {
        if (isEditMode.value) {
          await axios.put(route('wfgs.update', item.value.id), {
            ...item.value, // Mengambil semua nilai dari item.value
            series_type: selectedSeriesType.value.code.toString(),
            vend_proc: processedItemCode.toString()
          });
          toast.add({ severity: 'success', summary: 'Success', detail: 'WFG updated successfully', life: 3000 });
        } else {
          await axios.post(route('wfgs.store'), {
            ...item.value, // Mengambil semua nilai dari item.value
            series_type: selectedSeriesType.value.code.toString(),
            vend_proc: processedItemCode.toString() 
          });
          toast.add({ severity: 'success', summary: 'Success', detail: 'WFG created successfully', life: 3000 });
        }
        fetchData();
        hideDialog();
      } catch (error) {
        console.error('Error saving WFG:', error.response.data);
        // toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to save WFG', life: 3000 });
      }
    }
  };

  const edit = async (WFGData) => {
    await fetchSeriesTypes(); // Tunggu hingga data selesai di-fetch
    item.value = { ...WFGData };
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
    await axios.delete(route('wfgs.destroy', item.value.id));
    deleteDialog.value = false;
    fetchData();
    toast.add({severity:'success', summary: 'Successful', detail: 'WFG Deleted', life: 3000});
  };
  </script>
  
  <style>
  .card {
    padding: 20px;
  }
  </style>
