<script setup>
import { usePage } from '@inertiajs/vue3';

    const props = defineProps({
        message : {
            type : String
        }
    })
</script>

<template>
    <pre>
        {{ usePage().props.auth.user }}
    </pre>
    Dashboard {{ message }}
</template>