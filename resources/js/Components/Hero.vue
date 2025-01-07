<template>
    <div 
      :class="[
        'flex flex-col md:flex-row items-center justify-center min-h-[600px] px-4 py-20 md:py-16',
        themeStore.theme === 'light' 
          ? 'bg-white text-black' 
          : 'bg-gray-900 text-gray-100'
      ]"
    >
      <!-- Left Column (Text) -->
      <div class="max-w-4xl text-center md:text-left space-y-6 md:w-1/2">
        <h1 
          :class="[
            'text-4xl md:text-6xl px-10 font-bold leading-tight',
            themeStore.theme === 'light' 
              ? 'text-gray-900' 
              : 'text-white'
          ]"
        >
          Turn Your PDFs Into Powerful Tools with Ease
        </h1>
        
        <p 
          :class="[
            'text-xl md:text-2xl max-w-3xl px-10 mx-auto md:mx-0',
            themeStore.theme === 'light' 
              ? 'text-gray-700' 
              : 'text-gray-300'
          ]"
        >
          From quizzes to conversions, we provide all the tools you need to work smarter and faster with PDFs.
        </p>
        
        <div class="flex justify-center md:justify-start space-x-4 px-10 mt-8">
          <a :href="route('login')"  
            :class="[
              'px-6 py-3 rounded-lg font-semibold transition duration-300 ease-in-out transform hover:scale-105',
              themeStore.theme === 'light'
                ? 'bg-blue-600 text-white hover:bg-blue-700'
                : 'bg-blue-500 text-white hover:bg-blue-600'
            ]"
          >
            Get Started
          </a>
          
          <button 
    :class="[
      'px-6 py-3 rounded-lg font-semibold border-2 transition duration-300 ease-in-out transform hover:scale-105',
      themeStore.theme === 'light'
        ? 'border-gray-300 text-gray-700 hover:bg-gray-100'
        : 'border-gray-700 text-gray-300 hover:bg-gray-800'
    ]"
  >
    <!-- Use a hash link to scroll to the section -->
    <a href="#how-it-works">Learn More</a>
        </button>
        </div>
      </div>
  
      <!-- Right Column (Image) -->
      <div class="md:w-1/2 mt-8 md:mt-0">
        <img 
          src="https://s.smallpdf.com/static/752cb6ca40d99602.svg" 
          alt="PDF Tools Image" 
          class="w-full h-auto object-cover rounded-lg shadow-lg"
        />
      </div>
    </div>
</template>

<script setup>
import { useThemeStore } from '../Stores/Theme';
const themeStore = useThemeStore();
</script>

<style scoped>
</style>