<template>
    <DashboardLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Raw Material</h1>        
            <RawMaterialContent />
        </div>
    </DashboardLayout>
</template>
<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import RawMaterialContent from './Contents/RawMaterialContent.vue';
</script>