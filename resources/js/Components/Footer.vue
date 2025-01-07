<template>
  <footer 
    :class="[
      'pt-12 pb-8 px-4',
      themeStore.theme === 'light' 
        ? 'bg-gray-100 text-gray-900' 
        : 'bg-gray-800 text-gray-100'
    ]"
  >
    <div class="container mx-auto grid md:grid-cols-4 gap-8">
      <div class="col-span-1">
        <div class="flex items-center mb-4">
          <h3 class="text-xl font-bold">Brand</h3>
        </div>
        <p 
          :class="[
            'text-sm mb-4',
            themeStore.theme === 'light' 
              ? 'text-gray-600' 
              : 'text-gray-400'
          ]"
        >
          Transform your PDFs with AI-powered tools. Simplify document management, create quizzes, and boost productivity.
        </p>
        
        <div class="flex space-x-4">
          <a 
            v-for="social in socialLinks" 
            :key="social.name"
            :href="social.link"
            target="_blank"
            :class="[
              'hover:opacity-75 transition-opacity',
              themeStore.theme === 'light' 
                ? 'text-gray-700' 
                : 'text-gray-300'
            ]"
          >
          <img 
            :src="themeStore.theme === 'light' ? social.lightIcon : social.darkIcon" 
            :alt="social.name" 
            class="w-7 h-7"
          />
          </a>
        </div>
      </div>

      <div 
        v-for="(links, category) in footerLinks" 
        :key="category" 
        class="col-span-1"
      >
        <h4 
          :class="[
            'font-bold mb-4',
            themeStore.theme === 'light' 
              ? 'text-gray-900' 
              : 'text-white'
          ]"
        >
          {{ category }}
        </h4>
        <ul class="space-y-2">
          <li 
            v-for="link in links" 
            :key="link.name"
          >
            <a 
              :href="link.link"
              :class="[
                'hover:underline text-sm',
                themeStore.theme === 'light' 
                  ? 'text-gray-600 hover:text-gray-900' 
                  : 'text-gray-400 hover:text-white'
              ]"
            >
              {{ link.name }}
            </a>
          </li>
        </ul>
      </div>
    </div>

    <div 
      :class="[
        'mt-8 pt-6 border-t text-center',
        themeStore.theme === 'light'
          ? 'border-gray-200 text-gray-600'
          : 'border-gray-700 text-gray-400'
      ]"
    >
      <p class="text-sm">
        © {{ currentYear }} Brand. All rights reserved.
      </p>
    </div>
  </footer>
</template>

<script setup>
import { useThemeStore } from '../Stores/Theme';
import gmailIcon from '../Assets/Footer/icons8-gmail-50.png';
import githubIcon from '../Assets/Footer/icons8-github-50.png';
import instagramIcon from '../Assets/Footer/icons8-instagram-60.png';
import linkedinIcon from '../Assets/Footer/icons8-linkedin-50.png';
import lightgmailIcon from '../Assets/Footer/social-gmail.png';
import lightgithubIcon from '../Assets/Footer/social-github.png';
import lightinstagramIcon from '../Assets/Footer/social-instagram.png';
import lightlinkedinIcon from '../Assets/Footer/social-linkedin.png';
const themeStore = useThemeStore();

const currentYear = new Date().getFullYear();

const socialLinks = [
  { 
    lightIcon: lightgmailIcon,
    darkIcon: gmailIcon,
    link: 'mailto:esurenajames@gmail.com',
    name: 'Gmail'
  },
  { 
    lightIcon: lightgithubIcon,
    darkIcon: githubIcon,
    link: 'https://github.com/esurenajames',
    name: 'GitHub'
  },
  { 
    lightIcon: lightinstagramIcon,
    darkIcon: instagramIcon,
    link: 'https://instagram.com/cinnamonesurena',
    name: 'Instagram'
  },
  { 
    lightIcon: lightlinkedinIcon,
    darkIcon: linkedinIcon,
    link: 'https://linkedin.com/esurenajames',
    name: 'LinkedIn'
  }
];

const footerLinks = {
  Product: [
    { name: 'Features', link: '#features' },
    { name: 'Quiz Generator', link: '#quiz-generator' },
    { name: 'PDF Converter', link: '#pdf-converter' },
    { name: 'Pricing', link: '#pricing' }
  ],
  Company: [
    { name: 'About Us', link: '#about' },
    { name: 'Careers', link: '#careers' },
    { name: 'Press', link: '#press' },
    { name: 'Contact', link: '#contact' }
  ],
  Resources: [
    { name: 'Blog', link: '#blog' },
    { name: 'Help Center', link: '#help' },
    { name: 'Tutorials', link: '#tutorials' },
    { name: 'API Docs', link: '#api' }
  ]
};
</script>

<style>

</style>