<script setup>
import { ref, computed, onUnmounted } from 'vue'

const props = defineProps({
    modelValue: {
        type: [File, String, null],
        default: null
    },
    defaultUrl: {
        type: String,
        default: null
    },
    error: {
        type: String,
        default: null
    },
    label: {
        type: String,
        default: 'Profile Photo'
    }
})

const emit = defineEmits(['update:modelValue', 'remove'])

const fileInput = ref(null)

const selectedImagePreview = ref(null)
const isRemoved = ref(false)

const previewUrl = computed(() => {
    if (isRemoved.value) return null
    if (selectedImagePreview.value) return selectedImagePreview.value
    if (!props.defaultUrl) return null

    return props.defaultUrl.startsWith('http') || props.defaultUrl.startsWith('blob:')
        ? props.defaultUrl
        : `${props.defaultUrl}`
})


const triggerFileInput = () => {
    fileInput.value?.click()
}

const handleFileChange = (e) => {
    const file = e.target.files[0]
    if (!file) return

    isRemoved.value = false
    if (selectedImagePreview.value) {
        URL.revokeObjectURL(selectedImagePreview.value)
    }

    selectedImagePreview.value = URL.createObjectURL(file)
    emit('update:modelValue', file)
}

const removeImage = () => {
    if (selectedImagePreview.value) {
        URL.revokeObjectURL(selectedImagePreview.value)
        selectedImagePreview.value = null
    }

    if (fileInput.value) {
        fileInput.value.value = ''
    }

    isRemoved.value = true
    emit('update:modelValue', null)
    emit('remove')
}

onUnmounted(() => {
    if (selectedImagePreview.value) {
        URL.revokeObjectURL(selectedImagePreview.value)
    }
})
</script>

<template>
    <div>
        <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1">{{ label }}</label>
        
        <div class="mt-1 flex items-center gap-4">
            <div class="relative w-20 h-20 rounded-full border border-gray-200 bg-gray-50 flex-shrink-0">
                <template v-if="previewUrl">
                    <img :src="previewUrl" alt="Avatar Preview" class="w-full h-full object-cover rounded-full" />
                    <button 
                        type="button" 
                        @click="removeImage"
                        class="absolute -top-1 -right-1 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-md transition-all focus:outline-none"
                        title="Remove photo"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                    </button>
                </template>
                
                <div v-else class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
            </div>

            <input 
                ref="fileInput"
                type="file" 
                accept="image/*" 
                @change="handleFileChange"
                class="hidden" 
            />

            <button 
                type="button" 
                @click="triggerFileInput"
                class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-all"
            >
                {{ previewUrl ? 'Change Photo' : 'Upload Photo' }}
            </button>
        </div>
        
        <div v-if="error" class="text-xs text-red-600 mt-1">{{ error }}</div>
    </div>
</template>