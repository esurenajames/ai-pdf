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
                Frequently Asked Questions
            </h2>
            <p 
                :class="[
                'text-lg max-w-2xl mx-auto',
                themeStore.theme === 'light' 
                    ? 'text-gray-700' 
                    : 'text-gray-300'
                ]"
            >
                Got questions? We've got answers. Find out everything you need to know about our PDF transformation tools.
            </p>
            </div>

            <div class="max-w-4xl mx-auto space-y-4">
            <div 
                v-for="(faq, index) in faqs" 
                :key="index"
                class="border rounded-lg overflow-hidden"
                :class="[
                themeStore.theme === 'light'
                    ? 'border-gray-200 bg-white' 
                    : 'border-gray-700 bg-gray-800'
                ]"
            >
                <div 
                @click="toggleFAQ(index)"
                :class="[
                    'flex justify-between items-center p-4 cursor-pointer transition duration-300 ease-in-out',
                    themeStore.theme === 'light'
                    ? 'hover:bg-gray-50' 
                    : 'hover:bg-gray-700'
                ]"
                >
                <h3 
                    :class="[
                    'text-lg font-semibold',
                    themeStore.theme === 'light' 
                        ? 'text-gray-900' 
                        : 'text-white'
                    ]"
                >
                    {{ faq.question }}
                </h3>
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    class="h-6 w-6 transition-transform duration-300" 
                    :class="[
                    openFAQ === index ? 'rotate-180' : '',
                    themeStore.theme === 'light' 
                        ? 'text-gray-600' 
                        : 'text-gray-300'
                    ]"
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor"
                >
                    <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    d="M19 9l-7 7-7-7" 
                    />
                </svg>
                </div>
                
                <div 
                v-if="openFAQ === index" 
                :class="[
                    'p-4 border-t',
                    themeStore.theme === 'light'
                    ? 'bg-gray-50 border-gray-200' 
                    : 'bg-gray-800 border-gray-700'
                ]"
                >
                <p 
                    :class="[
                    'text-base',
                    themeStore.theme === 'light' 
                        ? 'text-gray-700' 
                        : 'text-gray-300'
                    ]"
                >
                    {{ faq.answer }}
                </p>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useThemeStore } from '../Stores/Theme';

const themeStore = useThemeStore();

// FAQs data
const faqs = [
  {
    question: 'What is the purpose of this app?',
    answer: 'Our app is designed to simplify your work with PDF documents. Whether you\'re creating quizzes from educational materials, managing digital documents, or converting PDFs, our AI-powered tools make the process seamless and efficient.'
  },
  {
    question: 'How does the PDF-to-Quiz feature work?',
    answer: 'The PDF-to-Quiz feature uses advanced AI algorithms to analyze the content of your uploaded PDF. It identifies key topics and generates quiz questions based on the material, saving you hours of manual work.'
  },
  {
    question: 'Can I customize the quizzes generated from PDFs?',
    answer: 'Yes, you can! After the quiz is generated, you can review the questions, adjust the difficulty level, and specify the type and number of questions (e.g., multiple-choice, true/false, etc.).'
  },
  {
    question: 'Is the app suitable for educators only?',
    answer: 'Not at all! While educators can benefit greatly from features like PDF-to-Quiz, professionals and students can use the app for other tasks like document conversion, management, and optimization.'
  },
  {
    question: 'What file formats are supported for conversion?',
    answer: 'We support a variety of formats including Word, Excel, PowerPoint, and images (JPG/PNG). You can easily convert them to and from PDF using our tools.'
  },
  {
    question: 'How secure is my data?',
    answer: 'Your data security is our top priority. We use 256-bit TLS encryption to ensure secure file transfers. Additionally, we comply with GDPR, CCPA, and other data protection standards.'
  },
  {
    question: 'Can I access the app on different devices?',
    answer: 'Yes! Our app is web-based and optimized for desktop, tablet, and mobile devices, allowing you to work on your files anytime, anywhere.'
  },
  {
    question: 'Do you offer customer support?',
    answer: 'Absolutely. We provide 24/7 customer support to ensure all your questions and concerns are addressed promptly.'
  },
  {
    question: 'What are the benefits of using this app for quiz generation?',
    answer: 'By automating the quiz-making process, our app saves time and ensures accuracy. Educators can focus on teaching, and learners benefit from well-structured assessments.'
  }
];

// Manage which FAQ is currently open
const openFAQ = ref(null);

const toggleFAQ = (index) => {
  if (openFAQ.value === index) {
    openFAQ.value = null;
  } else {
    openFAQ.value = index;
  }
};
</script>

<style scoped>

</style>