<template>
  <!-- Sidebar -->
  <div 
    v-if="page.props.auth?.user" 
    class="fixed left-0 top-0 h-full py-6 px-4 z-10"
    :class="themeStore.theme === 'light' 
    ? 'bg-white border-r border-gray-200' 
    : 'bg-gray-800 border-r border-gray-700'"
  >
    <div class="flex flex-col h-full">
      <!-- Top Navigation Items -->
      <div class="flex flex-col space-y-6 items-center flex-grow pt-14">
        <!-- Navigation Links -->
        <template v-for="(item, index) in navigationItems" :key="index">
          <Link 
            :href="item.href" 
            class="flex flex-col items-center p-2 w-full"
            :class="[
              themeStore.theme === 'light' 
                ? 'hover:bg-gray-200' 
                : 'hover:bg-gray-700',
              isActiveRoute(item.routeName) 
                ? (themeStore.theme === 'light' 
                    ? 'bg-gray-200 text-black' 
                    : 'bg-gray-700 text-white'
                  ) 
                : ''
            ]"
          >
            <img 
              :src="themeStore.theme === 'light' ? item.iconLight : item.iconDark" 
              :alt="item.name" 
              class="w-6 h-6 mb-2" 
            />
            <span 
              class="text-xs text-center"
              :class="themeStore.theme === 'light' ? 'text-black' : 'text-white'"
            >
              {{ item.name }}
            </span>
          </Link>
        </template>
      </div>

      <!-- Account Section -->
      <div 
        class="flex flex-col items-center pt-6 border-t transition-colors duration-300"
        :class="themeStore.theme === 'light' 
        ? 'border-gray-200 bg-white' 
        : 'border-gray-700 bg-gray-800'"
      >
        <img 
          :src="userProfileImage" 
          alt="Profile" 
          class="w-12 h-12 rounded-full mb-2"
        />
        <span 
          class="text-xs text-center"
          :class="themeStore.theme === 'light' ? 'text-black' : 'text-white'"
        >
          Account
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { useThemeStore } from '../Stores/Theme';
import { computed } from 'vue';

// Import custom icons
import darkQuizIcon from '../Assets/Sidebar/dark-quiz-maker-icon.png';
import quizIcon from '../Assets/Sidebar/quiz-maker-icon.png';
import darkPdfConvertIcon from '../Assets/Sidebar/dark-pdfconvert-icon.png';
import pdfConvertIcon from '../Assets/Sidebar/pdfconvert-icon.png';
import dashboardIcon from '../Assets/Sidebar/dashboard-icon.png';
import darkDashboardIcon from '../Assets/Sidebar/dark-dashboard-icon.png';
import webpIcon from '../Assets/Sidebar/webp-icon.png';
import darkWebpIcon from '../Assets/Sidebar/dark-webp-icon.png';

// Theme Store
const themeStore = useThemeStore();

// Page Context
const page = usePage();

// User Information
const userName = computed(() => page.props.auth?.user?.name ?? 'Guest');

// Default Profile Image
const userProfileImage = computed(() => 
  page.props.auth?.user?.profile_image ?? 
  'https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3407.jpg?w=360'
);

// Navigation Items
const navigationItems = [
  {
    name: 'Dashboard',
    href: route('dashboard'),
    routeName: 'dashboard',
    iconLight: dashboardIcon,
    iconDark: darkDashboardIcon,
    component: 'Dashboard/Index'
  },
  {
    name: 'Quiz Maker',
    href: route('quiz'),
    routeName: 'quiz',
    iconLight: quizIcon,
    iconDark: darkQuizIcon,
    component: 'Quiz/Index'
  },
  {
    name: 'Convert PDF',
    href: route('convert'),
    routeName: 'convert',
    iconLight: pdfConvertIcon,
    iconDark: darkPdfConvertIcon,
    component: 'Convert/Index'
  },
  {
    name: 'Convert WebP',
    href: route('image'),
    routeName: 'image',
    iconLight: webpIcon,
    iconDark: darkWebpIcon,
    component: 'image/Index'
  }
];

// Check if the current route is active
const isActiveRoute = (routeName) => {
  return page.url.includes(routeName); 
};
</script>
