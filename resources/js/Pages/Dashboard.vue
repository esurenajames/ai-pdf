<template>
  <div 
    class="min-h-screen p-8"
    :class="[
      themeStore.theme === 'light'
        ? 'bg-gray-100 text-gray-900'
        : 'bg-gray-900 text-gray-100'
    ]"
  >
    <div class="container mx-auto">
      <h1 
        class="text-3xl font-bold mb-8 text-center"
        :class="themeStore.theme === 'light' ? 'text-gray-800' : 'text-white'"
      >
        Dashboard
      </h1>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Quiz Maker Card -->
        <div 
          class="rounded-lg shadow-lg p-6 transform transition-all duration-300 hover:scale-105"
          :class="[
            themeStore.theme === 'light' 
              ? 'bg-white border border-gray-200 hover:shadow-xl' 
              : 'bg-gray-800 border border-gray-700 hover:shadow-2xl'
          ]"
        >
          <div class="flex items-center mb-4">
            <div 
              class="w-16 h-16 rounded-full flex items-center justify-center mr-4"
              :class="themeStore.theme === 'light' ? 'bg-blue-100' : 'bg-blue-900'"
            >
              <svg 
                xmlns="http://www.w3.org/2000/svg" 
                class="h-8 w-8"
                :class="themeStore.theme === 'light' ? 'text-blue-600' : 'text-blue-400'"
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
              >
                <path 
                  stroke-linecap="round" 
                  stroke-linejoin="round" 
                  stroke-width="2" 
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                />
              </svg>
            </div>
            <h2 
              class="text-xl font-semibold"
              :class="themeStore.theme === 'light' ? 'text-gray-800' : 'text-white'"
            >
              Quiz Maker
            </h2>
          </div>
          <p 
            class="mb-4"
            :class="themeStore.theme === 'light' ? 'text-gray-600' : 'text-gray-300'"
          >
            Create, customize, and manage interactive quizzes with ease. Design assessments for learning, training, or engagement.
          </p>
          <Link 
            :href="route('quiz')"
            class="w-full block text-center px-4 py-2 rounded-md transition-colors duration-300"
            :class="[
              themeStore.theme === 'light'
                ? 'bg-blue-500 text-white hover:bg-blue-600'
                : 'bg-blue-700 text-white hover:bg-blue-800'
            ]"
          >
            Create Quiz
          </Link>
        </div>

        <!-- PDF Converter Card -->
        <div 
          class="rounded-lg shadow-lg p-6 transform transition-all duration-300 hover:scale-105"
          :class="[
            themeStore.theme === 'light' 
              ? 'bg-white border border-gray-200 hover:shadow-xl' 
              : 'bg-gray-800 border border-gray-700 hover:shadow-2xl'
          ]"
        >
          <div class="flex items-center mb-4">
            <div 
              class="w-16 h-16 rounded-full flex items-center justify-center mr-4"
              :class="themeStore.theme === 'light' ? 'bg-green-100' : 'bg-green-900'"
            >
              <svg 
                xmlns="http://www.w3.org/2000/svg" 
                class="h-8 w-8"
                :class="themeStore.theme === 'light' ? 'text-green-600' : 'text-green-400'"
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
              >
                <path 
                  stroke-linecap="round" 
                  stroke-linejoin="round" 
                  stroke-width="2" 
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
              </svg>
            </div>
            <h2 
              class="text-xl font-semibold"
              :class="themeStore.theme === 'light' ? 'text-gray-800' : 'text-white'"
            >
              PDF Converter
            </h2>
          </div>
          <p 
            class="mb-4"
            :class="themeStore.theme === 'light' ? 'text-gray-600' : 'text-gray-300'"
          >
            Convert various document types to PDF format quickly and securely. Support for multiple file types and easy processing.
          </p>
          <Link 
            :href="route('convert')"
            class="w-full block text-center px-4 py-2 rounded-md transition-colors duration-300"
            :class="[
              themeStore.theme === 'light'
                ? 'bg-green-500 text-white hover:bg-green-600'
                : 'bg-green-700 text-white hover:bg-green-800'
            ]"
          >
            Convert Documents
          </Link>
        </div>

        <!-- WebP Converter Card -->
        <div 
          class="rounded-lg shadow-lg p-6 transform transition-all duration-300 hover:scale-105"
          :class="[
            themeStore.theme === 'light' 
              ? 'bg-white border border-gray-200 hover:shadow-xl' 
              : 'bg-gray-800 border border-gray-700 hover:shadow-2xl'
          ]"
        >
          <div class="flex items-center mb-4">
            <div 
              class="w-16 h-16 rounded-full flex items-center justify-center mr-4"
              :class="themeStore.theme === 'light' ? 'bg-purple-100' : 'bg-purple-900'"
            >
              <svg 
                xmlns="http://www.w3.org/2000/svg" 
                class="h-8 w-8"
                :class="themeStore.theme === 'light' ? 'text-purple-600' : 'text-purple-400'"
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
              >
                <path 
                  stroke-linecap="round" 
                  stroke-linejoin="round" 
                  stroke-width="2" 
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                />
              </svg>
            </div>
            <h2 
              class="text-xl font-semibold"
              :class="themeStore.theme === 'light' ? 'text-gray-800' : 'text-white'"
            >
              WebP Converter
            </h2>
          </div>
          <p 
            class="mb-4"
            :class="themeStore.theme === 'light' ? 'text-gray-600' : 'text-gray-300'"
          >
            Convert WebP images to various formats like PNG, JPG, GIF, and JPEG. Quick and easy image format conversion.
          </p>
          <Link 
            :href="route('image')"
            class="w-full block text-center px-4 py-2 rounded-md transition-colors duration-300"
            :class="[
              themeStore.theme === 'light'
                ? 'bg-purple-500 text-white hover:bg-purple-600'
                : 'bg-purple-700 text-white hover:bg-purple-800'
            ]"
          >
            Convert Images
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>
 
<script setup>
import { Link } from '@inertiajs/vue3';
import { useThemeStore } from '../Stores/Theme';
 
const themeStore = useThemeStore();
</script>