<template>
    <div class="max-w-2xl">
      <h2 class="text-2xl font-semibold mb-8">Account Settings</h2>
  
      <div class="space-y-8">
        <div class="space-y-4">
          <h3 class="text-lg font-semibold mb-4">Email Address</h3>
          <div class="flex items-center justify-between">
            <span>{{ currentEmail }}</span>
          </div>
        </div>
  
        <div class="pt-8 border-t space-y-4 border-gray-200">
          <h3 class="text-lg font-semibold mb-4">Change Password</h3>
          
          <div>
            <label class="block mb-2 font-medium">Current Password</label>
            <div class="relative">
            <input 
                v-model="currentPassword" 
                :type="currentPasswordVisible ? 'text' : 'password'" 
                class="w-full px-4 py-2 border rounded-md pr-10"
                placeholder="Enter current password"
            />
            <button
                type="button"
                @click="currentPasswordVisible = !currentPasswordVisible"
                class="absolute right-2 top-1/2 -translate-y-1/2 focus:outline-none text-gray-500"
            >
                <svg
                v-if="!currentPasswordVisible"
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                />
                </svg>
                <svg
                v-else
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                />
                </svg>
            </button>
            </div>
        </div>

        <div>
            <label class="block mb-2 font-medium">New Password</label>
            <div class="relative">
            <input 
                v-model="newPassword" 
                :type="newPasswordVisible ? 'text' : 'password'" 
                class="w-full px-4 py-2 border rounded-md pr-10"
                placeholder="Enter new password"
            />
            <button
                type="button"
                @click="newPasswordVisible = !newPasswordVisible"
                class="absolute right-2 top-1/2 -translate-y-1/2 focus:outline-none text-gray-500"
            >
                <svg
                v-if="!newPasswordVisible"
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                />
                </svg>
                <svg
                v-else
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                />
                </svg>
            </button>
            </div>
        </div>

        <div>
            <label class="block mb-2 font-medium">Confirm New Password</label>
            <div class="relative">
            <input 
                v-model="confirmPassword" 
                :type="confirmPasswordVisible ? 'text' : 'password'" 
                class="w-full px-4 py-2 border rounded-md pr-10"
                placeholder="Confirm new password"
            />
            <button
                type="button"
                @click="confirmPasswordVisible = !confirmPasswordVisible"
                class="absolute right-2 top-1/2 -translate-y-1/2 focus:outline-none text-gray-500"
            >
                <svg
                v-if="!confirmPasswordVisible"
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                />
                </svg>
                <svg
                v-else
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                />
                </svg>
            </button>
            </div>
        </div>
  
          <div class="flex justify-start">
            <button 
              @click="savePassword"
              class="px-6 py-2 rounded-md mt-4 bg-blue-500 text-white hover:bg-blue-600 transition-colors duration-200 font-medium"
            >
              Update Password
            </button>
          </div>
        </div>
  
        <div class="pt-8 mt-8 border-t border-gray-200">
          <h3 class="text-lg font-semibold mb-4 text-red-600">Delete Account</h3>
          <p class="mb-4 text-gray-600">
            Once you delete your account, there is no going back. Please be certain.
          </p>
          <button 
            @click="$emit('open-delete-modal')"
            class="px-6 py-2 rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors duration-200 font-medium"
          >
            Delete Account
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  import { usePage } from '@inertiajs/vue3';
  
  const page = usePage();
  const currentEmail = computed(() => page.props.auth?.user?.email || 'No email set');
  
  const currentPassword = ref('');
  const newPassword = ref('');
  const confirmPassword = ref('');
  const currentPasswordVisible = ref(false);
  const newPasswordVisible = ref(false);
  const confirmPasswordVisible = ref(false);
  
  const savePassword = async () => {
    if (newPassword.value !== confirmPassword.value) {
      alert('New passwords do not match!');
      return;
    }
    console.log('Updating password...', {
      currentPassword: currentPassword.value,
      newPassword: newPassword.value
    });
  };
  
  defineEmits(['open-delete-modal']);
  </script>