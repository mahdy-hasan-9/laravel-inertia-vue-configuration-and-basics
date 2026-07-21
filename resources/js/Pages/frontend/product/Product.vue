<script setup>

const props = defineProps({
    product : {
        type : Object
    }
})

</script>

<template>
    <div class="h-48 bg-gray-100 flex items-center justify-center text-gray-400">
        <img :src="product.image" class="w-full h-full object-cover" alt="product-image" />
    </div>
    <div class="p-4 text-gray-500">
        <h4 class="font-bold text-gray-700">{{ product.name }}</h4>
        <h5>Brand : {{ product.brand_name }}</h5>
        <h5>Category : {{ product.category_name }}</h5>
        <h5>Sub Category : {{ product.sub_category_name }}</h5>
        <p>Rating : {{ product.rating }}</p>
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
</template>