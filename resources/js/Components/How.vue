<template>
   <div 
    ref="howSection" 
    :class="[ 
      'w-full mx-auto px-10 md:px-64 py-16',
      themeStore.theme === 'light' 
        ? 'bg-white text-black' 
        : 'bg-gray-900 text-gray-100'
    ]"
    >
        <div class="container mx-auto">
    <div class="text-center mb-12">
      <h2 
        :class="[
          'text-3xl md:text-4xl font-bold mb-4',
          themeStore.theme === 'light' 
            ? 'text-gray-900' 
            : 'text-white'
        ]"
      >
        How It Works
      </h2>
      <p 
        :class="[
          'text-lg max-w-2xl mx-auto',
          themeStore.theme === 'light' 
            ? 'text-gray-700' 
            : 'text-gray-300'
        ]"
      >
        Transform your PDFs with just a few simple steps. Our AI-powered platform makes document management effortless.
      </p>
    </div>

    <div class="relative">
      <div class="relative grid md:grid-cols-1 gap-8 max-w-4xl mx-auto">
        <div 
          v-for="(step, index) in steps" 
          :key="index"
          class="relative z-10"
        >
          <div 
            :class="[
              'flex items-center space-x-6 bg-opacity-90 p-6 rounded-lg',
              'md:flex-row transform transition ease-in-out duration-300 hover:scale-110',
              themeStore.theme === 'light'
                ? 'bg-white shadow-md border border-gray-100'
                : 'bg-gray-800 border border-gray-700'
            ]"
          >
            <div 
              :class="[
                'w-16 h-16 flex items-center justify-center rounded-full font-bold text-2xl',
                themeStore.theme === 'light'
                  ? 'bg-blue-50 text-blue-600'
                  : 'bg-blue-900 text-blue-300'
              ]"
            >
              {{ step.number }}
            </div>
            <div class="flex-1">
              <h3 
                :class="[
                  'text-xl font-semibold mb-2',
                  themeStore.theme === 'light' 
                    ? 'text-gray-900' 
                    : 'text-white'
                ]"
              >
                {{ step.title }}
              </h3>
              <p 
                :class="[
                  'text-base',
                  themeStore.theme === 'light' 
                    ? 'text-gray-700' 
                    : 'text-gray-300'
                ]"
              >
                {{ step.description }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
   </div>
</template>

<script setup>
import { useThemeStore } from '../Stores/Theme';
const themeStore = useThemeStore();

const steps = [
  {
    number: '01',
    title: 'Upload Your PDF',
    description: 'Easily upload any PDF document through our intuitive interface. Supported formats include educational materials, lecture notes, reports, and more.',
    icon: 'upload'
  },
  {
    number: '02',
    title: 'AI Analyzes Content',
    description: 'Our advanced AI algorithms scan and analyze the document, extracting key information, topics, and potential quiz elements.',
    icon: 'search'
  },
  {
    number: '03',
    title: 'Choose Your Tool',
    description: 'Select from multiple AI-powered tools: Quiz Generator, Document Converter, PDF Optimizer, or other specialized features.',
    icon: 'tools'
  },
  {
    number: '04',
    title: 'Customize and Generate',
    description: 'Refine the AI-generated output. Adjust quiz difficulty, question types, convert file formats, or optimize document settings.',
    icon: 'settings'
  },
  {
    number: '05',
    title: 'Download and Use',
    description: 'Instantly download your transformed document. Whether it\'s a quiz, converted file, or optimized PDF, it\'s ready to use.',
    icon: 'download'
  }
];
</script>

<style scoped>
/* Additional custom styles can be added here if needed */
</style>