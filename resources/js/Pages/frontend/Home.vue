<script setup>
import { Link, router } from '@inertiajs/vue3';
import FrontLayout from '../../Layout/frontend/FrontLayout.vue';
import SmoothFade from '../../components/mixed/SmoothFade.vue';

defineProps({
    message: String
});
</script>


<template>
    <SmoothFade mode="out-in">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200 p-6">
            <h1 class="text-2xl font-bold text-blue-600">{{ message }}</h1>
        </div>
    </SmoothFade>
</template>
