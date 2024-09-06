<template>
  <aside :class="['transition-width duration-300 border-r', isDarkMode ? 'bg-gray-800 text-white' : 'bg-white text-black', isCollapsed ? 'w-14' : 'w-64']">
  <div class="h-full px-2 py-6">
    <nav>
      <ul class="space-y-2">
        <!-- Dashboard Menu -->
        <li>
          <router-link to="/dashboard" class="flex items-center p-2 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700">
            <i class="pi pi-home"></i>
            <transition name="fade">
              <span v-if="!isCollapsed" class="ml-3">Dashboard</span>
            </transition>
          </router-link>
        </li>

        <!-- Master Menu with Dropdown -->
        <li>
          <div @click="toggleMasterMenu" class="flex items-center justify-between p-2 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
            <div class="flex items-center">
              <i class="pi pi-server"></i>
              <transition name="fade">
                <span v-if="!isCollapsed" class="ml-3">Master</span>
              </transition>
            </div>
            <transition name="fade">
              <svg v-if="!isCollapsed" :class="{'transform rotate-180': isMasterMenuOpen}" class="w-4 h-4 ml-2 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </transition>
          </div>

          <!-- Dropdown Items -->
          <transition name="slide fade">
            <ul v-if="isMasterMenuOpen && !isCollapsed" class="ml-10 space-y-2">
              <li>
                <Link :href="route('general-data')" class="flex items-center p-2 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700">
                  <span class="ml-3">General Data</span>
                </Link>
              </li>
              <li>
                <Link :href="route('item-data')" class="flex items-center p-2 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700">
                  <span class="ml-3">Item Data</span>
                </Link>
              </li>
              <li>
                <Link :href="route('raw-material')" class="flex items-center p-2 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700">
                  <span class="ml-3">Raw Material</span>
                </Link>
              </li>
            </ul>
          </transition>
        </li>
      </ul>
    </nav>
  </div>
</aside>

</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, inject } from 'vue';
import { useRoute } from 'vue-router';

// const route = useRoute();
// console.log(route.params)

const isDarkMode = inject('isDarkMode', ref(false));
const isMasterMenuOpen = ref(true);
function toggleMasterMenu() {
  isMasterMenuOpen.value = !isMasterMenuOpen.value;
}
</script>
