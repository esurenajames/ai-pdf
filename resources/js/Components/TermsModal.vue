<template>
    <teleport to="body">
      <transition 
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div 
          v-if="modelValue" 
          class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 overflow-y-auto"
          @click.self="close(false)"
        >
          <div 
            class="w-full max-w-2xl mx-auto rounded-2xl shadow-2xl transform transition-all overflow-hidden"
            :class="[
              themeStore.theme === 'light' 
                ? 'bg-white border border-gray-200' 
                : 'bg-gray-800 border border-gray-700'
            ]"
            @click.stop
          >
            <div class="p-8">
              <div class="flex justify-between items-center mb-6">
                <h2 
                  class="text-2xl font-bold tracking-tight"
                  :class="themeStore.theme === 'light' ? 'text-gray-900' : 'text-gray-100'"
                >
                  Terms and Conditions
                </h2>
                <button 
                  @click="close(false)" 
                  class="text-gray-500 hover:text-gray-700 focus:outline-none transition-colors"
                  aria-label="Close modal"
                >
                  <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    class="h-7 w-7" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor"
                  >
                    <path 
                      stroke-linecap="round" 
                      stroke-linejoin="round" 
                      stroke-width="2" 
                      d="M6 18L18 6M6 6l12 12" 
                    />
                  </svg>
                </button>
              </div>
              
              <div 
                class="prose max-h-[500px] overflow-y-auto pr-4 space-y-6"
                :class="themeStore.theme === 'light' ? 'text-gray-700' : 'text-gray-300'"
              >
                <div v-for="(section, index) in termsSections" :key="index" class="mb-4">
                  <h3 class="text-lg font-semibold mb-3">
                    {{ section.title }}
                  </h3>
                  <p>{{ section.content }}</p>
                </div>
              </div>
              
              <div class="mt-8 flex justify-end space-x-4 pt-6">
                <button 
                  @click="close(false)" 
                  class="px-5 py-2.5 rounded-lg text-sm font-medium transition-colors"
                  :class="[
                    themeStore.theme === 'light'
                      ? 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                      : 'bg-gray-700 text-gray-300 hover:bg-gray-600'
                  ]"
                >
                  Cancel
                </button>
                <button 
                  @click="close(true)" 
                  class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors"
                  :class="[
                    themeStore.theme === 'dark'
                      ? 'bg-blue-700 text-white hover:bg-blue-800'
                      : 'bg-blue-600 text-white hover:bg-blue-700'
                  ]"
                >
                  Accept
                </button>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </teleport>
  </template>
  
  <script setup>
  import { useThemeStore } from '../Stores/Theme';
  import { ref } from 'vue';
  
  const themeStore = useThemeStore();
  
  const termsSections = ref([
    {
      title: '1. Introduction',
      content: 'These terms and conditions govern your use of our website and services. By accessing or using our platform, you agree to be bound by these terms.'
    },
    {
      title: '2. User Responsibilities',
      content: 'You are responsible for maintaining the confidentiality of your account and for all activities that occur under your account.'
    },
    {
      title: '3. Privacy',
      content: 'We are committed to protecting your privacy. Please review our Privacy Policy to understand our practices.'
    },
    {
      title: '4. Intellectual Property',
      content: 'All content on this platform is protected by copyright and other intellectual property laws.'
    },
    {
      title: '5. Limitation of Liability',
      content: 'Our platform provides services "as is" and we are not liable for any direct, indirect, or consequential damages arising from your use of our services.'
    }
  ]);
  
  const props = defineProps({
    modelValue: {
      type: Boolean,
      default: false
    }
  });
  
  const emit = defineEmits(['update:modelValue', 'accepted', 'cancelled']);
  
  const close = (accepted) => {
    emit('update:modelValue', false);
    
    if (accepted) {
      emit('accepted');
    } else {
      emit('cancelled');
    }
  };
  </script>