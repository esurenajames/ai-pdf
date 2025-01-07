<template>
    <div class="max-w-2xl">
      <h2 class="text-xl md:text-2xl font-semibold mb-6 md:mb-8">Profile</h2>
      
      <div class="space-y-8">
        <div>
          <label class="block mb-3 font-medium">Profile Picture</label>
          <div class="flex items-center space-x-6">
            <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-200">
              <img :src="avatarPreview || avatar || '/default-avatar.png'" alt="Profile" class="w-full h-full object-cover"/>
            </div>
            <button 
              @click="triggerAvatarInput"
              class="px-4 py-2 rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors duration-200 font-medium"
            >
              Change Avatar
            </button>
            <input 
              type="file" 
              ref="avatarFile" 
              @change="onAvatarChange" 
              class="hidden" 
              accept="image/*"
            />
          </div>
        </div>
  
        <div>
          <label class="block mb-3 font-medium">Display Name</label>
          <input 
            v-model="displayName" 
            type="text" 
            class="w-full px-4 py-2 border rounded-md"
            placeholder="Enter your display name"
          />
        </div>
  
        <div class="flex justify-start pt-4">
          <button 
            @click="saveProfile"
            :disabled="loading"
            class="px-6 py-2 rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors duration-200 font-medium"
          >
            {{ loading ? 'Saving...' : 'Save Changes' }}
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useForm, usePage } from '@inertiajs/vue3';
  
  const page = usePage();
  const displayName = ref(page.props.auth?.user?.name || '');
  const avatar = ref(page.props.auth?.user?.avatar || '/default-avatar.png');
  const avatarFile = ref(null);
  
  const triggerAvatarInput = () => {
  if (avatarFile.value) {
    avatarFile.value.click();
  } else {
    console.error('File input not found');
  }
};

  
  const onAvatarChange = (event) => {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        avatar.value = e.target.result;
      };
      avatarFile.value = file;
      reader.readAsDataURL(file);
    }
  };
  
  const saveProfile = () => {
    const form = useForm({
      name: displayName.value,
      avatar: avatarFile.value,
    });
  
    form.post(route('profile.update'), {
      onSuccess: () => {
        console.log('Profile updated!');
      },
      onError: (errors) => {
        console.error(errors);
      }
    });
  };
  </script>
  
  