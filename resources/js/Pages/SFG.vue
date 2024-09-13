<template>
    <DashboardLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Semi Finished Goods</h1>        
            <SFGContent />
        </div>
    </DashboardLayout>
</template>
<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import SFGContent from './Contents/SFGContent.vue';


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

    }

    // Functions to extract specific parts of the item code
    function getBrand(code) {
        return code[3] || '';
    }

    function getSize(code) {
    return code.substring(4, 6) || '';
    }

    function getSeriesType(code) {
    return code.substring(6, 9) || '';
    }

    function getDensityCode(code) {
    return code[10] || '';
    }

    function getColor(code) {
    return code.substring(11, 13) || '';
    }

    function getColorTol(code) {
    return code[13] || '';
    }

    function getSizeTolCode(code) {
    return code[14] || '';
    }

    function getItemGrade(code) {
    return code[15] || '';
    }
</script>