<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

// ইমেজ প্রিভিউ স্টেট (Local UI State, Form data-র অংশ নয়)
const imagePreview = ref(null)


const form = useForm({
    title: '',
    description: '',
    image: null, // ফাইল বাইন্ডিংয়ের জন্য
})

// ফাইল সিলেক্ট এবং প্রিভিউ হ্যান্ডেলার
const handleImageChange = (e) => {
    const file = e.target.files[0]
    if (!file) return

    form.image = file

    // Web API দিয়ে ক্লায়েন্ট-সাইড ইনস্ট্যান্ট প্রিভিউ তৈরি
    imagePreview.value = URL.createObjectURL(file)
}

// Form Submit Handling
const submit = () => {
    // Inertia অটোমেটিক Multipart Form Data সনাক্ত করে ফাইল আপলোড হ্যান্ডেল করে
    form.post(route('products.store'), {
        onSuccess: () => {
            form.reset()
            imagePreview.value = null
        },
        onError: (errors) => {
            console.log('Validation failed:', errors)
        }
    })
}
</script>

<template>
    <div class="max-w-2xl bg-white mx-auto p-6 rounded-xl shadow-xl">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Create Product</h2>

        <form @submit.prevent="submit" class="space-y-5">
            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Title</label>
                <input v-model="form.title" type="text"
                    class="w-full rounded-lg border px-3 py-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    placeholder="Enter product title" />
                <div v-if="form.errors.title" class="text-xs text-red-600 mt-1">{{ form.errors.title }}</div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea v-model="form.description" rows="4"
                    class="w-full border px-3 py-2 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    placeholder="Describe your product"></textarea>
                <div v-if="form.errors.description" class="text-xs text-red-600 mt-1">{{ form.errors.description }}
                </div>
            </div>

            <!-- Image Upload with Preview -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>

                <div class="mt-1 flex items-center gap-4">
                    <!-- Preview Box -->
                    <div v-if="imagePreview"
                        class="relative w-20 h-20 rounded-lg overflow-hidden border border-gray-200 bg-gray-50 flex-shrink-0">
                        <img :src="imagePreview" alt="Preview" class="w-full h-full object-cover" />
                    </div>

                    <!-- File Input -->
                    <input type="file" accept="image/*" @change="handleImageChange"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer" />
                </div>
                <div v-if="form.errors.image" class="text-xs text-red-600 mt-1">{{ form.errors.image }}</div>
            </div>

            <!-- Submit Button with Processing State -->
            <div class="flex justify-end pt-2">
                <button type="submit" :disabled="form.processing"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg text-sm font-medium shadow-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ form.processing ? 'Saving...' : 'Save Product' }}
                </button>
            </div>
        </form>
    </div>
</template>