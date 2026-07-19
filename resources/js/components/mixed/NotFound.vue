<script setup></script>


<template>

    <transition name="empty-fade" mode="out-in">
        <div
            class="flex flex-col items-center justify-center py-12 px-4 bg-white border border-gray-200 rounded-xl shadow-sm">
            <div class="p-4 bg-gray-50 rounded-full text-gray-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.604 10.604Z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-600 mb-1">No Product Has Been Found</h3>
            <p class="text-sm text-gray-500 text-center max-w-sm">You Can Search Again.</p>
        </div>
    </transition>
</template>


<style scoped>
.empty-fade-enter-active,
.empty-fade-leave-active {
    transition: all 0.9s cubic-bezier(0.4, 0, 0.2, 1);
}

.empty-fade-enter-from,
.empty-fade-leave-to {
    opacity: 0;
    transform: scale(0.98);
    /* হালকা মিনিমাল স্কেল ইফেক্ট */
}
</style>