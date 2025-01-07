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
            <h3 
                class="text-lg font-semibold mb-4"
                :class="themeStore.theme === 'light' ? 'text-gray-900' : 'text-gray-100'"
            >
                Change Email Address
            </h3>
            
            <div class="space-y-4">
                <div>
                <label 
                    class="block mb-2 font-medium"
                    :class="themeStore.theme === 'light' ? 'text-gray-700' : 'text-gray-300'"
                >
                    New Email
                </label>
                <input 
                    v-model="newEmail" 
                    type="email" 
                    class="w-full px-4 py-2 border rounded-md"
                    :class="[
                    themeStore.theme === 'light' 
                        ? 'border-gray-300 bg-white' 
                        : 'border-gray-700 bg-gray-800 text-white'
                    ]"
                    placeholder="Enter new email"
                />
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
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
                @click="handleSubmit"
                class="px-4 py-2 rounded-md font-medium bg-blue-500 text-white hover:bg-blue-600"
                >
                Update Email
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
const newEmail = ref('')

const props = defineProps({
isOpen: {
    type: Boolean,
    required: true
}
})

const emit = defineEmits(['close', 'submit'])

const onClose = () => {
emit('close')
newEmail.value = ''
}

const handleSubmit = () => {
emit('submit', newEmail.value)
onClose()
}
</script>