<script setup>
import { computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import SingleImage from '../../components/mixed/SingleImage.vue'
import { toast } from 'vue3-toastify';


const page = usePage()
const user = computed(() => page.props.auth.user)

const form = useForm({
    _method: 'put',
    name: user.value?.name || '',
    email: user.value?.email || '',
    password: '',
    avatar: null,
    remove_avatar: false
})

const handleImageRemove = () => {
    form.remove_avatar = true
}

const submit = () => {
    form.post(route('profile.update'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            form.reset('password', 'avatar')
            form.remove_avatar = false
            toast.info("Profile Update Successfully!", {
                autoClose: 1500,
                position: "top-right"
            });
        },
        onError: (errors) => {
            console.error('Profile update failed:', errors)
            toast.error("Something Went Wrong!", {
                autoClose: 1500,
            });
        }
    })
}
</script>

<template>
    <div class="max-w-2xl bg-white mx-auto p-6 rounded-xl shadow-xl border border-gray-100">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Profile Information</h2>

        <form @submit.prevent="submit" class="space-y-5">

            <SingleImage v-model="form.avatar" :default-url="user?.avatar" :error="form.errors.avatar"
                label="Profile Photo" @remove="handleImageRemove" />

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input v-model="form.name" type="text"
                    class="w-full rounded-lg border px-3 py-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    placeholder="Enter your full name" />
                <div v-if="form.errors.name" class="text-xs text-red-600 mt-1">{{ form.errors.name }}</div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input v-model="form.email" type="email" readonly
                    class="w-full rounded-lg border px-3 py-2 border-gray-200 bg-gray-100 text-gray-500 text-sm cursor-not-allowed focus:outline-none" />
                <p class="text-xs text-gray-400 mt-1">Email address cannot be changed.</p>
                <div v-if="form.errors.email" class="text-xs text-red-600 mt-1">{{ form.errors.email }}</div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input v-model="form.password" type="password" autocomplete="new-password"
                    class="w-full rounded-lg border px-3 py-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    placeholder="Leave blank to keep current password" />
                <div v-if="form.errors.password" class="text-xs text-red-600 mt-1">{{ form.errors.password }}</div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" :disabled="form.processing"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg text-sm font-medium shadow-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ form.processing ? 'Updating...' : 'Update Profile' }}
                </button>
            </div>
        </form>
    </div>
</template>