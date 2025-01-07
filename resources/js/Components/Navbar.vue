<template>
  <nav
    :class="[
      themeStore.theme === 'light' ? 'bg-white text-black border-b-[1px] border-gray-200' : 'bg-gray-800 text-gray-300 border-b-[1px] border-gray-700 ',
      'p-4 flex items-center justify-between fixed top-0 z-50 left-0 w-full tracking-wide'
    ]"
  >
    <!-- Desktop View -->
    <div class="hidden md:flex items-center justify-between w-full">
      <!-- Left Section -->
      <div class="flex items-center space-x-4">
        <Link 
          :href="route('home')"  
          class="text-lg font-bold cursor-pointer"
        >
          Brand
        </Link>
        <template v-for="(link, index) in leftNavLinks" :key="index">
          <Link
            v-if="!isAuthenticated" 
            :href="link.href" 
            class="hover:opacity-50"
          >
            {{ link.name }}
          </Link>
        </template>
      </div>
      
      <!-- Right Section -->
      <div class="flex items-center space-x-4">
        <template v-for="(link, index) in computedRightNavLinks" :key="index">
          <div v-if="link.name === 'Login'" class="border-r-2 border-gray-400 h-10 opacity-35 mx-2"></div>
          <Link 
            :href="link.href" 
            class="hover:opacity-50"
          >
            {{ link.name }}
          </Link>
        </template>
        
        <Link
          v-if="!isAuthenticated"
          :href="route('signup')"  
          class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
        >
          Sign Up
        </Link>
        

        <div v-if="isAuthenticated" class="relative profile-dropdown">
          <!-- Clickable area for image, name, and email -->
          <button 
            @click="toggleDropdown" 
            :class="[
              'flex items-center space-x-3 rounded-md focus:outline-none transition-colors',
              themeStore.theme === 'light' 
                ? 'bg-white text-black' 
                : 'bg-gray-800  text-gray-200'
            ]"
          >
            <!-- Profile Image -->
            <img 
              src="https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3407.jpg?w=360" 
              alt="Profile" 
              class="w-10 h-10 rounded-full"
            />

            <!-- User Info -->
            <div :class="['text-left']">
              <!-- User Name with dynamic color -->
              <p 
                :class="themeStore.theme === 'light' 
                  ? 'text-black font-semibold' 
                  : 'text-white font-semibold'"
                class="text-sm"
              >
                {{ userName }}
              </p>

              <!-- User Email with dynamic color -->
              <p 
                :class="themeStore.theme === 'light' 
                  ? 'text-gray-700' 
                  : 'text-gray-400'"
                class="text-xs"
              >
                {{ userEmail }}
              </p>
            </div>
          </button>

          <!-- Dropdown Menu -->
          <div 
            v-if="dropdownOpen" 
            class="absolute right-0 mt-2 w-auto min-w-[200px] bg-white border rounded-md shadow-lg"
            :class="themeStore.theme === 'light' 
              ? 'text-black' 
              : 'text-gray-200'"
          >
            <ul class="py-2">
              <li>
                <Link 
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  Profile
                </Link>
              </li>
              <li>
                <Link 
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  Settings
                </Link>
              </li>
              <li>
                <Link 
                  :href="route('logout')" 
                  method="post" 
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  Logout
                </Link>
              </li>
            </ul>
          </div>
        </div>

        <button
          @click="toggleTheme"
          class="relative w-16 h-8 rounded-full transition-colors duration-300 ease-in-out"
          :class="{
            'bg-gray-200 border-2 border-gray-300': themeStore.theme === 'light',
            'bg-gray-700 border-2 border-gray-600': themeStore.theme === 'dark'
          }"
          aria-label="Toggle theme"
        >
          <span 
            class="absolute top-1/2 -translate-y-1/2 w-6 h-6 rounded-full transition-all duration-300 ease-in-out flex items-center justify-center"
            :class="{
              'left-1 bg-yellow-400': themeStore.theme === 'light',
              'right-1 bg-white': themeStore.theme === 'dark'
            }"
          >
            <svg 
              v-if="themeStore.theme === 'light'" 
              xmlns="http://www.w3.org/2000/svg" 
              width="16" 
              height="16" 
              viewBox="0 0 24 24" 
              fill="none" 
              stroke="currentColor" 
              stroke-width="2" 
              stroke-linecap="round" 
              stroke-linejoin="round" 
              class="text-white"
            >
              <circle cx="12" cy="12" r="5" />
              <path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4" />
            </svg>
            <svg 
              v-else 
              xmlns="http://www.w3.org/2000/svg" 
              width="16" 
              height="16" 
              viewBox="0 0 24 24" 
              fill="none" 
              stroke="currentColor" 
              stroke-width="2" 
              stroke-linecap="round" 
              stroke-linejoin="round" 
              class="text-gray-800"
            >
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
            </svg>
          </span>
        </button>
      </div>
    </div>

     <!-- Mobile View -->
     <div class="md:hidden flex items-center justify-between w-full">
      <div class="text-lg font-bold">Brand</div>
      
      <div class="flex items-center space-x-4 ">
        <button
          @click="toggleTheme"
          class="relative w-16 h-8 rounded-full transition-colors duration-300 ease-in-out"
          :class="{
            'bg-gray-200 border-2 border-gray-300': themeStore.theme === 'light',
            'bg-gray-700 border-2 border-gray-600': themeStore.theme === 'dark'
          }"
          aria-label="Toggle theme"
        >
          <span 
            class="absolute top-1/2 -translate-y-1/2 w-6 h-6 rounded-full transition-all duration-300 ease-in-out flex items-center justify-center"
            :class="{
              'left-1 bg-yellow-400': themeStore.theme === 'light',
              'right-1 bg-white': themeStore.theme === 'dark'
            }"
          >
            <svg 
              v-if="themeStore.theme === 'light'" 
              xmlns="http://www.w3.org/2000/svg" 
              width="16" 
              height="16" 
              viewBox="0 0 24 24" 
              fill="none" 
              stroke="currentColor" 
              stroke-width="2" 
              stroke-linecap="round" 
              stroke-linejoin="round" 
              class="text-white"
            >
              <circle cx="12" cy="12" r="5" />
              <path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4" />
            </svg>
            <svg 
              v-else 
              xmlns="http://www.w3.org/2000/svg" 
              width="16" 
              height="16" 
              viewBox="0 0 24 24" 
              fill="none" 
              stroke="currentColor" 
              stroke-width="2" 
              stroke-linecap="round" 
              stroke-linejoin="round" 
              class="text-gray-800"
            >
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
            </svg>
          </span>
        </button>

        <button 
          @click="toggleMobileMenu" 
          class="focus:outline-none"
          aria-label="Toggle mobile menu"
        >
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            width="24" 
            height="24" 
            viewBox="0 0 24 24" 
            fill="none" 
            stroke="currentColor" 
            stroke-width="2" 
            stroke-linecap="round" 
            stroke-linejoin="round"
          >
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div 
      v-if="mobileMenuOpen"
      class="fixed inset-0 z-30 md:hidden"
      :class="themeStore.theme === 'light' ? 'bg-white' : 'bg-gray-900'"
    >
      <div 
        class="flex flex-col h-full p-6"
        :class="themeStore.theme === 'light' ? 'text-black' : 'text-white'"
      >
        <div class="flex justify-between items-center mb-8">
          <div class="text-lg font-bold">Brand</div>
          <button 
            @click="toggleMobileMenu" 
            class="focus:outline-none"
            aria-label="Close mobile menu"
          >
            <svg 
              xmlns="http://www.w3.org/2000/svg" 
              width="24" 
              height="24" 
              viewBox="0 0 24 24" 
              fill="none" 
              stroke="currentColor" 
              stroke-width="2" 
              stroke-linecap="round" 
              stroke-linejoin="round"
            >
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>

        <div class="space-y-6">
          <!-- Left Nav Links -->
          <div class="space-y-4" v-if="!isAuthenticated">
            <h3 :class="themeStore.theme === 'light' ? 'text-sm font-semibold opacity-50' : 'text-sm font-semibold text-gray-300'">Navigation</h3>
            <template v-for="(link, index) in leftNavLinks" :key="index">
              <Link 
                :href="link.href" 
                class="block py-2 hover:opacity-50"
                @click="toggleMobileMenu"
              >
                {{ link.name }}
              </Link>
            </template>
          </div>

          <!-- Right Nav Links -->
          <div class="space-y-4" v-if="!isAuthenticated">
            <h3 :class="themeStore.theme === 'light' ? 'text-sm font-semibold opacity-50' : 'text-sm font-semibold text-gray-300'">More</h3>
            <template v-for="(link, index) in computedRightNavLinks" :key="index">
              <Link 
                :href="link.href" 
                class="block py-2 hover:opacity-50" 
                :class="link.name === 'Login' ? 'hidden sm:block' : ''" 
                @click="toggleMobileMenu"
              >
                {{ link.name }}
              </Link>
            </template>
          </div>

          <!-- Profile Section (only for authenticated users) -->
          <div v-if="isAuthenticated" class="space-y-6 text-center">
            <!-- Profile Image and Information -->
            <img 
              :src="'https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3407.jpg?w=360'" 
              alt="Profile" 
              class="w-20 h-20 rounded-full mx-auto mb-2"
            />
            <p :class="themeStore.theme === 'light' ? 'text-sm font-semibold' : 'text-sm font-semibold text-gray-300'">{{ userName }}</p>
            <p :class="themeStore.theme === 'light' ? 'text-xs text-gray-600' : 'text-xs text-gray-400'">{{ userEmail }}</p>

            <!-- Links for Account, Settings, and Logout -->
            <div class="space-y-4 mt-4">
              <Link 
                :href="route('dashboard')" 
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200"
                :class="themeStore.theme === 'light' ? 'hover:bg-gray-200' : 'hover:bg-gray-700'"
                @click="toggleMobileMenu"
              >
                Account
              </Link>
              <Link 
                :href="route('dashboard')" 
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200"
                :class="themeStore.theme === 'light' ? 'hover:bg-gray-200' : 'hover:bg-gray-700'"
                @click="toggleMobileMenu"
              >
                Settings
              </Link>
            </div>
          </div>

          <!-- Conditional Sign Up / Logout -->
          <div class="space-y-4">
            <!-- Sign Up (only for guests) -->
            <Link 
              v-if="!isAuthenticated"
              :href="route('login')"   
              class="block w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-center"
              @click="toggleMobileMenu"
            >
              Login
            </Link>
            <Link 
              v-if="!isAuthenticated"
              :href="route('signup')"  
              class="block w-full px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-center"
            >
              Sign Up
            </Link>

            <!-- Logout (only for authenticated users) -->
            <Link 
              v-if="isAuthenticated"
              :href="route('logout')" 
              method="post" 
              as="button" 
              class="block w-full px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-center"
              @click="toggleMobileMenu"
            >
              Logout
            </Link>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { useThemeStore } from '../Stores/Theme';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted, onBeforeUnmount } from 'vue';

