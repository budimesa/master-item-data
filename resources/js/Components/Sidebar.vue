<template>
  <aside :class="['transition-width duration-300', isDarkMode ? 'bg-gray-800 text-white' : 'bg-white text-black', isCollapsed ? 'w-0' : 'w-64']">
    <div class="h-full px-2 py-6">
      <nav>
        <ul class="space-y-2">
          <li>
            <router-link to="/dashboard" class="flex items-center p-2 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700">
              <i class="pi pi-home" v-if="!isCollapsed"></i>
              <transition name="fade">
                <span v-if="!isCollapsed" class="ml-3">Dashboard</span>
              </transition>
            </router-link>
          </li>
          <li>
            <div @click="toggleMasterMenu" class="flex items-center justify-between p-2 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
              <div class="flex items-center">
                <i class="pi pi-server" v-if="!isCollapsed"></i>
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
            <transition name="slide fade">
              <ul v-if="isMasterMenuOpen && !isCollapsed" class="ml-10 space-y-2">
                <li>
                  <Link :href="route('general-data')" class="flex items-center p-2 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ml-3">General Data</span>
                  </Link>
                </li>
                <li>
                  <Link :href="route('raw-material')" class="flex items-center p-2 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ml-3">Raw Material</span>
                  </Link>
                </li>
                <li>
                  <Link :href="route('wfg')" class="flex items-center p-2 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ml-3">WFG</span>
                  </Link>
                </li>
                <li>
                  <Link :href="route('sfg')" class="flex items-center p-2 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ml-3">SFG</span>
                  </Link>
                </li>
                <li>
                  <Link :href="route('fg')" class="flex items-center p-2 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ml-3">FG</span>
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
import { ref, inject, defineProps } from 'vue';

const props = defineProps({
  isCollapsed: {
    type: Boolean,
    required: true
  }
});

const isDarkMode = inject('isDarkMode', ref(false));
const isMasterMenuOpen = ref(true);

function toggleMasterMenu() {
  isMasterMenuOpen.value = !isMasterMenuOpen.value;
}
</script>
<style>

</style>