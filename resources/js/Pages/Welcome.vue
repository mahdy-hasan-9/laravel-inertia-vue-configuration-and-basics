<script setup>
import { Link, router } from '@inertiajs/vue3';

defineProps({
    message: String
});
</script>


<template>
    <div>
        <nav class="p-4 bg-white shadow flex gap-4">
            <Link :href="route('home')" class="text-blue-500 font-semibold">Home</Link>
            <Link :href="route('about')" class="text-blue-500 font-semibold">About</Link>
        </nav>
    </div>
    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <h1 class="text-2xl font-bold text-blue-600">{{ message }}</h1>
    </div>
</template>
