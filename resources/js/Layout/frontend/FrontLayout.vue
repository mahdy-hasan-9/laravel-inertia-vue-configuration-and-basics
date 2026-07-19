<script setup>
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const isMobileMenuOpen = ref(false)


const menuItems = ref([
    { name: 'Home', href: route('home'), routeName: 'home' },
    { name: 'Products', href: route('products.index'), routeName: 'products.index' },
])

const isActive = (item) => {
    if (route().current(item.routeName) || route().current(item.routeName + '.*')) {
        return true
    }
    const currentPath = page.url.split('?')[0]
    const itemPath = new URL(item.href, window.location.origin).pathname
    if (itemPath === '/') {
        return currentPath === '/'
    }
    return currentPath.startsWith(itemPath)
}


</script>

<template>
    <div class="min-h-screen bg-gray-50 flex flex-col font-sans">
        <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <span class="text-2xl font-bold text-indigo-600 tracking-tight">
                            Logo
                        </span>
                    </div>

                    <!-- Desktop Navigation Menu -->
                    <nav class="hidden md:flex space-x-8">
                        <Link v-for="item in menuItems" :key="item.name" :href="item.href" :class="[
                            isActive(item)
                                ? 'border-indigo-500 text-gray-900'
                                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                            'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200'
                        ]">
                            {{ item.name }}
                        </Link>
                    </nav>

                    <!-- Right Side Actions (User Profile / CTA) -->
                    <div class="hidden md:flex items-center gap-4">
                        <button class="text-sm font-medium text-gray-500 hover:text-gray-700 hover:cursor-pointer">
                            cart
                        </button>
                        <Link :href="route('add.product')" class="hover:cursor-pointer">
                            <button
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 hover:cursor-pointer rounded-lg text-sm font-medium shadow-sm transition-all">
                                profile
                            </button>
                        </Link>

                        <Link :href="route('login')" class="hover:cursor-pointer">
                            <button
                                class="border border-indigo-900 text-indigo-900 hover:cursor-pointer px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-all">
                                Login
                            </button>
                        </Link>

                        <Link :href="route('register')" class="hover:cursor-pointer">
                            <button
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 hover:cursor-pointer rounded-lg text-sm font-medium shadow-sm transition-all">
                                Register
                            </button>
                        </Link>

                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex items-center md:hidden">
                        <button @click="isMobileMenuOpen = !isMobileMenuOpen"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                            <span class="sr-only">Open main menu</span>
                            <!-- Hamburger Icon -->
                            <svg v-if="!isMobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <!-- Close Icon -->
                            <svg v-else class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div v-show="isMobileMenuOpen" class="md:hidden border-b border-gray-200 bg-white">
                <div class="pt-2 pb-3 space-y-1 px-4">
                    <Link v-for="item in menuItems" :key="item.name" :href="item.href" :class="[
                        isActive(item)
                            ? 'bg-indigo-50 border-indigo-500 text-indigo-700'
                            : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700',
                        'block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-all'
                    ]">
                        {{ item.name }}
                    </Link>
                    <div class="pt-4 pb-2 border-t border-gray-200 flex flex-col gap-2">
                        <!-- <button
                            class="w-full text-left px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-50">Add
                            Product</button>
                        <button
                            class="w-full bg-indigo-600 text-white text-center px-4 py-2 rounded-lg text-base font-medium">Get
                            Started</button> -->
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Dynamic Slot -->
        <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <slot>
                <h1 class="text-2xl font-bold text-gray-900 mb-4">Welcome to Dashboard</h1>
                <p class="text-gray-600">Your main page content will inject here dynamically.</p>
            </slot>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-6 mt-auto">
            <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
                &copy; 2026 DevApp Inc. All rights reserved.
            </div>
        </footer>
    </div>
</template>