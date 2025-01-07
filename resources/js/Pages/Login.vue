<template>
    <Head title="Login -"></Head>
    <div 
      class="min-h-screen flex items-center justify-center p-4"
      :class="[
        themeStore.theme === 'light' 
          ?'bg-gray-100 text-gray-900'
          :'bg-gray-900 text-gray-100'
      ]"
    >
      <div 
        class="w-full max-w-lg rounded-lg shadow-md py-14 px-8"
        :class="[
          themeStore.theme === 'light'
            ?'bg-white border border-gray-200'
            :'bg-gray-800 border border-gray-700'
        ]"
      >
        <h2 
          class="text-2xl font-bold text-center mb-6"
          :class="themeStore.theme === 'light' ? 'text-gray-900' : 'text-zinc-100'"
        >
          Sign in to your account
        </h2>
    
        <form @submit.prevent="submit" class="space-y-6">
        <!-- Email Field -->
        <div>
          <label
            for="email"
            class="block text-sm font-medium mb-2"
            :class="themeStore.theme === 'light' ? 'text-gray-900' : 'text-zinc-100'"
          >
            Email address
          </label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            class="w-full px-3 py-2 rounded-md"
            :class="[
              themeStore.theme === 'light'
                ? 'bg-white text-gray-900 border border-gray-300'
                : 'bg-gray-700 text-zinc-100 border-gray-600',
              form.errors.email ? 'border-red-500' : ''
            ]"
          />
          <small v-if="form.errors.email" class="text-sm text-red-700">{{ form.errors.email }}</small>
        </div>

        <!-- Password Field -->
        <div>
          <label
            for="password"
            name="password"
            class="block text-sm font-medium mb-2"
            :class="themeStore.theme === 'light' ? 'text-gray-900' : 'text-zinc-100'"
          >
            Password
          </label>
          <div class="relative">
            <input
              id="password"
              :type="passwordVisible ? 'text' : 'password'"
              v-model="form.password"
              required
              class="w-full px-3 py-2 rounded-md pr-10"
              :class="[
                themeStore.theme === 'light'
                  ? 'bg-white text-gray-900 border border-gray-300'
                  : 'bg-gray-700 text-zinc-100 border-gray-600',
                form.errors.password ? 'border-red-500' : ''
              ]"
            />
            <button
              type="button"
              @click="togglePasswordVisibility"
              class="absolute right-2 top-1/2 -translate-y-1/2 focus:outline-none"
              :class="themeStore.theme === 'dark' ? 'text-gray-400' : 'text-gray-500'"
            >
              <svg
                v-if="!passwordVisible"
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
          <small v-if="form.errors.password" class="text-sm text-red-700">{{ form.errors.password }}</small>
        </div>
    
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input 
                id="rememberMe" 
                v-model="form.rememberMe"
                type="checkbox" 
                class="mr-2"
              />
              <label 
                for="rememberMe" 
                class="text-sm"
                :class="themeStore.theme === 'light' ? 'text-gray-700' : 'text-gray-300' "
              >
                Remember me
              </label>
            </div>
            <Link
              :href="route('login')" 
              class="text-sm font-medium cursor-pointer"
              :class="themeStore.theme === 'light' ? 'text-blue-500' : 'text-blue-400'"
            >
              Forgot password?
            </Link>
          </div>
    
          <button 
            type="submit" 
            class="w-full py-2 rounded-md text-sm font-semibold"
            :class="[
              themeStore.theme === 'light'
                ?'bg-blue-600 text-white'
                :'bg-blue-700 text-white'
            ]"
          >
            Sign In
          </button>
        </form>
    
        <p 
          class="mt-8 text-center text-sm"
          :class="themeStore.theme === 'light' ? 'text-gray-600' : 'text-gray-400'"
        >
          Don't have an account? 
          <Link
            :href="route('signup')"  
            class="font-medium cursor-pointer"
            :class="themeStore.theme === 'light' ? 'text-blue-500' : 'text-blue-400'"
          >
            Sign up
          </Link>
        </p>
      </div>
    </div>
</template>
    
<script setup>
import { ref } from 'vue';
import { useThemeStore } from '../Stores/Theme';
import { Head, Link, useForm } from '@inertiajs/vue3';

const themeStore = useThemeStore();

const form = useForm({
    email: localStorage.getItem('rememberedEmail') || '', 
    password: '',
    rememberMe: false,
    passwordVisible: false,
});

const passwordVisible = ref(false);

const togglePasswordVisibility = () => {
    passwordVisible.value = !passwordVisible.value;
};

const submit = () => {
  if (form.rememberMe) {
    localStorage.setItem('rememberedEmail', form.email);
  } else {
    localStorage.removeItem('rememberedEmail');
  }

  form.post('/login', {
    onError: () => {
      form.password = ''; // Clear password on error
    }
  });
};

</script>