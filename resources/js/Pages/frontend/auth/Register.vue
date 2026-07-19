<script setup>

defineProps({
    message: String
});
</script>


<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <h1 class="text-2xl font-bold text-blue-600">{{ message }}</h1>
    </div>
</template>
