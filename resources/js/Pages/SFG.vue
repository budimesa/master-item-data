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
</script>