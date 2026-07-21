<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    users: { type: Array, default: () => [] },
    activeChats: { type: Array, default: () => [] }
});

const emit = defineEmits(['send-message', 'add-group', 'select-chat']);

const searchQuery = ref('');
const isLeftSidebarOpen = ref(false);
const isRightSidebarOpen = ref(false);

const filteredUsers = computed(() => {
    if (!searchQuery.value.trim()) return props.users;
    return props.users.filter(user =>
        user.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const closeDrawers = () => {
    isLeftSidebarOpen.value = false;
    isRightSidebarOpen.value = false;
};
</script>

<template>
    <!-- Screen Height Responsive Shell -->
    <div class="relative flex h-[calc(100dvh-5rem)] lg:h-[calc(100vh-8rem)] w-full bg-slate-50/50 rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm">
        
        <!-- Mobile Backdrop Overlay -->
        <div 
            v-if="isLeftSidebarOpen || isRightSidebarOpen" 
            @click="closeDrawers"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[60] lg:hidden transition-opacity duration-300"
        ></div>

        <!-- LEFT SIDEBAR: Active Chats -->
        <aside 
            :class="[
                isLeftSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
                'fixed lg:relative left-0 top-0 h-full w-[280px] sm:w-80 bg-white border-r border-slate-200/80 flex flex-col z-[70] lg:z-10 transition-transform duration-300 ease-in-out flex-shrink-0'
            ]"
        >
            <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-white flex-shrink-0">
                <div class="flex items-center gap-2">
                    <h2 class="font-bold text-slate-800 text-lg tracking-tight">Messages</h2>
                    <span class="bg-indigo-50 text-indigo-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                        {{ activeChats.length }}
                    </span>
                </div>
                <button @click="isLeftSidebarOpen = false" class="lg:hidden text-slate-500 hover:text-slate-800 p-1 rounded-lg hover:bg-slate-100 transition">
                    ✕
                </button>
            </div>

            <div class="flex-1 overflow-y-auto divide-y divide-slate-50 custom-scrollbar">
                <slot name="active-chats">
                    <div v-if="activeChats.length === 0" class="p-6 text-center text-xs text-slate-400 font-medium">
                        No active conversations yet.
                    </div>
                    <div 
                        v-for="chat in activeChats" 
                        :key="chat.id"
                        @click="emit('select-chat', chat); isLeftSidebarOpen = false"
                        class="p-3.5 hover:bg-slate-50/80 cursor-pointer transition-all flex items-center gap-3 group"
                    >
                        <div class="relative flex-shrink-0">
                            <img :src="chat.avatar || '/default-avatar.png'" :alt="chat.name" class="w-11 h-11 rounded-full object-cover ring-2 ring-slate-100 group-hover:ring-indigo-100" />
                            <span 
                                v-if="chat.is_online" 
                                class="w-3 h-3 bg-emerald-500 border-2 border-white rounded-full absolute bottom-0 right-0 shadow-sm"
                            ></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-1">
                                <h4 class="text-sm font-semibold text-slate-800 truncate group-hover:text-indigo-600 transition-colors">{{ chat.name }}</h4>
                                <span class="text-[11px] text-slate-400 font-medium">{{ chat.last_message_time }}</span>
                            </div>
                            <p class="text-xs text-slate-500 truncate font-normal leading-tight">{{ chat.last_message }}</p>
                        </div>
                    </div>
                </slot>
            </div>
        </aside>

        <!-- CENTER: Main Chat Window -->
        <main class="flex-1 flex flex-col bg-white min-w-0 h-full relative overflow-hidden">
            
            <!-- Mobile Control Top Bar -->
            <div class="lg:hidden px-4 py-2 bg-white border-b border-slate-200/80 flex items-center justify-between z-10 flex-shrink-0">
                <button 
                    @click="isLeftSidebarOpen = true" 
                    class="flex items-center gap-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-xl transition"
                >
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <span>Chats</span>
                </button>

                <button 
                    @click="isRightSidebarOpen = true" 
                    class="flex items-center gap-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-xl transition"
                >
                    <span>Directory</span>
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>
            </div>

            <!-- Dynamic Chat Slot Target -->
            <div class="flex-1 flex flex-col min-h-0 overflow-hidden">
                <slot />
            </div>
        </main>

        <!-- RIGHT SIDEBAR: Users Directory -->
        <aside 
            :class="[
                isRightSidebarOpen ? 'translate-x-0' : 'translate-x-full lg:translate-x-0',
                'fixed lg:relative right-0 top-0 h-full w-[280px] sm:w-80 bg-white border-l border-slate-200/80 flex flex-col z-[70] lg:z-10 transition-transform duration-300 ease-in-out flex-shrink-0'
            ]"
        >
            <div class="p-4 border-b border-slate-100 space-y-3 bg-white flex-shrink-0">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 text-sm tracking-tight">User Directory</h3>
                    <button @click="isRightSidebarOpen = false" class="lg:hidden text-slate-500 hover:text-slate-800 p-1 rounded-lg hover:bg-slate-100 transition">
                        ✕
                    </button>
                </div>
                <div class="relative">
                    <input 
                        v-model="searchQuery" 
                        type="text" 
                        placeholder="Search members..."
                        class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                    />
                    <svg class="w-4 h-4 absolute left-3 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-3 space-y-1 divide-y divide-slate-50 custom-scrollbar">
                <div 
                    v-for="user in filteredUsers" 
                    :key="user.id" 
                    class="pt-2.5 first:pt-0 flex items-center justify-between gap-2 p-1.5 rounded-xl hover:bg-slate-50 transition"
                >
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="relative flex-shrink-0">
                            <img :src="user.avatar || '/default-avatar.png'" :alt="user.name" class="w-9 h-9 rounded-full object-cover ring-1 ring-slate-200" />
                            <span 
                                class="w-2.5 h-2.5 rounded-full border-2 border-white absolute bottom-0 right-0"
                                :class="user.is_online ? 'bg-emerald-500' : 'bg-slate-300'"
                            ></span>
                        </div>
                        <div class="truncate">
                            <p class="text-xs font-semibold text-slate-800 truncate">{{ user.name }}</p>
                            <span class="text-[9px] text-slate-400 uppercase font-semibold tracking-wider">
                                {{ user.is_online ? 'Online' : 'Offline' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-1 flex-shrink-0">
                        <button 
                            @click="emit('send-message', user); isRightSidebarOpen = false"
                            title="Send Message"
                            class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 8 9 8z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </aside>

    </div>
</template>