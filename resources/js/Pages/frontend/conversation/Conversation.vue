<script setup>
import { ref, computed, watch, nextTick, onMounted } from 'vue';
import ConversationLayout from '../../../Layout/frontend/ConversationLayout.vue';

const props = defineProps({
    message: {
        type: String,
        default: ''
    },
    currentUserId: {
        type: [Number, String],
        default: 1
    },
    messages: {
        type: Array,
        default: () => []
    },
    users: {
        type: Array,
        default: () => []
    },
    activeChats: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['send-message', 'load-more']);

// Dummy Data
const dummyCurrentUserId = 1;

const localMessages = ref([
    { id: 1, sender_id: 2, body: 'Hey! How is the Laravel 13 project going?', created_at: '10:00 AM' },
    { id: 2, sender_id: 1, body: 'Going great! Building the real-time chat feature with Inertia & Vue.', created_at: '10:02 AM' },
    { id: 3, sender_id: 2, body: 'Awesome! Did you implement SOLID principles for layout architecture?', created_at: '10:05 AM' },
    { id: 4, sender_id: 1, body: 'Yes, kept it completely modular with proper state propagation.', created_at: '10:06 AM' },
    { id: 5, sender_id: 2, body: 'Sounds super solid. Are you using Reverb or WebSockets?', created_at: '10:08 AM' },
    { id: 6, sender_id: 1, body: 'Using Reverb! It handles broadcasting seamlessly.', created_at: '10:10 AM' },
    { id: 7, sender_id: 2, body: 'Great choice! Let me know if you need database indexing tips.', created_at: '10:12 AM' },
    { id: 8, sender_id: 1, body: 'Sure thing! Testing the mobile overflow UI and drawers right now.', created_at: '10:15 AM' },
    { id: 9, sender_id: 2, body: 'Awesome, the UX is super responsive now!', created_at: '10:16 AM' }
]);

const dummyUsers = [
    { id: 2, name: 'Tanvir Ahmed', avatar: 'https://i.pravatar.cc/150?u=2', is_online: true },
    { id: 3, name: 'Rahim Chowdhury', avatar: 'https://i.pravatar.cc/150?u=3', is_online: false },
    { id: 4, name: 'Ayesha Siddiqua', avatar: 'https://i.pravatar.cc/150?u=4', is_online: true }
];

const dummyActiveChats = [
    { id: 1, name: 'Tanvir Ahmed', avatar: 'https://i.pravatar.cc/150?u=2', is_online: true, last_message: 'Awesome, the UX is super responsive now!', last_message_time: '10:16 AM' }
];

const displayMessages = computed(() => props.messages.length ? props.messages : localMessages.value);
const displayUsers = computed(() => props.users.length ? props.users : dummyUsers);
const displayActiveChats = computed(() => props.activeChats.length ? props.activeChats : dummyActiveChats);
const activeUserId = computed(() => props.currentUserId || dummyCurrentUserId);

const newMessage = ref('');
const messagesContainer = ref(null);

const scrollToBottom = () => {
    nextTick(() => {
        if (messagesContainer.value) {
            messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
        }
    });
};

onMounted(() => {
    scrollToBottom();
});

watch(displayMessages, () => {
    scrollToBottom();
}, { deep: true });

const handleSend = () => {
    if (!newMessage.value.trim()) return;

    if (!props.messages.length) {
        localMessages.value.push({
            id: Date.now(),
            sender_id: activeUserId.value,
            body: newMessage.value,
            created_at: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        });
    }

    emit('send-message', newMessage.value);
    newMessage.value = '';
    scrollToBottom();
};

const handleKeydown = (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        handleSend();
    }
};

const handleScroll = (e) => {
    if (e.target.scrollTop === 0) {
        emit('load-more');
    }
};
</script>

<template>
    <ConversationLayout :users="displayUsers" :activeChats="displayActiveChats">
        <!-- Main Chat Parent Container -->
        <div class="flex flex-col h-full bg-slate-50/30 relative min-w-0 overflow-hidden">
            
            <!-- 1. Chat Header (Fixed at top) -->
            <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between bg-white/80 backdrop-blur z-10 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <img src="https://i.pravatar.cc/150?u=2" alt="Avatar" class="w-8 h-8 rounded-full object-cover ring-2 ring-indigo-50" />
                    <div>
                        <h1 class="text-xs sm:text-sm font-bold text-slate-800 leading-none">{{ message || 'Tanvir Ahmed' }}</h1>
                        <span class="text-[10px] text-emerald-600 font-semibold flex items-center gap-1 mt-1">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Online
                        </span>
                    </div>
                </div>
            </div>

            <!-- 2. Scrollable Messages Area (Takes up remaining height) -->
            <div 
                ref="messagesContainer" 
                @scroll="handleScroll"
                class="flex-1 overflow-y-auto p-3 sm:p-4 space-y-3.5 custom-scrollbar min-h-0"
            >
                <div v-if="displayMessages.length === 0" class="flex h-full items-center justify-center text-slate-400 text-xs">
                    No messages yet. Start conversation!
                </div>

                <template v-else>
                    <div 
                        v-for="msg in displayMessages" 
                        :key="msg.id" 
                        class="flex flex-col"
                        :class="msg.sender_id === activeUserId ? 'items-end' : 'items-start'"
                    >
                        <div 
                            class="max-w-[85%] sm:max-w-[70%] md:max-w-[60%] rounded-2xl px-3.5 py-2 text-xs sm:text-sm shadow-sm space-y-1"
                            :class="msg.sender_id === activeUserId 
                                ? 'bg-indigo-600 text-white rounded-br-xs' 
                                : 'bg-white text-slate-800 border border-slate-100 rounded-bl-xs'"
                        >
                            <p class="whitespace-pre-wrap break-words leading-relaxed">{{ msg.body }}</p>
                            <span 
                                class="text-[9px] block text-right font-medium"
                                :class="msg.sender_id === activeUserId ? 'text-indigo-200' : 'text-slate-400'"
                            >
                                {{ msg.created_at }}
                            </span>
                        </div>
                    </div>
                </template>
            </div>

            <!-- 3. Fixed Typing Footer Box (Pinned at bottom, flex-shrink-0) -->
            <div class="p-2.5 sm:p-3 border-t border-slate-200/80 bg-white flex-shrink-0">
                <form @submit.prevent="handleSend" class="flex items-center gap-2">
                    <div class="flex-1 relative">
                        <textarea 
                            v-model="newMessage"
                            @keydown="handleKeydown"
                            rows="1"
                            placeholder="Type a message..."
                            class="w-full resize-none max-h-24 min-h-[38px] py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                        ></textarea>
                    </div>

                    <button 
                        type="submit" 
                        :disabled="!newMessage.trim()"
                        class="bg-indigo-600 hover:bg-indigo-700 disabled:opacity-40 disabled:cursor-not-allowed text-white p-2.5 rounded-xl transition flex items-center justify-center flex-shrink-0 shadow-sm"
                    >
                        <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
            </div>

        </div>
    </ConversationLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>