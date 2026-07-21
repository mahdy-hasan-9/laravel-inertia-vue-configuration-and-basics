<script setup>
import { onMounted, onUnmounted, ref, watch } from 'vue'
import { router, Link, usePage } from '@inertiajs/vue3'
import ProductLayout from '../../../Layout/frontend/ProductLayout.vue'
import debounce from 'lodash/debounce'
import NotFound from '../../../components/mixed/NotFound.vue'
import Product from './Product.vue'
import SmoothFade from '../../../components/mixed/SmoothFade.vue'
import SmoothGrid from '../../../components/mixed/SmoothGrid.vue'
import Loader from '../../../components/mixed/Loader.vue'


const props = defineProps({
    products: { type: Object },
    filters: { type: Array, default: () => [] },
    vendors: { type: Array, default: () => [] },
    brands: { type: Array, default: () => [] },
    categories: { type: Array, default: () => [] },
    subCategories: { type: Array, default: () => [] }
});

const search = ref(props.filters?.search || '');
const selectedVendor = ref(props.filters?.vendor_id || '');
const selectedBrand = ref(props.filters?.brand_id || '');
const selectedCategory = ref(props.filters?.category_id || '');
const selectedSubCategory = ref(props.filters?.sub_category_id || '');
const isLoading = ref(false);


const filterProducts = (onlyKeys = ['products']) => {
    router.get(route('products.index'), {
        search: search.value || undefined,
        vendor_id: selectedVendor.value || undefined,
        brand_id: selectedBrand.value || undefined,
        category_id: selectedCategory.value || undefined,
        sub_category_id: selectedSubCategory.value || undefined,
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: onlyKeys,
    });
};


const debouncedSearch = debounce(() => {
    filterProducts(['products']);
}, 500);

watch(search, () => debouncedSearch())


const onVendorChange = () => {
    selectedBrand.value = '';
    selectedCategory.value = '';
    selectedSubCategory.value = '';
    filterProducts(['products', 'brands']);
};


const onBrandChange = () => {
    selectedCategory.value = '';
    selectedSubCategory.value = '';
    filterProducts(['products', 'categories']);
};

const onCategoryChange = () => {
    selectedSubCategory.value = '';
    filterProducts(['products', 'subCategories']);
};

const onSubCategoryChange = () => {
    filterProducts(['products']);
};


const resetFilters = () => {
    search.value = '';
    selectedVendor.value = '';
    selectedBrand.value = '';
    selectedCategory.value = '';
    selectedSubCategory.value = '';
    router.get(route('products.index'), {}, { preserveState: true, preserveScroll: true });
};


let removeStartListener, removeFinishListener;

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

        <template #sidebar-filters>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Vendor</label>
                    <select v-model="selectedVendor" @change="onVendorChange"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Vendors</option>
                        <option v-for="vendor in props.vendors" :key="vendor.id" :value="vendor.id">
                            {{ vendor.name }}
                        </option>
                    </select>
                </div>

                <div v-if="selectedVendor">
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Brand</label>
                    <select v-model="selectedBrand" @change="onBrandChange"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Brands</option>
                        <option v-for="brand in props.brands" :key="brand.id" :value="brand.id">
                            {{ brand.name }}
                        </option>
                    </select>
                </div>

                <div v-if="selectedBrand">
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Category</label>
                    <select v-model="selectedCategory" @change="onCategoryChange"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Categories</option>
                        <option v-for="cat in props.categories" :key="cat.id" :value="cat.id">
                            {{ cat.name }}
                        </option>
                    </select>
                </div>

                <div v-if="selectedCategory">
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Sub Category</label>
                    <select v-model="selectedSubCategory" @change="onSubCategoryChange"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Sub Categories</option>
                        <option v-for="subCat in props.subCategories" :key="subCat.id" :value="subCat.id">
                            {{ subCat.name }}
                        </option>
                    </select>
                </div>
            </div>
        </template>

        <template #sidbar-filters-submit>
            <button @click="resetFilters" type="button"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg w-full text-sm font-medium transition-all">
                Reset Filters
            </button>
        </template>

        <div class="relative min-h-[400px]">
            <SmoothFade mode="out-in">
                <div v-if="isLoading" key="loading"
                    class="absolute inset-0 bg-white/70 backdrop-blur-sm z-10 flex items-center justify-center rounded-xl">
                    <Loader />
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
                    preserve-state preserve-scroll v-html="link.label" />
            </template>
        </div>
    </ProductLayout>
</template>