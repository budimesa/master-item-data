<template>
    <DashboardLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">WIP Finished Goods</h1>        
            <WFGContent />
        </div>
    </DashboardLayout>
</template>
<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import WFGContent from './Contents/WFGContent.vue';
</script>