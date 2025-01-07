<template>
    <div 
     :class="[
       'w-full mx-auto px-10 md:px-64 ',
       themeStore.theme === 'light' 
         ? 'bg-white text-black' 
         : 'bg-gray-900 text-gray-100'
     ]"
     >
         <div class="container mx-auto">
             <div class="text-center py-12 px-4">
             <h2 
                 :class="[
                 'text-2xl sm:text-3xl md:text-4xl font-bold mb-4',
                 themeStore.theme === 'light' 
                     ? 'text-gray-900' 
                     : 'text-white'
                 ]"
             >
                 Your All-in-One Document & Image Conversion Hub
             </h2>
             
             <p 
                 :class="[
                 'text-base sm:text-lg md:text-lg max-w-3xl mx-auto leading-relaxed',
                 themeStore.theme === 'light' 
                     ? 'text-gray-700' 
                     : 'text-gray-300'
                 ]"
             >
                 Transform your documents and images effortlessly with our powerful conversion tools. Whether you need to convert documents to PDF, optimize images, or create AI-powered quizzes, we've got you covered with our comprehensive suite of tools.
             </p>
             </div>
 
             <div class="space-y-16">
             <div 
                 v-for="(feature, index) in features" 
                 :key="index"
                 :class="[
                 'flex flex-col items-center justify-center gap-6 md:gap-12',
                 feature.imagePosition === 'left' 
                     ? 'md:flex-row' 
                     : 'md:flex-row-reverse'
                 ]"
             >
                 <div class="w-full md:w-1/2 mb-6 md:mb-0">
                 <img 
                     :src="feature.imageSrc" 
                     :alt="feature.imageAlt"
                     class="w-full max-w-md mx-auto h-auto rounded-lg shadow-lg object-cover"
                 />
                 </div>
                 
                 <div class="w-full md:w-1/2 text-center md:text-left space-y-4 px-4">
                 <h2 
                     :class="[
                     'text-xl sm:text-2xl md:text-3xl font-bold',
                     themeStore.theme === 'light' 
                         ? 'text-gray-900' 
                         : 'text-white'
                     ]"
                 >
                     {{ feature.headline }}
                 </h2>
                 
                 <p 
                     :class="[
                     'text-base md:text-lg leading-relaxed',
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
    </div>
 </template>
 
 <script setup>
 import { useThemeStore } from '../Stores/Theme';
 const themeStore = useThemeStore();
 
 // Feature data with alternating image positions
 const features = [
    {
        headline: 'AI-Powered Quiz Generator for Educators',
        description: 'Transform your study materials into engaging quizzes. Upload PDFs, DOCX, or TXT files, and let AI generate true or false, multiple choice, and identification questions tailored to your content. Save time and enhance learning with automated quiz creation.',
        imageSrc: 'https://s.smallpdf.com/static/ef11cdb756ac0c94.svg',
        imageAlt: 'AI Quiz Generator',
        imagePosition: 'left'
    },
    {
        headline: 'Smart Document Analysis for Question Generation',
        description: 'Leverage AI to extract key concepts and insights from your uploaded documents. The system identifies important details to craft precise questions, ensuring quizzes reflect the core material for accurate assessments.',
        imageSrc: 'https://s.smallpdf.com/static/ef11cdb756ac0c94.svg',
        imageAlt: 'AI Document Analysis',
        imagePosition: 'right'
    },
    {
        headline: 'Versatile Document Conversion for Quiz Input',
        description: 'Easily convert PDFs, DOCX, and TXT files to prepare content for quiz generation. Our tool ensures accurate text extraction, preserving formatting and essential information for seamless AI processing.',
        imageSrc: 'https://s.smallpdf.com/static/ef11cdb756ac0c94.svg',
        imageAlt: 'Document Converter',
        imagePosition: 'left'
    },
    {
        headline: 'Generate Printable PDF Quizzes with Ease',
        description: 'Export AI-generated quizzes as polished PDF documents. Ready for printing or digital sharing, the PDFs maintain clear formatting and professional design, streamlining the assessment process.',
        imageSrc: 'https://s.smallpdf.com/static/ef11cdb756ac0c94.svg',
        imageAlt: 'PDF Quiz Export',
        imagePosition: 'right'
    },
];

 </script>
 
 <style scoped>
 
 </style>