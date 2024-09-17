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
              <Column header="#" style="min-width: 4rem">
                  <template #body="{ index }">
                      {{ index + 1 }}
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
              <Column field="price_type" header="Price Type" style="min-width: 12rem"></Column>
              <Column field="std_cost" header="Standard Cost" style="min-width: 12rem"></Column>
              <Column field="qty_pack" header="Qty Pack" style="min-width: 12rem"></Column>
              <Column field="std_wgt" header="Standard Weight" style="min-width: 12rem"></Column>
              <Column field="size_code" header="Size Code" style="min-width: 12rem"></Column>
              <Column field="unit_po" header="Unit PO" style="min-width: 12rem"></Column>
              <Column field="vend_proc" header="Vendor Process" style="min-width: 12rem"></Column>
              <Column field="unit_stk" header="Unit Stock" style="min-width: 12rem"></Column>
              <Column field="brand_code" header="Brand Code" style="min-width: 12rem"></Column>
              <Column field="unit_pr" header="Unit Price" style="min-width: 12rem"></Column>
              <Column field="unit_prod" header="Unit Production" style="min-width: 12rem"></Column>
              <Column field="series_type" header="Series Type" style="min-width: 12rem"></Column>
              <Column field="unit_sales" header="Unit Sales" style="min-width: 12rem"></Column>
              <Column field="phanton" header="Phanton" style="min-width: 12rem"></Column>
              <Column field="unit_usg" header="Unit Usage" style="min-width: 12rem"></Column>
              <Column field="color_code" header="Color Code" style="min-width: 12rem"></Column>
              <Column field="color_tol_code" header="Color Tol Code" style="min-width: 12rem"></Column>
              <Column field="size_tol_code" header="Size Tol Code" style="min-width: 12rem"></Column>
              <Column field="density_code" header="Density Code" style="min-width: 12rem"></Column>
              <Column field="level_code" header="Level Code" style="min-width: 12rem"></Column>
              <Column field="created_at" header="Created At" style="min-width: 12rem"></Column>
              <Column field="created_by" header="Created By" style="min-width: 12rem"></Column>
              <Column field="updated_at" header="Updated At" style="min-width: 12rem"></Column>
              <Column field="updated_by" header="Updated By" style="min-width: 12rem"></Column>
              <Column field="kw_1_xx_percentage" header="Plus Minus Percentage" style="min-width: 12rem"></Column>
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

    <Dialog v-model:visible="formDialog" modal header="FG Details" :modal="true" :style="{ width: '80rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
      <div class="grid grid-cols-12 gap-4 mt-1">
      <!-- Row 1 -->
      <div class="col-span-4">
          <div class="flex items-center">
            <label class="w-32 font-semibold">Item Code</label>
            <div class="flex-1">
              <InputText v-model.trim="item.item_code" class="w-full" required @blur="validateAndProcessInput" fluid/>
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
              <InputText v-model.trim="item.item_spec" class="w-full" required fluid/>
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
          <label class="w-32 font-semibold">Brand</label>
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
      <div class="col-span-8">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Density</label>
          <multiselect
            class="flex-1 w-full md:w-56 custom-multiselect border border-surface-300 dark:border-surface-700 rounded-md bg-surface-100 dark:bg-surface-800 text-surface-800 dark:text-surface-200"
            v-model="selectedDensity"
            :options="densityOptions"
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
          <label class="w-32 font-semibold">Size</label>
          <multiselect
            class="flex-1 w-full md:w-56 custom-multiselect border border-surface-300 dark:border-surface-700 rounded-md bg-surface-100 dark:bg-surface-800 text-surface-800 dark:text-surface-200"
            v-model="selectedSize"
            :options="sizeOptions"
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
          <label class="w-32 font-semibold">Color</label>
          <multiselect
            class="flex-1 w-full md:w-56 custom-multiselect border border-surface-300 dark:border-surface-700 rounded-md bg-surface-100 dark:bg-surface-800 text-surface-800 dark:text-surface-200"
            v-model="selectedColor"
            :options="colorOptions"
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
          <label class="w-32 font-semibold">Color Tol.</label>
          <multiselect
            class="flex-1 w-full md:w-56 custom-multiselect border border-surface-300 dark:border-surface-700 rounded-md bg-surface-100 dark:bg-surface-800 text-surface-800 dark:text-surface-200"
            v-model="selectedColorTol"
            :options="colorTolOptions"
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
          <label class="w-32 font-semibold">Size Tol.</label>
          <multiselect
            class="flex-1 w-full md:w-56 custom-multiselect border border-surface-300 dark:border-surface-700 rounded-md bg-surface-100 dark:bg-surface-800 text-surface-800 dark:text-surface-200"
            v-model="selectedSizeTol"
            :options="sizeTolOptions"
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
          <label class="w-32 font-semibold">Item Grade</label>
          <InputText v-model.trim="item.item_grade" class="flex-1 w-full" disabled/>
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Grade Name</label>
          <InputText v-model.trim="item.item_grade_name" class="flex-1 w-full" disabled/>
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Price Type</label>
          <InputText v-model.trim="item.price_type" class="flex-1 w-full" disabled/>
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Qty. Pack</label>
          <InputText v-model.trim="item.qty_pack" class="flex-1 w-full" />
        </div>
      </div>
      
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">Std. Weight</label>
          <InputText v-model.trim="item.std_wgt" class="flex-1 w-full" />
        </div>
      </div>            
      <div class="col-span-4">
        <div class="flex items-center">
          <label class="w-32 font-semibold">KW-1 xx%</label>
          <InputText v-model.trim="item.kw_1_xx_percentage" class="flex-1 w-full" />
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
  const selectedSeriesType = ref({label: '', code: ''});
  const seriesTypeOptions = ref([]);
  const selectedBrand = ref({label: '', code: ''});
  const brandOptions = ref([]);
  const selectedSize = ref({label: '', code: ''});
  const sizeOptions = ref([]);
  const selectedColor = ref({label: '', code: ''});
  const colorOptions = ref([]);
  const selectedDensity = ref({label: '', code: ''});
  const densityOptions = ref([]);
  const selectedColorTol = ref({label: '', code: ''});
  const colorTolOptions = ref([]);
  const selectedSizeTol = ref({label: '', code: ''});
  const sizeTolOptions = ref([]);
  const inventoryTypeId = 1 // id inventory type keramik

  const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    item_code: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    item_name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  });

  watch(filters, () => {
    fetchData(1); // Fetch data for the first page when filters change
  }, { deep: true });

  const pagination = ref({
    total: 0,
    per_page: 10,
    current_page: 1,
    from: 1,
    last: 0
  });

  const openNew = () => {
    item.value = { 
      qty_pack: 0,
      std_wgt: 0,
      size_code: '',
      unit_po: 'KG',
      price_type: '',
      vendor_proc: '',
      unit_stk: 'KG',
      item_name: '',
      item_code: '',
      item_spec: '',
      item_grade: '',
      item_grade_name: '',
      brand_code: '',
      unit_pr: 'KG',
      item_order_code: '',
      unit_prod: 'KG',
      series_type: '',
      unit_sales: 'KG',
      phanton: 'Y',
      unit_usg: 'KG',
      color_code: '',
      color_tol_code: '',
      size_tol_code: '',
      density_code: '',
      business_type: '',
      level_code: 'N',
      kw_1_xx_percentage: 0,
    };
    selectedSeriesType.value = {label: '', code: ''};
    selectedBrand.value = {label: '', code: ''};
    selectedSize.value = {label: '', code: ''};
    selectedColor.value = {label: '', code: ''};
    selectedColorTol.value = {label: '', code: ''};
    selectedDensity.value = {label: '', code: ''};
    selectedSizeTol.value = {label: '', code: ''};
    submitted.value = false;
    isEditMode.value = false;
    formDialog.value = true;
    fetchSeriesTypes(inventoryTypeId);
    fetchBrands();
    fetchSizes();
    fetchColors();
    fetchDensities();
    fetchColorTols();
    fetchSizeTols();
  };
  const fetchSeriesTypes = async () => {
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
  };

  const fetchBrands = async () => {
      try {
        const response = await axios.get(route('brands.index'));
        brandOptions.value = response.data.brands.map(brand => ({
          label: (brand.brand_code.trimEnd() + ' | ' + brand.brand_name), // Untuk display di dropdown
          code: brand.brand_code.trimEnd(), // Nilai yang dipilih
        }));
      } catch (error) {
        console.error('Failed to fetch brands:', error);
      }
  };

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

  const fetchColorTols = async () => {
      try {
          const response = await axios.get(route('color-tols.index'));
          colorTolOptions.value = response.data.colorTols.map(colorTol => ({
              label: (colorTol.color_tol_code.trimEnd() + ' | ' + colorTol.color_tol_name), // Untuk display di dropdown
              code: colorTol.color_tol_code.trimEnd(), // Nilai yang dipilih
          }));
      } catch (error) {
          console.error('Failed to fetch colorTols:', error);
      }
  }

  const fetchSizeTols = async () => {
      try {
          const response = await axios.get(route('size-tols.index'));
          sizeTolOptions.value = response.data.sizeTols.map(sizeTol => ({
              label: (sizeTol.size_tol_code.trimEnd() + ' | ' + sizeTol.size_tol_name), // Untuk display di dropdown
              code: sizeTol.size_tol_code.trimEnd(), // Nilai yang dipilih
          }));
      } catch (error) {
          console.error('Failed to fetch sizeTols:', error);
      }
  }

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
      const response = await axios.get(route('fgs.index'), {
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
    if (item.value.item_code.trim() && item.value.item_spec.trim()) {
      try {
        if (isEditMode.value) {
          await axios.put(route('fgs.update', item.value.id), {
            ...item.value, // Mengambil semua nilai dari item.value
            series_type: selectedSeriesType.value.code.toString(),
            brand_code: selectedBrand.value.code.toString(),
            size_code: selectedSize.value.code.toString(),
            color_code: selectedColor.value.code.toString(),
            color_tol_code: selectedColorTol.value.code.toString(),
            density_code: selectedDensity.value.code.toString(),
            size_tol_code: selectedSizeTol.value.code.toString(),
          });
          toast.add({ severity: 'success', summary: 'Success', detail: 'FG updated successfully', life: 3000 });
        } else {
          await axios.post(route('fgs.store'), {
            ...item.value, // Mengambil semua nilai dari item.value
            series_type: selectedSeriesType.value.code.toString(), 
            brand_code: selectedBrand.value.code.toString(),
            size_code: selectedSize.value.code.toString(),
            color_code: selectedColor.value.code.toString(),
            color_tol_code: selectedColorTol.value.code.toString(),
            density_code: selectedDensity.value.code.toString(),
            size_tol_code: selectedSizeTol.value.code.toString(),
          });
          toast.add({ severity: 'success', summary: 'Success', detail: 'FG created successfully', life: 3000 });
        }
        fetchData();
        hideDialog();
      } catch (error) {        
        console.error('Error saving FG:', error.response.data);
        toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to save FG', life: 3000 });
      }
    }
  };

  const edit = async (FGData) => {
    await fetchSeriesTypes(inventoryTypeId);
    item.value = { ...FGData };
    item.value.item_grade_name = getItemGradeName(item.value.item_code);
    // Check if series_type is empty or not
    if (item.value.series_type === '' || item.value.series_type === null) {
      selectedSeriesType.value = { label: '', code: '' };
    } else {
      const selectedOption = seriesTypeOptions.value.find(option => option.code.trim() === item.value.series_type.trim());
      if (selectedOption) {
        selectedSeriesType.value = selectedOption;
      }
    }

    await fetchBrands();
    if (item.value.brand === '' || item.value.brand === null) {
      selectedBrand.value = { label: '', code: '' };
    } else {
      const selectedOption = brandOptions.value.find(option => option.code.trim() === item.value.brand_code.trim());
      if (selectedOption) {
        selectedBrand.value = selectedOption;
      }
    }

    await fetchSizes();
    if (item.value.size === '' || item.value.size === null) {
      selectedSize.value = { label: '', code: '' };
    } else {
      const selectedOption = sizeOptions.value.find(option => option.code.trim() === item.value.size_code.trim());
      if (selectedOption) {
        selectedSize.value = selectedOption;
      }
    }
    await fetchColors();
    if (item.value.color === '' || item.value.color === null) {
      selectedColor.value = { label: '', code: '' };
    } else {
      const selectedOption = colorOptions.value.find(option => option.code.trim() === item.value.color_code.trim());
      if (selectedOption) {
        selectedColor.value = selectedOption;
      }
    }
    await fetchDensities();
    if (item.value.density === '' || item.value.density === null) {
      selectedDensity.value = { label: '', code: '' };
    } else {
      const selectedOption = densityOptions.value.find(option => option.code.trim() === item.value.density_code.trim());
      if (selectedOption) {
        selectedDensity.value = selectedOption;
      }
    }

    await fetchSizeTols();
    if (item.value.size_tol === '' || item.value.size_tol === null) {
      selectedSizeTol.value = { label: '', code: '' };
    } else {
      const selectedOption = sizeTolOptions.value.find(option => option.code.trim() === item.value.size_tol_code.trim());
      if (selectedOption) {
        selectedSizeTol.value = selectedOption;
      }
    }
    await fetchColorTols();
    if (item.value.color_tol === '' || item.value.color_tol === null) {
      selectedColorTol.value = { label: '', code: '' };
    } else {
      const selectedOption = colorTolOptions.value.find(option => option.code.trim() === item.value.color_tol_code.trim());
      if (selectedOption) {
        selectedColorTol.value = selectedOption;
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
    await axios.delete(route('fgs.destroy', item.value.id));
    deleteDialog.value = false;
    fetchData();
    toast.add({severity:'success', summary: 'Successful', detail: 'FG Deleted', life: 3000});
  };

  const validateAndProcessInput = async () => {
    submitted.value = true;
    const code = item.value.item_code;

    if (code.length < 16) {
        alert('Item code must be at least 16 characters long.');
        return;
    }

    // Process input to populate dropdowns and itemGrade
    const brand_code = getBrand(code);
    if (brand_code === '' || brand_code === null) {
      selectedBrand.value = { label: '', code: '' };
    } else {
      const selectedOption = brandOptions.value.find(option => option.code.trim() === brand_code.trim());
      if (selectedOption) {
        selectedBrand.value = selectedOption;
      }
    }

    const size_code = getSize(code);
    if (size_code === '' || size_code === null) {
      selectedSize.value = { label: '', code: '' };
    } else {
      const selectedOption = sizeOptions.value.find(option => option.code.trim() === size_code.trim());
      if (selectedOption) {
        selectedSize.value = selectedOption;
      }
    }

    const series_type = getSeriesType(code);
    if (series_type === '' || series_type === null) {
      selectedSeriesType.value = { label: '', code: '' };
    } else {
      const selectedOption = seriesTypeOptions.value.find(option => option.code.trim() === series_type.trim());
      if (selectedOption) {
        selectedSeriesType.value = selectedOption;
      }
    }

    const density_code = getDensityCode(code);
    if (density_code === '' || density_code === null) {
      selectedDensity.value = { label: '', code: '' };
    } else {
      const selectedOption = densityOptions.value.find(option => option.code.trim() === density_code.trim());
      if (selectedOption) {
        selectedDensity.value = selectedOption;
      }
    }

    const color_code = getColor(code);
    if (color_code === '' || color_code === null) {
      selectedColor.value = { label: '', code: '' };
    } else {
      const selectedOption = colorOptions.value.find(option => option.code.trim() === color_code.trim());
      if (selectedOption) {
        selectedColor.value = selectedOption;
      }
    }

    const color_tol_code = getColorTol(code);
    if (color_tol_code === '' || color_tol_code === null) {
      selectedColorTol.value = { label: '', code: '' };
    } else {
      const selectedOption = colorTolOptions.value.find(option => option.code.trim() === color_tol_code.trim());
      if (selectedOption) {
        selectedColorTol.value = selectedOption;
      }
    }

    const size_tol_code = getSizeTolCode(code);
    if (size_tol_code === '' || size_tol_code === null) {
      selectedSizeTol.value = { label: '', code: '' };
    } else {
      const selectedOption = sizeTolOptions.value.find(option => option.code.trim() === size_tol_code.trim());
      if (selectedOption) {
        selectedSizeTol.value = selectedOption;
      }
    }
    item.value.item_grade = getItemGrade(code);
    item.value.item_grade_name = getItemGradeName(code);
    item.value.price_type = getPriceType(code);
    }

    // Functions to extract specific parts of the item code
    const getBrand = (code) => code[3] || '';   
    const getSize = (code) => code.substring(4, 6) || '';   
    const getSeriesType = (code) => code.substring(6, 9) || ''; 
    const getDensityCode = (code) => code[10] || '';    
    const getColor = (code) => code.substring(11, 13) || '';    
    const getColorTol = (code) => code[13] || '';   
    const getSizeTolCode = (code) => code[14] || '';    
    const getItemGrade = (code) => code[15] || '';
    const getPriceType = (code) => code.substring(0, 13) || ''; 
    const getItemGradeName = (code) => {
        if(code[15] === '1') {
            return 'KW 1'
        }
        else if(code[15] === '2') {
            return 'KW 2'
        }
        else {
            return 'KW 3'
        }
    }
  </script>
  
  <style>
  .card {
    padding: 20px;
  }
  </style>
