<script setup>
import { ref, watch } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import ProductLayout from '../../../Layout/frontend/ProductLayout.vue'

const search = ref('')

watch(search, (value) => {
    router.get(route('products'), { search: value }, {
        preserveState: true,
        replace: true
    })
})

const props = defineProps({
    products: {
        type: Object,
    }
});

</script>

<template>
    <ProductLayout>
        <template #sidebar-search>
            <h3 class="text-sm font-semibold text-gray-900 mb-2">Search</h3>
            <input v-model="search" type="search" placeholder="Type to search..."
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </template>


        <template #sidbar-filters-submit>
            <button class="bg-indigo-900 text-white px-5 py-2 rounded-lg">submit</button>
        </template>


        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="product in props.products.data"
                class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-all">
                <div class="h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                    <img :src="product.image" class="w-full h-full" alt="product-image" />
                </div>
                <div class="p-4 text-gray-500">
                    <h4 class="font-bold text-gray-700">{{ product.name }}</h4>
                    <h5>Brand : {{ product.brand_name }}</h5>
                    <p>
                        Rating : {{ product.rating }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Price : 
                        <template v-if="product.is_discount == 1">
                            <s class="text-gray-400 mr-2">${{ product.price }}</s>
                            <span class="font-semibold text-gray-600">${{ product.discount_price }}</span>
                        </template>
                        <template v-else>
                            <span class="font-semibold text-gray-600">${{ product.price }}</span>
                        </template>
                    </p>
                </div>
            </div>
        </div>
    </ProductLayout>
</template>