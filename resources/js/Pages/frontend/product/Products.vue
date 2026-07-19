<script setup>
import { onMounted, onUnmounted, ref, watch } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import ProductLayout from '../../../Layout/frontend/ProductLayout.vue'
import debounce from 'lodash/debounce'
import NotFound from '../../../components/mixed/NotFound.vue'
import Product from './Product.vue'
import SmoothFade from '../../../components/mixed/SmoothFade.vue'
import SmoothGrid from '../../../components/mixed/SmoothGrid.vue'
import Loader from '../../../components/mixed/Loader.vue'


const props = defineProps({
    products: { type: Object },
    filters: { type: Object }
});

const search = ref(props.filters?.search || '');
const isLoading = ref(false)

const debouncedSearch = debounce((value) => {
    const queryParams = {
        search: value.trim() === '' ? undefined : value
    }
    router.get(route('products.index'), queryParams, {
        preserveState: true,
        replace: true,
        only: ['products'],
    })
}, 500)

watch(search, (newValue) => {
    debouncedSearch(newValue)
})

let removeStartListener;
let removeFinishListener;

onMounted(() => {
    removeStartListener = router.on('start', () => { isLoading.value = true })
    removeFinishListener = router.on('finish', () => { isLoading.value = false })
})

onUnmounted(() => {
    if (removeStartListener) removeStartListener();
    if (removeFinishListener) removeFinishListener();
})
</script>

<template>
    <ProductLayout>

        <template #sidebar-search>
            <h3 class="text-sm font-semibold text-gray-900 mb-2">Search</h3>
            <div class="relative">
                <input v-model="search" type="search" placeholder="Type to search..."
                    class="w-full px-3 py-2 pl-9 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />

                <div v-if="isLoading" class="absolute left-3 top-2.5">
                    <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
                <div v-else class="absolute left-3 top-2.5 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.604 10.604Z" />
                    </svg>
                </div>
            </div>
        </template>

        <template #sidbar-filters-submit>
            <button class="bg-indigo-900 text-white px-5 py-2 rounded-lg w-full sm:w-auto">submit</button>
        </template>

        <div class="relative min-h-[400px]">

            <SmoothFade mode="out-in">
                <div v-if="isLoading" key="loading"
                    class="absolute inset-0 bg-white/70 backdrop-blur-sm z-10 flex items-center justify-center rounded-xl">
                    <Loader/>
                </div>

                <div v-else-if="props.products.data.length > 0" key="grid">
                    <SmoothGrid tag="div" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="product in props.products.data" :key="product.id"
                            class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-all">
                            <Product :product="product" />
                        </div>
                    </SmoothGrid>
                </div>

                <div v-else key="empty">
                    <NotFound />
                </div>

            </SmoothFade>
        </div>

        <div v-if="props.products.meta.links.length > 3" class="mt-8 flex justify-center flex-wrap gap-1">
            <template v-for="(link, key) in props.products.meta.links" :key="key">
                <div v-if="link.url === null"
                    class="px-4 py-2 text-sm leading-4 text-gray-400 border rounded-lg bg-gray-50"
                    v-html="link.label" />
                <Link v-else :href="link.url"
                    class="px-4 py-2 text-sm leading-4 border rounded-lg hover:bg-white hover:text-indigo-900 focus:border-indigo-500 focus:text-indigo-500 transition-all"
                    :class="{ 'bg-indigo-900 text-white hover:bg-indigo-800 border-indigo-900': link.active }"
                    preserve-state v-html="link.label" />
            </template>
        </div>
    </ProductLayout>
</template>