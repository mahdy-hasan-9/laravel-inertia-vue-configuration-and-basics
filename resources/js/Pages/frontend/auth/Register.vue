<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const clientErrors = ref({})

const form = useForm({
    name: '',
    email: '',
    password: '',
})

const validateForm = () => {
    clientErrors.value = {}


    clientErrors.value = {}
    if (!form.name.trim()) clientErrors.value.name = 'The name field is required'
    if (!form.email.trim()) {
        clientErrors.value.email = 'The email field is required.'
    }
    if (!form.password) {
        clientErrors.value.password = 'The password field is required.'
    }
    return Object.keys(clientErrors.value).length === 0
}

const submit = () => {
    if (!validateForm()) return

    form.post(route('register.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>


    <!-- <div v-if="isLoading" key="loading"
        class="absolute inset-0 bg-white/70 backdrop-blur-sm z-10 flex items-center justify-center rounded-xl">
        <Loader />
    </div> -->

    <Head title="Register" />
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-3xl font-extrabold text-gray-600">Create a new account</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Or
                <Link :href="route('login')"
                    class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">sign in to your account
                </Link>
            </p>
        </div>
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-xl sm:px-10 border border-gray-100">
                <form class="space-y-6" @submit.prevent="submit">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <div class="mt-1">
                            <input v-model="form.name" id="name" type="text" autocomplete="name"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                :class="{ 'border-red-400': clientErrors.name || form.errors.name }" />
                        </div>
                        <p v-if="clientErrors.name || form.errors.name" class="mt-1 text-xs text-red-600">{{
                            clientErrors.name || form.errors.name }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <div class="mt-1">
                            <input v-model="form.email" id="email" type="email" autocomplete="email"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                :class="{ 'border-red-400': clientErrors.email || form.errors.email }" />
                        </div>
                        <p v-if="clientErrors.email || form.errors.email" class="mt-1 text-xs text-red-600">{{
                            clientErrors.email || form.errors.email }}</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1">
                            <input v-model="form.password" id="password" type="password" autocomplete="new-password"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                :class="{ 'border-red-400': clientErrors.password || form.errors.password }" />
                        </div>
                        <p v-if="clientErrors.password || form.errors.password" class="mt-1 text-xs text-red-600">{{
                            clientErrors.password || form.errors.password }}</p>
                    </div>
                    <div>
                        <button type="submit" :disabled="form.processing"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors disabled:opacity-50">
                            {{ form.processing ? 'Processing...' : 'Register' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>