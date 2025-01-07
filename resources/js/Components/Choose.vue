<template>
   <div 
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
                Why Choose Us?
                </h2>
                <p 
                :class="[
                    'text-lg max-w-3xl mx-auto',
                    themeStore.theme === 'light' 
                    ? 'text-gray-700' 
                    : 'text-gray-300'
                ]"
                >
                Revolutionizing PDF workflow with intelligent, user-centric solutions.
                </p>
            </div>
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div 
                v-for="(feature, index) in whyChooseFeatures" 
                :key="index"
                :class="[
                    'p-6 rounded-lg shadow-md transform transition ease-in-out duration-300 hover:scale-105',
                    themeStore.theme === 'light'
                    ? 'bg-white hover:bg-blue-50'
                    : 'bg-gray-700 hover:bg-gray-600'
                ]"
                >
                <div class="flex items-center space-x-4 mb-4">
                    <div 
                    :class="[
                        'p-3 rounded-full',
                        themeStore.theme === 'light'
                        ? 'bg-blue-100 text-blue-600'
                        : 'bg-blue-900 text-blue-300'
                    ]"
                    >
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <!-- CheckBadgeIcon -->
                        <path 
                        v-if="feature.icon === 'CheckBadgeIcon'"
                        fill-rule="evenodd" 
                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" 
                        clip-rule="evenodd" 
                        />
                        
                        <!-- SparklesIcon -->
                        <path 
                        v-else-if="feature.icon === 'SparklesIcon'"
                        fill-rule="evenodd" 
                        d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744l.708 2.836 2.836.708a1 1 0 01.054 1.91l-2.836.708-.708 2.836a1 1 0 01-1.91.054l-.708-2.836-2.836-.708a1 1 0 01-.054-1.91l2.836-.708.708-2.836A1 1 0 0112 2z" 
                        clip-rule="evenodd" 
                        />
                        
                        <!-- TrophyIcon -->
                        <path 
                        v-else-if="feature.icon === 'TrophyIcon'"
                        fill-rule="evenodd" 
                        d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744l.708 2.836 2.836.708a1 1 0 01.054 1.91l-2.836.708-.708 2.836a1 1 0 01-1.91.054l-.708-2.836-2.836-.708a1 1 0 01-.054-1.91l2.836-.708.708-2.836A1 1 0 0112 2z" 
                        clip-rule="evenodd" 
                        />
                        
                        <!-- LightningBoltIcon -->
                        <path 
                        v-else-if="feature.icon === 'LightningBoltIcon'"
                        fill-rule="evenodd" 
                        d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744l.708 2.836 2.836.708a1 1 0 01.054 1.91l-2.836.708-.708 2.836a1 1 0 01-1.91.054l-.708-2.836-2.836-.708a1 1 0 01-.054-1.91l2.836-.708.708-2.836A1 1 0 0112 2z" 
                        clip-rule="evenodd" 
                        />
                    </svg>
                    </div>
                    <h3 
                    :class="[
                        'text-xl font-semibold',
                        themeStore.theme === 'light' 
                        ? 'text-gray-900' 
                        : 'text-white'
                    ]"
                    >
                    {{ feature.title }}
                    </h3>
                </div>
                <p 
                    :class="[
                    'text-base',
                    themeStore.theme === 'light' 
                        ? 'text-gray-700' 
                        : 'text-gray-300'
                    ]"
                >
                    {{ feature.description }}
                </p>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script setup>
  import { useThemeStore } from '../Stores/Theme';
  const themeStore = useThemeStore();
  
  // Why Choose Us features
  const whyChooseFeatures = [
    {
      icon: 'CheckBadgeIcon', 
      title: 'Trusted by Educators and Professionals',
      description: 'Millions rely on our technology to transform PDFs into actionable tools. Whether you\'re an educator crafting quizzes or a professional, our solutions are tailored to meet your needs.'
    },
    {
      icon: 'SparklesIcon',
      title: 'AI-Powered Efficiency',
      description: 'Our advanced AI does the heavy lifting, analyzing content to generate quizzes and solutions in seconds. Spend less time on repetitive tasks and more time focusing on what matters most.'
    },
    {
      icon: 'TrophyIcon',
      title: 'Global Recognition',
      description: 'Highly rated on platforms like Capterra, G2, and TrustPilot, our users consistently praise our simplicity, reliability, and efficiency.'
    },
    {
      icon: 'LightningBoltIcon',
      title: 'Built for Modern Needs',
      description: 'From educators creating assessments to teams managing documents, our tools are designed to simplify your workflow and deliver results effortlessly.'
    }
  ];
</script>
  
<style scoped>

</style>