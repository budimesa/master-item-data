<template>
    <DashboardLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Finished Goods</h1>        
            <FGContent />
        </div>
    </DashboardLayout>
</template>
<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import FGContent from './Contents/FGContent.vue';
</script>