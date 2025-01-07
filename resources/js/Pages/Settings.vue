<template>
    <div 
      class="min-h-screen p-4 md:p-8"
      :class="themeStore.theme === 'light' ? 'bg-gray-100 text-gray-900' : 'bg-gray-900 text-gray-100'"
    >
      <div class="container mx-auto max-w-5xl">
        <div class="flex flex-col md:flex-row md:gap-8">
          <!-- Navigation -->
          <div class="w-full md:w-64 mb-6 md:mb-0">
            <nav 
              class="space-y-1 rounded-lg shadow-md p-4 md:sticky md:top-8"
              :class="themeStore.theme === 'light' ? 'bg-white' : 'bg-gray-700'"
            >
              <div class="flex md:flex-col gap-2">
                <a 
                  href="#" 
                  class="flex-1 md:flex-none block px-4 py-2 rounded-md transition-colors duration-200 font-medium text-center md:text-left"
                  :class="currentTab === 'profile' 
                    ? (themeStore.theme === 'light' ? 'bg-blue-500 text-white' : 'bg-blue-700 text-white')
                    : (themeStore.theme === 'light' ? 'text-gray-700 hover:bg-gray-100' : 'text-gray-200 hover:bg-gray-600')"
                  @click.prevent="currentTab = 'profile'"
                >
                  Profile
                </a>
                <a 
                  href="#" 
                  class="flex-1 md:flex-none block px-4 py-2 rounded-md transition-colors duration-200 font-medium text-center md:text-left"
                  :class="currentTab === 'account' 
                    ? (themeStore.theme === 'light' ? 'bg-blue-500 text-white' : 'bg-blue-700 text-white')
                    : (themeStore.theme === 'light' ? 'text-gray-700 hover:bg-gray-100' : 'text-gray-200 hover:bg-gray-600')"
                  @click.prevent="currentTab = 'account'"
                >
                  Account Settings
                </a>
              </div>
            </nav>
          </div>
  
          <!-- Main Content -->
          <div class="flex-1">
            <div 
              class="rounded-lg shadow-md p-4 md:p-8"
              :class="themeStore.theme === 'light' ? 'bg-white' : 'bg-gray-700'"
            >
              <ProfileSettings v-if="currentTab === 'profile'" />
              <AccountSettings 
                v-if="currentTab === 'account'"
                @open-delete-modal="isDeleteModalOpen = true"
              />
            </div>
          </div>
        </div>
      </div>
  
      <ChangeEmailModal 
        :is-open="isEmailModalOpen"
        @close="isEmailModalOpen = false"
        @submit="handleEmailChange"
      />
  
      <DeleteAccountModal
        :is-open="isDeleteModalOpen"
        @close="isDeleteModalOpen = false"
        @delete="handleAccountDeletion"
      />
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useThemeStore } from '../Stores/Theme';
  import ProfileSettings from '../Components/ProfileSettings.vue';
  import AccountSettings from '../Components/AccountSettings.vue';
  import ChangeEmailModal from '../Components/ChangeEmailModal.vue';
  import DeleteAccountModal from '../Components/DeleteAccountModal.vue';
  
  const themeStore = useThemeStore();
  const currentTab = ref('profile');
  const isEmailModalOpen = ref(false);
  const isDeleteModalOpen = ref(false);
  
  const handleEmailChange = async (newEmail) => {
    console.log('Updating email...', { newEmail });
  };
  
  const handleAccountDeletion = async () => {
    console.log('Deleting account...');
  };
  </script>