// Access the page props using usePage
const page = usePage();

const userName = computed(() => page.props.auth?.user?.name ?? 'Guest');
const userEmail = computed(() => page.props.auth?.user?.email ?? 'guest@example.com');

const mobileMenuOpen = ref(false);
const dropdownOpen = ref(false); // Controls the visibility of the profile dropdown

const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value;
};

const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value;
};

const closeDropdown = () => {
  dropdownOpen.value = false;
};

const handleOutsideClick = (event) => {
  if (!event.target.closest('.profile-dropdown')) {
    closeDropdown();
  }
};

onMounted(() => {
  document.addEventListener('click', handleOutsideClick);
});

onBeforeUnmount(() => {
  document.removeEventListener('click', handleOutsideClick);
});

const themeStore = useThemeStore();

const isAuthenticated = computed(() => {
  return page.props.auth && page.props.auth.user !== null;
});

const toggleTheme = () => {
  themeStore.toggleTheme();
};

const leftNavLinks = [
  { 
    name: "Quiz Maker", 
    href: "#" 
  },
  { 
    name: "Convert PDF", 
    href: "#" 
  },
];

const computedRightNavLinks = computed(() => {
  if (!isAuthenticated.value) {
    return [
      {
        name: "Pricing", 
        href: "#" 
      },
      { 
        name: "Teams", 
        href: "#" 
      },
      { 
        name: "Login", 
        href: route('login') 
      },
    ];
  }
});
</script>


<style scoped>
.transition-colors {
  transition: background-color 0.3s ease;
}
body.mobile-menu-open {
  overflow: hidden;
}
</style>