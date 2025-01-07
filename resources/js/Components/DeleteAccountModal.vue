<template>
    <div v-if="isOpen" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black opacity-50" @click="onClose"></div>
        
        <!-- Modal -->
        <div 
            class="relative w-full max-w-md rounded-lg shadow-lg"
            :class="themeStore.theme === 'light' ? 'bg-white' : 'bg-gray-800'"
        >
            <div class="p-6">
            <h3 class="text-xl font-semibold mb-4 text-red-600">
                Delete Account
            </h3>
            
            <div 
                class="mb-6"
                :class="themeStore.theme === 'light' ? 'text-gray-600' : 'text-gray-300'"
            >
                <p class="mb-4">Are you sure you want to delete your account? This action cannot be undone.</p>
                <p>Please type <strong>DELETE</strong> to confirm.</p>
            </div>

            <input 
                v-model="confirmText"
                type="text"
                class="w-full px-4 py-2 border rounded-md mb-6"
                :class="[
                themeStore.theme === 'light' 
                    ? 'border-gray-300 bg-white' 
                    : 'border-gray-700 bg-gray-800 text-white'
                ]"
                placeholder="Type DELETE to confirm"
            />

            <div class="flex justify-end space-x-3">
                <button 
                @click="onClose"
                class="px-4 py-2 rounded-md font-medium"
                :class="themeStore.theme === 'light'
                    ? 'bg-gray-200 text-gray-800 hover:bg-gray-300'
                    : 'bg-gray-700 text-gray-200 hover:bg-gray-600'"
                >
                Cancel
                </button>
                <button 
                @click="handleDelete"
                :disabled="confirmText !== 'DELETE'"
                class="px-4 py-2 rounded-md font-medium text-white"
                :class="[
                    confirmText === 'DELETE'
                    ? 'bg-red-600 hover:bg-red-700'
                    : 'bg-red-300 cursor-not-allowed'
                ]"
                >
                Delete Account
                </button>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useThemeStore } from '../Stores/Theme'

const themeStore = useThemeStore()
const confirmText = ref('')

const props = defineProps({
isOpen: {
    type: Boolean,
    required: true
}
})

const emit = defineEmits(['close', 'delete'])

const onClose = () => {
emit('close')
confirmText.value = ''
}

const handleDelete = () => {
if (confirmText.value === 'DELETE') {
    emit('delete')
    onClose()
}
}
</script>
