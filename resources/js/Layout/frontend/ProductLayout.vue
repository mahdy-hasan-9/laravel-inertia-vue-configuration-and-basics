<script setup>
import { ref } from 'vue'
import FrontLayout from './FrontLayout.vue';
const isMobileFilterOpen = ref(false)
</script>


<template>
    <div class="flex flex-col md:flex-row gap-6 min-h-[calc(100vh-12rem)]">
        <div
            class="md:hidden flex justify-between items-center bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
            <span class="font-semibold text-gray-700">Filters</span>
            <button @click="isMobileFilterOpen = !isMobileFilterOpen"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all">
                {{ isMobileFilterOpen ? 'Hide Filters' : 'Show Filters' }}
            </button>
        </div>

        <aside :class="[
            isMobileFilterOpen ? 'block' : 'hidden',
            'z-10 md:block w-full md:w-64 flex-shrink-0 bg-white p-6 rounded-xl border border-gray-200 shadow-sm h-fit sticky top-20 transition-all duration-300'
        ]">
            <div class="space-y-6">
                <div>
                    <slot name="sidebar-search">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Search Products</h3>
                        <input type="text" placeholder="Search..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </slot>
                </div>

                <hr class="border-gray-100" />

                <div>
                    <slot name="sidebar-filters">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Categories</h3>
                        <div class="space-y-2 text-sm text-gray-600">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500" />
                                <span>All Products</span>
                            </label>
                        </div>
                    </slot>
                </div>

                <div>
                    <slot name="sidbar-filters-submit"></slot>
                </div>

            </div>
        </aside>

        <main class="flex-1">
            <slot />
        </main>

    </div>
</template>